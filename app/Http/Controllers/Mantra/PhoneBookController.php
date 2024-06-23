<?php

namespace App\Http\Controllers\Mantra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\PhoneContactsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PhoneBooks;
use App\Models\PhoneContacts;
use Illuminate\Support\Facades\Auth;
use Validator;

class PhoneBookController extends Controller
{
    public function listBook()
    {
        return view('mantra.phonebook.list');
    }

    public function listPhoneContacts($uuid)
    {
        $id = PhoneBooks::select('id')->where('uuid', $uuid)->first();

        if (!$id) {
            abort(404, 'Phone book not found.');
        }

        return view('mantra.phonebook.phonecontact.list', compact('id'));
    }

    public function uploadBook()
    {
        return view('mantra.phonebook.upload');
    }

    public function deletePhoneBook($uuid)
    {
        $phoneBook = PhoneBooks::where('uuid', $uuid)->first();

        if (!$phoneBook) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => $phoneBook->delete() ?? false]);
    }

    public function deletePhoneContact($uuid)
    {
        $phoneContact = PhoneContacts::where('uuid', $uuid)->first();

        if (!$phoneContact) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => $phoneContact->delete() ?? false]);
    }

    public function uploadPhoneContacts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'files.*' => 'required|mimes:xls,xlsx,csv',
        ]);

        if ($validator->fails()) {
            return redirect()->route('mantra.phonebook.upload')->with('error', $validator->errors()->first());
        }

        $title = $request->input('title');
        $user = Auth::user();

        $phoneBook = PhoneBooks::create([
            'title' => $title,
            'user_id' => $user->id,
        ]);

        $files = $request->file('files');

        foreach ($files as $file) {
            $import = new PhoneContactsImport($phoneBook->id, $user->id);
            try {
                Excel::import($import, $file);
            } catch (\Exception $e) {
                return redirect()->route('mantra.phonebook.upload')->with('error', $e->getMessage());
            }
        }

        return redirect()->route('mantra.phonebook.list')->with('success', 'Data imported successfully!');
    }
}
