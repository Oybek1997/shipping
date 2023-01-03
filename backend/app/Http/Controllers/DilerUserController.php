<?php

namespace App\Http\Controllers;

use App\Diler;
use App\DilerVin;
use App\DilerUser;
use App\User;
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

class DilerUserController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];

        $vehicle = DilerUser::whereNull('deleted_at')->with('user')->with('diler')
            ->orderByDesc('id');
        if ($content) {
            $vehicle->where(function ($q) use ($content) {
                $q->where('vin', 'like', '%' . $content . '%')
                    ->orWhere('tabno', 'like', '%' . $content . '%');
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
        $vehicle = Vehicle::where('id', $id)->first();
        // dd($user);
        if ($vehicle) {
            $vehicle->name = $request['name'];
            $vehicle->pono = $request['pono'];
            $vehicle->vin = $request['vin'];
            $vehicle->ga_seq = $request['ga_seq'];
            $vehicle->color = $request['color'];
            $vehicle->levl = $request['levl'];
        } else {
            return 0;
        }

        $vehicle->save();

        return $vehicle;
    }



    public function destroy($id)
    {
        Vehicle::find($id)->delete();
        // dd($user);
        // $user->delete();
    }



    protected $base_url;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->base_url = env("BASE_URL", "http://test-dy.uzautomotors.com/api/send_data");

        View::share('base_url', $this->base_url);
    }


    //deleteFunction
    public function deleteFunction()
    {
        //        $allVehicles=Vehicle::all();
        //        // dd($user);
        //         $allVehicles->truncate();

        DB::table('vehicles')->delete();
    }

    public function getMaindata()
    {
        $dilers = Diler::get();
        $users = User::get();
        // return $users;
        return ['dillers' => $dilers, 'users' => $users];
    }
    public function add(Request $request)
    {
        $dillers = $request['dillers'];
        $user = $request['user'];
        // return $user;

        foreach ($dillers as $key => $diller) {
            $dillerUser = DilerUser::where('diler_id', $diller)->where('user_id', $user)->first();

            if (!$dillerUser) {
                $dillerUser = new DilerUser();
                $dillerUser->diler_id = $diller;
                $dillerUser->user_id = $user;
                $dillerUser->save();
            }
        }

        return $dillerUser;
    }
}
