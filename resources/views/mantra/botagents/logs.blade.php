@extends('boilerplate::layout.index', [
    'title' => 'Logs',
    'subtitle' => 'Log bot agent',
    'breadcrumb' => ['Logs']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            <x-boilerplate::datatable name="hooklogs" />
        @endcomponent
    </div>
</div>
@endsection