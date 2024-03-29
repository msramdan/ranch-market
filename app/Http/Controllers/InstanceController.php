<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use App\Http\Requests\{StoreInstanceRequest, UpdateInstanceRequest};
use App\Models\OperationalTime;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class InstanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:instance view')->only('index', 'show');
        $this->middleware('permission:instance create')->only('create', 'store');
        $this->middleware('permission:instance edit')->only('edit', 'update');
        $this->middleware('permission:instance delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $instances = Instance::with('province:id,provinsi', 'kabkot:id,kabupaten_kota', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id')->orderBy('instances.id', 'DESC');
            return DataTables::of($instances)
                ->addIndexColumn()
                ->addColumn('address', function ($row) {
                    return str($row->address)->limit(100);
                })
                ->addColumn('province', function ($row) {
                    return $row->province ? $row->province->provinsi : '';
                })->addColumn('kabkot', function ($row) {
                    return $row->kabkot ? $row->kabkot->kabupaten_kota : '';
                })->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan ? $row->kecamatan->kabkot_id : '';
                })->addColumn('kelurahan', function ($row) {
                    return $row->kelurahan ? $row->kelurahan->kecamatan_id : '';
                })->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })->addColumn('action', 'instances.include.action')
                ->toJson();
        }

        return view('instances.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $days = [
            'sunday',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday'
        ];

        return view('instances.create', compact('days'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'push_url' => 'required|url|min:1|max:200',
                'instance_name' => 'required|string|min:1|max:200',
                'address' => 'required|string',
                'provinsi_id' => 'required|exists:App\Models\Province,id',
                'kabkot_id' => 'required|exists:App\Models\Kabkot,id',
                'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
                'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
                'zip_kode' => 'required|string|min:1|max:20',
                'email' => 'required|string|min:1|max:100',
                'phone' => 'required|string|min:1|max:13',
                'longitude' => 'required|string|min:1|max:200',
                'latitude' => 'required|string|min:1|max:200',
                'field_data.*' => 'required',
                'min_tolerance.*' => 'required',
                'max_tolerance.*' => 'required',
                'day.*' => 'required',
                'opening_hour.*' => 'nullable',
                'closing_hour.*' => 'nullable',
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }


        try {
            $response = Http::withHeaders(['x-access-token' => setting_web()->token])
                ->withOptions(['verify' => false])
                ->post(setting_web()->endpoint_nms . '/openapi/app/create', [
                    "appName" =>  Str::slug(request('instance_name', '_')),
                    "pushURL" => $request->push_url,
                    "enableMQTT" => false
                ]);

            if ($response['code'] == 0) {
                $data = $request->except(['_token']);
                $data['app_id'] = $response['appID'];
                $data['app_name'] = Str::slug(request('instance_name', '_'));
                // create local intance
                $instances = Instance::create($data);

                // insert day operational
                $days = $request->day;
                $open_hour = $request->opening_hour;
                $closing_hour = $request->closing_hour;

                foreach ($days as $i => $day) {
                    $operational_time = OperationalTime::create([
                        'instance_id' => $instances->id,
                        'day' => $day,
                        'open_hour' => $open_hour[$i],
                        'close_hour' => $closing_hour[$i]
                    ]);
                }

                if ($instances) {
                    Alert::toast('Data success saved', 'success');
                    return redirect()->route('instances.index');
                }
            } else {
                Alert::toast('There is something wrong with respond api.', 'error');
                return redirect()->route('instances.index');
            }
        } catch (Exception $e) {
            Alert::toast('Data failed to save', 'error');
            return redirect()->route('instances.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function show(Instance $instance)
    {
        $instance->load('province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id',);

        return view('instances.show', compact('instance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function edit(Instance $instance)
    {
        $instance->load('province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id',);
        $kabkot = DB::table('kabkots')->where('provinsi_id', $instance->provinsi_id)->get();
        $kecamatan = DB::table('kecamatans')->where('kabkot_id', $instance->kabkot_id)->get();
        $kelurahan = DB::table('kelurahans')->where('kecamatan_id', $instance->kecamatan_id)->get();
        $operational_times = OperationalTime::where('instance_id', $instance->id)->orderBy('id', 'asc')->get();
        return view('instances.edit', compact('instance', 'operational_times', 'kabkot', 'kecamatan', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstanceRequest $request, Instance $instance)
    {
        try {
            $response = Http::withHeaders(['x-access-token' => setting_web()->token])
                ->withOptions(['verify' => false])
                ->post(setting_web()->endpoint_nms . '/openapi/app/update', [
                    "appID" => (int)  $request->app_id,
                    "appName" =>  Str::slug(request('instance_name', '_')),
                    "pushURL" => $request->push_url,
                    "enableMQTT" => false
                ]);
            if ($response['code'] == 0) {
                $data = $request->except('_token');
                $data['app_name'] = Str::slug(request('instance_name', '_'));
                $instance->update($data);


                /** Update Operational Time */
                $operational_id = $request->operational_id; // array operational id
                $days = $request->day; // array days
                $opening_hours = $request->opening_hour; // array opening hour
                $closing_hours = $request->closing_hour; // array closing hour


                foreach ($operational_id as $i => $operational) {
                    $operational_time = OperationalTime::where('instance_id', $instance->id)
                        ->where('id', $operational)
                        ->first();
                    if ($operational_time) {
                        $operational_time->update([
                            'day' => $days[$i],
                            'open_hour' => $opening_hours[$i],
                            'close_hour' => $closing_hours[$i],
                        ]);
                    } else {
                        $operational_time = OperationalTime::create([
                            'instance_id' => $instance->id,
                            'day' => $days[$i],
                            'open_hour' => $opening_hours[$i],
                            'close_hour' => $closing_hours[$i]
                        ]);
                    }
                }
                Alert::toast('The instance was updated successfully.', 'success');
                return redirect()
                    ->route('instances.index');
            } else {
                Alert::toast('There is something wrong with respond api.', 'error');
                return redirect()->route('instances.index');
            }
        } catch (Exception $e) {
            Alert::toast('Data failed to save', 'error');
            return redirect()->route('instances.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instance $instance)
    {
        try {
            if ($instance->delete()) {
                $response = Http::withHeaders(['x-access-token' => setting_web()->token])
                    ->withOptions(['verify' => false])
                    ->post(setting_web()->endpoint_nms . '/openapi/app/delete', [
                        "appIDs" => [$instance->app_id],
                    ]);
                if ($response['code'] == 0) {

                    Alert::toast('The instance was deleted successfully.', 'success');
                    return redirect()->route('instances.index');
                } else {
                    Alert::toast('There is something wrong with respond api.', 'error');
                    return redirect()->route('instances.index');
                }
            }
        } catch (\Throwable $th) {
            Alert::toast('The instance cant be deleted because its related to another table.', 'error');
            return redirect()->route('instances.index');
        }
    }

    public function get_cluster($instance_id)
    {
        $data = DB::table('clusters')->where('instance_id', $instance_id)->get();
        $message = 'Berhasil mengambil data kota';

        return response()->json(compact('message', 'data'));
    }
}
