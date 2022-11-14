<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Order;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];

        $detail = Detail::orderByDesc('id')->with('masulemp');
        if ($content) {
            $detail->where(function ($q) use ($content) {
                $q->where('part', 'like', '%' . $content . '%')
                    ->orWhere('part_name', 'like', '%' . $content . '%')
                    ->orWhere('suplier', 'like', '%' . $content . '%')
                    ->orWhere('source', 'like', '%' . $content . '%');
            });
        }
        // dd(gettype($detail));
        return $detail->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
        // $model = Test::paginate($itemsPerPage == '-1' ? 1000 : $itemsPerPage, ['*'], 'page name', $page);
        // return $model;
    }
    public function update(Request $request)
    {
        $id = $request['id'];
        $detail = Detail::where('id', $id)->first();
        // dd($user);
        if ($detail) {
            $detail->part = $request['part'];
            $detail->part_name = $request['part_name'];
            $detail->suplier = $request['suplier'];
            $detail->yetkazuvchi_employee_id = $request['masul_emp'];
        } else {
            $detail = new Detail();
            $detail->part = $request['part'];
            $detail->part_name = $request['part_name'];
            $detail->suplier = $request['suplier'];
            $detail->yetkazuvchi_employee_id = $request['masul_emp'];
        }

        $detail->save();

        return $detail;
    }
    public function destroy($id)
    {
        Detail::find($id)->delete();
    }

    public function detailSearch(Request $request)
    {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;
        $vehicle_id = $request->input('item');
        $detail_ids = Order::where('vehicle_id', $vehicle_id)->get()->pluck('detail_id');
        $detail = Detail::whereNotIn('id', $detail_ids);
        if ($content) {
            $detail->where(function ($q) use ($content) {
                $q->where('part', 'like', '%' . $content . '%');
            });
        }
        return $detail->get();
    }


    public function getExcel(Request $request)
    {
//        return $request;
        $page = $request->input('pagination.page');

        $perPage = $request->input('pagination.itemsPerPage');
//        return $page;
        $details = Detail::select('details.*','users.name')
            ->leftJoin('users', 'users.id', '=', 'details.yetkazuvchi_employee_id')
            ->orderByRaw('details.yetkazuvchi_employee_id ASC')
            ->paginate($perPage, ['*'], 'page name', $page);
        $excel = [];

//        return $details;


        foreach ($details as $key => $value) {
            array_push($excel, (object)[
                "№" => $key + 1 + $page * $perPage - $perPage,
                "Part" => $value->part,
                "PartName" => $value->part,
                "Supplier" => $value->suplier,
                "Masul" => $value->name,

            ]);
        }
        return $excel;
    }

}
