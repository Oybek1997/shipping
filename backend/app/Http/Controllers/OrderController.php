<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function reportCount(Request $request)
    {
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['per_page'];

        $vehicle = Vehicle::select('vehicles.id', 'vehicles.modelname', 'vin', DB::raw('count(orders.id) as count'))
            ->with('details.masulemp')
            ->join('orders', 'orders.vehicle_id', '=', 'vehicles.id')
            ->groupBy('vin', 'vehicles.id', 'vehicles.modelname')
            ->where('vehicles.status', '!=', 9)
            ->orderByDesc('count');
        $search = $request->input('search');
        $content = isset($search) ? $search : 0;

        if ($content) {
            $vehicle->where(function ($q) use ($content) {
                $q->where('vehicles.vin', 'like', '%' . $content . '%');
            });
        }
        $model = $request->input('model');
        $mcontent = isset($model) ? $model : 0;
        // return $mcontent;
        if ($mcontent) {
            $vehicle->where(function ($q) use ($mcontent) {
                $q->where('vehicles.modelname', 'like', '%' . $mcontent . '%');
            });
        }
        return $vehicle->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
    }

    public function reportCount2(Request $request)
    {
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['per_page'];

        $vehicle = Vehicle::select(
            'vehicles.id',
            'vehicles.trim_by',
            'vehicles.ok_by',
            'vehicles.print_by',
            'vehicles.color',
            'vehicles.modelname',
            'orders.setup_date',
            'orders.produced_date',
            'vin',
            DB::raw('count(orders.id) as count')
        )
            ->with(['details' => function ($q) {
                $q->where('orders.status', '=', 0)
                    ->with('masulemp');
            }])
            ->with('trimby')
            ->join('orders', 'orders.vehicle_id', '=', 'vehicles.id')
            ->where(function ($query) {
                $query->whereIn('vehicles.status', [1, 2])
                    ->where('orders.status', 0)
                    ->orWhere('vehicles.status', 2);
            })
            ->groupBy('vin', 'vehicles.id', 'vehicles.modelname')
            ->orderByDesc('orders.created_at');

        $search = $request->input('search');
        $content = isset($search) ? $search : 0;
        if ($content) {
            $vehicle->where(function ($q) use ($content) {
                $q->where('vehicles.vin', 'like', '%' . $content . '%');
            });
        }
        $model = $request->input('model');
        $mcontent = isset($model) ? $model : 0;
        // return $mcontent;
        if ($mcontent) {
            $vehicle->where(function ($q) use ($mcontent) {
                $q->where('vehicles.modelname', 'like', '%' . $mcontent . '%');
            });
        }
        return $vehicle->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
    }

    public function reportCount3(Request $request)
    {
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['per_page'];

        $vehicle = Vehicle::select('vehicles.id', 'vehicles.trim_by', 'vehicles.ok_by', 'vehicles.print_by', 'vehicles.color', 'vehicles.modelname', 'orders.setup_date', 'orders.produced_date', 'vin', DB::raw('count(orders.id) as count'))
            ->with('details.masulemp')
            ->with('trimby')
            ->join('orders', 'orders.vehicle_id', '=', 'vehicles.id')
            ->where('vehicles.print_by', '!=', null)
            ->where('vehicles.status', '!=', 9)
            ->groupBy('vin', 'vehicles.id', 'vehicles.modelname')
            ->orderByDesc('count');
        $search = $request->input('search');
        $content = isset($search) ? $search : 0;

        if ($content) {
            $vehicle->where(function ($q) use ($content) {
                $q->where('vehicles.vin', 'like', '%' . $content . '%');
            });
        }
        $model = $request->input('model');
        $mcontent = isset($model) ? $model : 0;
        // return $mcontent;
        if ($mcontent) {
            $vehicle->where(function ($q) use ($mcontent) {
                $q->where('vehicles.modelname', 'like', '%' . $mcontent . '%');
            });
        }
        return $vehicle->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
    }

    public function addDetail(Request $request)
    {
        $data = $request->input('order');
        // return $data;
        foreach ($data as $key => $value) {
            $order = new Order();
            $order->vehicle_id = $value['id'];
            $order->detail_id = $value['part'];
            $order->setup_date = $value['setup_date'];
            $order->update_type = 1;
            $order->created_by = Auth::id();

            $order->save();
        }
        return $order;
    }

    public function removeDetail(Request $request)
    {
        $vehicle_id = $request->input('vehicleId');
        $detail_id = $request->input('detailId');
        $order = Order::where('vehicle_id', $vehicle_id)->where('detail_id', $detail_id)->first();
        // return $order->get();
        if ($order) {
            $order->status = 1;
            $order->save();
        } else {
            return 0;
        }
    }


    ///////Report1Excel
    public function getReportExcel(Request $request)
    {
//        return $request;
        $page = $request->input('pagination.page');

        $perPage = $request->input('pagination.itemsPerPage');
//        return $page;


//        $details = Order::select('orders.*','vehicles.name')
//            ->leftJoin('users', 'users.id', '=', 'details.yetkazuvchi_employee_id')
//            ->orderByRaw('details.yetkazuvchi_employee_id ASC')
//            ->paginate($perPage, ['*'], 'page name', $page);


        $vehicles = Vehicle::select('vehicles.id', 'vehicles.modelname', 'vin', DB::raw('count(orders.id) as count'))
            ->with('details.masulemp')
            ->with('details.order.part')
            ->with('details.order.part_name')
            ->with('details.order.suplier')
            ->join('orders', 'orders.vehicle_id', '=', 'vehicles.id')
            ->groupBy('vin', 'vehicles.id', 'vehicles.modelname')
            ->where('vehicles.status', '!=', 9)
            ->orderByDesc('count')
            ->paginate($perPage, ['*'], 'page name', $page);

        $excel[] = [];
        $k = 0;

//        return $vehicles;

        foreach ($vehicles as $key => $value) {
            $excel[$k][]=$value->modelname;
            $excel[$k][]=$value->vin;
            $excel[$k][]=$value->count;
            foreach ($value->details as $innerKey => $innerValue) {
              $excel[$k][]=$innerValue->part;
              $excel[$k][]=$innerValue->part_name;
              $excel[$k][]=$innerValue->suplier;
            }
            $k++;
        }
        return $excel;
    }
}
