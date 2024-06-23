@extends('boilerplate::layout.index', [
    'title' => 'Log detail',
    'subtitle' => 'Detil log bot agent',
    'breadcrumb' => ['Log detail']]
)

@section('content')
<div class="row">
    <div class="col-md-12">
        @component('boilerplate::card')
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="logDetail" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="summary-tab" data-toggle="pill" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Summary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="payload-tab" data-toggle="pill" href="#payload" role="tab" aria-controls="payload" aria-selected="false">Payload</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="logDetailContents">
                    <div class="tab-pane fade active show" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Session ID</th>
                                        <th>Data Type</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $log->session_id }}</td>
                                        <td>{{ $log->type }}</td>
                                        <td>
                                            <code>{!! $log->data !!}</code>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="payload" role="tabpanel" aria-labelledby="payload-tab">
                        @php
                            $beautifiedJson = json_encode(json_decode($log->payload), JSON_PRETTY_PRINT);
                        @endphp
                        <pre>{!! $beautifiedJson !!}</pre>
                    </div>
                </div>
            </div>
        </div>
        @endcomponent
    </div>
</div>
@endsection