@extends('boilerplate::layout.index', [
    'title' => 'List phone contacts',
    'subtitle' => 'Daftar phone contacts',
    'breadcrumb' => ['List contacts']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            <x-boilerplate::datatable name="phonecontacts" :ajax="['book_id' => $id]" />
        @endcomponent
    </div>
</div>
@endsection