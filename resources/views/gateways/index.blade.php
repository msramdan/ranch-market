@extends('layouts.app')

@section('title', __('Gateways'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Gateways') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Gateways') }}</li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped table-sm" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Gwid') }}</th>
                                            <th>{{ __('Status Online') }}</th>
                                            <th>{{ __('Pktfwd Status') }}</th>
                                            <th>{{ __('Connection Type') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $('#data-table').DataTable({
            processing: true,
            // serverSide: true,
            ajax: "{{ route('gateways.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'gwid',
                    name: 'gwid',
                },
                {
                    data: 'status_online',
                    name: 'status_online',
                },
                {
                    data: 'pktfwd_status',
                    name: 'pktfwd_status',
                },

                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
