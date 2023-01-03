<?php

namespace App\Http\Controllers;

use App\Diler;
use App\DilerVin;
use App\TrilerDriver;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class DilerController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];

        $vehicle = Diler::whereNull('deleted_at')
            ->orderByDesc('id');
        if ($content) {
            $vehicle->where(function ($q) use ($content) {
                $q->where('name', 'like', '%' . $content . '%')
                    ->orWhere('diler_code', 'like', '%' . $content . '%');
                    //->orWhere('status', 'like', '%' . $content . '%')
                   // ->orWhere('sector', 'like', '%' . $content . '%');
                    //->orWhere('tabno', 'like', '%' . $content . '%');
            });
        }
        // dd(gettype($vehicle));
        return $vehicle->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
        // $model = Test::paginate($itemsPerPage == '-1' ? 1000 : $itemsPerPage, ['*'], 'page name', $page);
        // return $model;
    }
    public function update(Request $request)
    {
        $id = $request['id'];
        $diler = Diler::where('id', $id)->first();
        // dd($user);
        if ($diler) {
            $diler->name = $request['name'];
            $diler->diler_code = $request['diler_code'];
        } else {
            return 0;
        }

        $diler->save();

        return $diler;
    }

    public function destroy($id)
    {
        Diler::find($id)->delete();
        // dd($user);
        // $user->delete();
    }



    protected $base_url;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->base_url = env("BASE_URL","http://test-dy.uzautomotors.com/api/send_data");

        View::share('base_url', $this->base_url);

    }

    public function getExcel(Request $request)
    {
//        return $request;
        $page = $request->input('pagination.page');

        $perPage = $request->input('pagination.itemsPerPage')*10000000;
        //return $perPage;
        $details = DilerVin::select('*')
            ->paginate($perPage, ['*'], 'page name', $page);
        $excel = [];

//        return $details;


        foreach ($details as $key => $value) {
            array_push($excel, (object)[
                "№" => $key + 1 + $page * $perPage - $perPage,
                "Name" => $value->diler->name,
                "Vin" => $value->vin,
                "Tabno" => $value->tabno,
                "Tcd_date" => $value->tcd_time,
            ]);
        }
        return $excel;
    }

}
