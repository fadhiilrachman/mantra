<?php

namespace App\Imports;

use App\Models\PhoneContacts;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PhoneContactsImport implements ToCollection
{
    protected $phoneBookId;
    protected $userId;

    public function __construct($phoneBookId, $userId)
    {
        $this->phoneBookId = $phoneBookId;
        $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $insertRow = [];
            if (!empty($row[0])) {
                $insertRow['number'] = $row[0];
            }
            if (!empty($row[1])) {
                $insertRow['name'] = $row[1];
            }

            $phoneContact = new PhoneContacts($insertRow);
            $phoneContact->book_id = $this->phoneBookId;
            $phoneContact->user_id = $this->userId;
            $phoneContact->save();
        }
    }
}