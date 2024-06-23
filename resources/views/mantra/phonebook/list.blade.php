@extends('boilerplate::layout.index', [
    'title' => 'List book',
    'subtitle' => 'Daftar phone book',
    'breadcrumb' => ['List book']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            <x-boilerplate::datatable name="phonebooks" />
        @endcomponent
    </div>
</div>
@endsection

@if(session('success'))
    @push('js')
        <script>
            growl('{{ session('success') }}', 'success')
        </script>
    @endpush
@endif

@if(session('error'))
    @push('js')
        <script>
            growl('{{ session('error') }}', 'error')
        </script>
    @endpush
@endif