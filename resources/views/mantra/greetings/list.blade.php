@extends('boilerplate::layout.index', [
    'title' => 'List template',
    'subtitle' => 'Daftar template awal percakapan',
    'breadcrumb' => ['List template']]
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