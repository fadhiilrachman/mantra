@extends('boilerplate::layout.index', [
    'title' => 'Active agents',
    'subtitle' => 'Daftar bot agent yang aktif',
    'breadcrumb' => ['List active agents']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            <x-boilerplate::datatable name="botagents_active" />
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