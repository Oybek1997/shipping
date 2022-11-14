<?php

namespace App\Http\Controllers;

use App\Detail;
use App\Order;
use App\Vehicle_detail;
use App\Vehicle;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = Vehicle::select('modelname', 'status')->where('status', '!=', 9)->groupBy('modelname')->get();
        $warehouse = Warehouse::get();
        $array = [];
        $array[0][0] = '#';
        foreach ($model as $key => $m) {
            $array[$key + 1][0] = $m->modelname;
            foreach ($warehouse as $k => $w) {
                $array[0][$k + 1] = $w->name;
                $wehicle_white = Vehicle::where('warehouse_id', $w->id)
                    ->where('color', 1)
                    ->where('status', '!=', 9)
                    ->where('modelname', $m->modelname)
                    ->count();
                $wehicle_yellow = Vehicle::where('warehouse_id', $w->id)
                    ->where('color', 2)
                    ->where('status', '!=', 9)
                    ->where('modelname', $m->modelname)
                    ->count();
                $wehicle = Vehicle::where('warehouse_id', $w->id)
                    ->where('status', '!=', 9)
                    ->where('modelname', $m->modelname)
                    ->count();
                $array[$key + 1][$k + 1] = [
                    $wehicle_white,
                    $wehicle_yellow,
                    $wehicle
                ];
                // array_push($array[$key+1], )
            }
        }
        // return
        // $arr = $array[1]->map(function($v) {									
        //     return [
        //             'v' => $v[0][3],                    
        //         ];
        //     });

        // array_push($array, ['summ']);
        return $array;
        // $model = Vehicle::select(DB::raw('distinct(modelname)'),'id')->get();
    }


    public function monthreport(Request $request)
    {
        $warehouse = Warehouse::get();
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        // return $months;
        $array = [];
        $array[0][0] = '#';
        foreach ($warehouse as $key => $v) {
            $array[$key + 1][0] = $v->name;
            foreach ($months as $k => $month) {
                $array[0][$k + 1] = $month;
                $order_white = Vehicle::where('warehouse_id', $v->id)
                    ->where(DB::raw('SUBSTRING(vehicles.send_at, 6, 2)'), $month)
                    ->where('status', '!=', 9)
                    ->where('color', 1)->count();
                $order_yellow = Vehicle::where('warehouse_id', $v->id)
                    ->where(DB::raw('SUBSTRING(vehicles.send_at, 6, 2)'), $month)
                    ->where('status', '!=', 9)
                    ->where('color', 2)->count();
                $array[$key + 1][$k + 1] = [
                    $order_white,
                    $order_yellow,
                ];
            }
        }
        return $array;
    }

    public function modelreport(Request $request)
    {
        $model = Vehicle::select('modelname')->where('status', '!=', 9)->groupBy('modelname')->get();
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        // return $months;
        $array = [];
        $array[0][0] = '#';
        foreach ($model as $key => $m) {
            $array[$key + 1][0] = $m->modelname;
            foreach ($months as $k => $month) {
                $array[0][$k + 1] = $month;
                $order_white = Vehicle::where('modelname', $m->modelname)
                    ->where(DB::raw('SUBSTRING(vehicles.send_at, 6, 2)'), $month)
                    ->where('status', '!=', 9)
                    ->where('color', 1)->count();
                $order_yellow = Vehicle::where('modelname', $m->modelname)
                    ->where(DB::raw('SUBSTRING(vehicles.send_at, 6, 2)'), $month)
                    ->where('status', '!=', 9)
                    ->where('color', 2)->count();
                $array[$key + 1][$k + 1] = [
                    $order_white,
                    $order_yellow,
                ];
            }
        }
        return $array;
    }


    public function apiOne()
    {
        return $model = Vehicle::select('modelname',  DB::raw('count(id) as count'))
            ->whereNotNull('modelname')
            ->where('status', '!=', 9)
            ->where('modelname', '!=', 'none')
            ->groupBy('modelname')
            ->get();
    }
    public function apiTwo()
    {
        return $model = Vehicle::select('warehouses.name',  DB::raw('count(vehicles.id) as count'))
            ->whereNotNull('modelname')
            ->where('status', '!=', 9)
            ->join('warehouses', 'warehouses.id', '=', 'vehicles.warehouse_id')
            // ->with('warehouses')
            ->groupBy('warehouse_id')
            ->get();
    }
    public function apiThree()
    {
        $model = [];
        $model[] = ['status' => 'Liniyada', 'count' => Vehicle::whereIn('status', [1, 2])->count('id')];
        $model[] = ['status' => 'Liniyadan tashqarida', 'count' => Vehicle::whereIn('status', [3, 7])->orWhere('warehouse_id', 1)->where('status', '!=', 9)->count('id')];
        $model[] = ['status' => 'Omborlarda', 'count' => Vehicle::whereIn('status', [4, 5, 6])->count('id')];
        return $model;
    }
    public function apiFour()
    {
        return $model = Order::select('details.part',  DB::raw('count(details.id) as count'))
            ->where('status', 0)
            ->join('details', 'details.id', '=', 'orders.detail_id')
            ->groupBy('details.id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
    }
    public function apiFive()
    {
        $model = Vehicle::select('modelname')
            ->whereNotNull('modelname')
            ->where('modelname', '!=', 'none')
            ->where('status', '!=', 9)
            ->groupBy('modelname')
            ->get()->count();

        $all_detail_count = Detail::get()->count();
        // return $detail_count->count();

        $details04_count = Order::where('status', 0)
            ->join('details', 'details.id', '=', 'orders.detail_id')
            ->groupBy('details.id')
            ->get()->count();
        // return $details04_count->count();

        $all_warehouse_count = Warehouse::get()->count();
        // return $all_warehouse_count->count();

        $warehouseVehicle_count = Vehicle::where('status', 4)
        // ->whereNotNull('warehouse_at')
        // ->whereNotNull('warehouse_by')
        // ->whereNotNull('send_by')
        ->whereNotNull('send_at')
        ->get()->count();
        // return $warehouseVehicle_count->count();

        $all_vehicles_count = Vehicle::get()->count();
        // return $all_vehicles_count->count();

        $vehicles04_count = Vehicle::whereHas('details', function ($q){
            $q->where('status', '=', 0);
        })->get()->count();
        // return $vehicles04_count->count();
        $arr['all_vehicles'] = $all_vehicles_count;
        $arr['vehicles04'] = $vehicles04_count;
        $arr['all_models'] = $model;
        $arr['all_details'] = $all_detail_count;
        $arr['all_details04'] = $details04_count;
        $arr['all_warehouses'] = $all_warehouse_count;
        $arr['all_warehouse_vehicle'] = $warehouseVehicle_count;

        return $arr;
        // $detail_order_count = Order::select('')
        // $arr[] = $detail_count;
        // return $arr;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {

        // $api = "https://edo-db2.uzautomotors.com/api/updatemodel/" . $v->vin;
        // $veh = json_decode(file_get_contents($api));

        $response = ('https://edo-db2.uzautomotors.com/api/get-skud-full-manual/3120/2022-09');

        $veh = json_decode(file_get_contents($response));

        return count($veh);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
