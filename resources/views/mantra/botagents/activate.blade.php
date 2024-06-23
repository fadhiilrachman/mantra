@extends('boilerplate::layout.index', [
    'title' => 'Activate agent',
    'subtitle' => 'Aktivasi bot agent',
    'breadcrumb' => ['Activate agent']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
            <div id="elemqr">
                <div class="alert alert-info">
                    Please scan this QR Code with your WhatsApp mobile app!
                </div>
                <p><img src="{{ $imgUrl }}" alt="Loading..." id="qrcode"></p>
            </div>
            <p id="timer">
                Time remaining: <span id="seconds">0</span> seconds
            </p>
        @endcomponent
    </div>
</div>
@endsection

@push('js')
    <script>
        let currentSrc = $('#qrcode').attr('src');

        function refreshImage() {
            let newSrc = currentSrc + '?' + Math.random();
            $('#qrcode').attr('src', newSrc);
        }

        function checkStatus() {
            $.ajax({
                url: '{{ route('mantra.botagents.detail.json', $uuid) }}',
                type: 'GET',
                success: function(data) {
                    console.log('Data received:', data);
                    if (data.is_active) {
                        growl('Successfully authenticated to WhatsApp!', 'success');
                        clearInterval(timerInterval);
                        $('#timer').text('You will be redirecting...');
                        $('#elemqr').hide();
                        setTimeout(function() {
                            window.location.href = '{{ route('mantra.botagents.active') }}';
                        }, 2000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error);
                }
            });
        }

        var secondsLeft = 300;
        function updateTimer() {
            $('#seconds').text(secondsLeft);
            refreshImage();
            checkStatus();
            secondsLeft--;
            if (secondsLeft < 0) {
                clearInterval(timerInterval);
                $('#timer').text('QR Code expired! Please refresh this page to try again.');
                $('#elemqr').hide();
            }
        }

        var timerInterval = setInterval(updateTimer, 1000);
    </script>
@endpush