<?php

namespace App\Http\Controllers;


use App\Warehouse;
use Illuminate\Http\Request;


class WarehouseController extends Controller
{
    public function warehouses(Request $request)
    {
        return Warehouse::select('id', 'name')->get();
    }
    public function index(Request $request)
    {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];

        $detail = Warehouse::orderBy('id');
        if ($content) {
            $detail->where(function ($q) use ($content) {
                $q->where('name', 'like', '%' . $content . '%');
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
        $detail = Warehouse::where('id', $id)->first();
        // dd($user);
        if ($detail) {
            $detail->name = $request['name'];
        } else {
            $detail = new Warehouse();
            $detail->name = $request['name'];
        }

        $detail->save();

        return $detail;
    }
    public function destroy($id)
    {
        Warehouse::find($id)->delete();
    }
}
