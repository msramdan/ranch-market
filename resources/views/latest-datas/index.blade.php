@extends('layouts.app')

@section('title', __('Latest Data'))

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header" style="margin-top: 5px">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>{{ __('Latest Data') }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Latest Data') }}</li>
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
                                <table class="table table-striped table-xs" id="data-table" role="grid">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Branches') }}</th>
                                            <th>{{ __('Cluster') }}</th>
                                            <th>{{ __('Dev Eui') }}</th>
                                            <th>{{ __('Temperature') }}</th>
                                            <th>{{ __('Humidity') }}</th>
                                            <th>{{ __('Battery') }}</th>
                                            <th>{{ __('Updated At') }}</th>
                                            <th>{{ __('Time') }}</th>
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
            ajax: "{{ route('latest-datas.index') }}",
            columns: [{
                    data: 'instance_name',
                    name: 'instance_name'
                },
                {
                    data: 'cluster_name',
                    name: 'cluster_name'
                },
                {
                    data: 'device',
                    name: 'device'
                },
                {
                    data: 'temperature',
                    name: 'temperature',
                },
                {
                    data: 'humidity',
                    name: 'humidity',
                },
                {
                    data: 'battery',
                    name: 'battery',
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'time',
                    name: 'time'
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
