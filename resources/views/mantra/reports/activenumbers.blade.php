@extends('boilerplate::layout.index', [
    'title' => 'Active numbers',
    'subtitle' => 'Laporan daftar nomor aktif',
    'breadcrumb' => ['Active numbers']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            -
        @endcomponent
    </div>
</div>
@endsection