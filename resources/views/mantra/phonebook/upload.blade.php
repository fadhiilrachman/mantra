@extends('boilerplate::layout.index', [
    'title' => 'Upload new book',
    'subtitle' => 'Buat dan unggah phone book baru',
    'breadcrumb' => ['Upload new book']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            @component('boilerplate::form', ['route' => 'mantra.phonebook.upload.post', 'method' => 'post', 'enctype' => 'multipart/form-data'])
                @component('boilerplate::input', ['name' => 'title', 'label' => 'Book title', 'help' => 'Tulis judul phone book', 'required'])@endcomponent
                <div class="form-group">
                    <label>Phone numbers files</label>
                    <input required id="files" name="files[]" type="file" class="file" multiple accept=".xlsx, .xls, .csv">
                    @include('boilerplate::load.fileinput')
                    <small class="form-text text-muted">Lampirkan file Excel (.xlsx, .xls, .csv)</small>
                    @push('js')
                        <script>
                            $("#files").fileinput({
                                showUpload: false,
                                showPreview: false,
                                dropZoneEnabled: false,
                                maxFileCount: 10,
                            });
                        </script>
                    @endpush
                </div>
                <div class="row">
                    <div class="col-12 pt-2 text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload mr-1"></i> Upload now</button>
                    </div>
                </div>
            @endcomponent
        @endcomponent
    </div>
</div>
@endsection

@if(session('error'))
    @push('js')
        <script>
            growl('{{ session('error') }}', 'error')
        </script>
    @endpush
@endif