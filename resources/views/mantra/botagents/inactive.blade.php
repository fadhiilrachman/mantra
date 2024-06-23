@extends('boilerplate::layout.index', [
    'title' => 'Inactive agents',
    'subtitle' => 'Daftar bot agent yang tidak aktif',
    'breadcrumb' => ['List inactive agents']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            <x-boilerplate::datatable name="botagents_inactive" />
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