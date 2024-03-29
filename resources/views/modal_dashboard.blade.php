{{-- List User ONline --}}
<div class="modal fade" id="modalUserOnline" tabindex="-1" aria-labelledby="exampleModallview" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Users Online</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="display dataTable no-footer table-xs dataTables-example" id=""
                        width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Role') }}</th>
                            </tr>
                        </thead>
                        @php
                            $usersOnline = App\Models\User::with('roles:id,name')
                                ->where('is_online', 'Y')
                                ->get();
                        @endphp
                        <tbody>
                            @foreach ($usersOnline as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->roles->first()->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
{{-- Branch error --}}
<div class="modal fade" id="modalBrancError" tabindex="-1" aria-labelledby="exampleModallview" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Branches Error</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="display dataTable no-footer table-xs dataTables-example" id=""
                        width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('App Id') }}</th>
                                <th>{{ __('Branches Name') }}</th>
                                <th>{{ __('Kabupaten/kota') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listBranchesError as $row)
                                @php
                                    $instances = App\Models\Instance::with('kabkot:id,kabupaten_kota')
                                        ->where('id', $row->instance_id)
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $instances->app_id }}</td>
                                    <td>{{ $instances->instance_name }}</td>
                                    <td>{{ $instances->kabkot->kabupaten_kota }}</td>
                                    <td>{{ $instances->email }}</td>
                                    <td>{{ $instances->phone }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

{{-- Instance error --}}
<div class="modal fade" id="modalClusterError" tabindex="-1" aria-labelledby="exampleModallview" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Clusters Error</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="display dataTable no-footer table-xs dataTables-example" id=""
                        width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('Branches') }}</th>
                                <th>{{ __('Cluster Kode') }}</th>
                                <th>{{ __('Cluster Name') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listClusterError as $row)
                                @php
                                    $cluster = App\Models\Cluster::with('instance:id,instance_name')
                                        ->where('id', $row->cluster_id)
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $cluster->instance->instance_name }}</td>
                                    <td>{{ $cluster->cluster_kode }}</td>
                                    <td>{{ $cluster->cluster_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


{{-- Device error --}}
<div class="modal fade" id="modalDeviceError" tabindex="-1" aria-labelledby="exampleModallview" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Devices Error</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="display dataTable no-footer table-xs dataTables-example" id=""
                        width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('Dev Eui') }}</th>
                                <th>{{ __('Dev Name') }}</th>
                                <th>{{ __('Dev Type') }}</th>
                                <th>{{ __('Auth Type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listDeviceError as $row)
                                <tr>
                                    <td>{{ $row->dev_eui }}</td>
                                    <td>{{ $row->dev_name }}</td>
                                    <td>{{ $row->dev_type }}</td>
                                    <td>{{ $row->auth_type }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


{{-- Modal Instance --}}
<div class="modal fade" id="modalInstance" tabindex="-1" aria-labelledby="exampleModallview" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Branch</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="" width="100%">
                        <tbody>
                            <tr>
                                <td>App Id</td>
                                <td>:</td>
                                <td><span id="app_id"></span></td>
                            </tr>
                            <tr>
                                <td>Branch Name</td>
                                <td>:</td>
                                <td><span id="instance_name"></span></td>
                            </tr>
                            <tr>
                                <td>Kabupaten/kota</td>
                                <td>:</td>
                                <td><span id="kabkot"></span></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><span id="email"></span></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td><span id="phone"></span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>




{{-- Modal By Branch --}}
<div class="modal fade" id="modalByBranch" tabindex="-1" aria-labelledby="exampleModallview" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Device By Branches</h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display dataTable no-footer table-xs dataTables-example" id="result"
                            width="100%">
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


{{-- Modal By Cluster --}}
<div class="modal fade" id="modalByCluster" tabindex="-1" aria-labelledby="exampleModallview" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Device By Cluster
                </h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display dataTable no-footer table-xs dataTables-example" id="result2"
                            width="100%">
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button></div>

        </div>
    </div>

</div>
</div>



{{-- Modal By Location --}}
<div class="modal fade" id="modalByLocation" tabindex="-1" aria-labelledby="exampleModallview" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Device By Location</h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display dataTable no-footer table-xs dataTables-example" id="result3"
                            width="100%">
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
