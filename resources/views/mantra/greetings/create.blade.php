@extends('boilerplate::layout.index', [
    'title' => 'Create new template',
    'subtitle' => 'Buat baru template awal percakapan',
    'breadcrumb' => ['Create new template']]
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