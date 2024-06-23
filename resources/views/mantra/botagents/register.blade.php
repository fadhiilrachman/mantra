@extends('boilerplate::layout.index', [
    'title' => 'Register new agent',
    'subtitle' => 'Buat bot agen baru',
    'breadcrumb' => ['Register new agent']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            @component('boilerplate::form', ['route' => 'mantra.botagents.register.post', 'method' => 'post', 'enctype' => 'multipart/form-data'])
                @component('boilerplate::input', ['name' => 'whatsapp_number', 'label' => 'WhatsApp number', 'help' => 'Isi nomor WhatsApp yang aktif', 'placeholder' => '62812xxxxxxxx', 'required'])@endcomponent
                @component('boilerplate::select2', ['name' => 'book_id[]', 'label' => 'Phone book', 'multiple' => true, 'help' => 'Dapat pilih lebih dari satu', 'required'])
                    @foreach ($phoneBooks as $item)
                        <option value="{{$item->uuid}}">{{$item->title}}</option>
                    @endforeach
                @endcomponent
                @component('boilerplate::select2', ['name' => 'access_type', 'label' => 'Access Type', 'help' => 'Hanya dapat pilih satu', 'required'])
                    <option value="invitation">Invitation only</option>
                    {{-- invite by code and send link invitation or invitation by group contact --}}
                    <option value="public">Public</option>
                @endcomponent
                @component('boilerplate::select2', ['name' => 'conversation_model', 'label' => 'Conversation model', 'help' => 'Hanya dapat pilih satu', 'required'])
                    <option value="simsimi">SimSimi</option>
                    {{-- <option value="claude">Claude</option> --}}
                    <option value="chatgpt">ChatGPT</option>
                @endcomponent
                <div class="row">
                    <div class="col-12 pt-2 text-center">
                        <button type="submit" class="btn btn-primary">Register now</button>
                    </div>
                </div>
            @endcomponent
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