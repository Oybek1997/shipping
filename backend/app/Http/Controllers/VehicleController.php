<?php

namespace App\Http\Controllers;

use App\TrilerDriver;
use Illuminate\Http\Request;
use App\Vehicle;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];

        $vehicle = Vehicle::whereNull('deleted_at')->orderByDesc('id');
        if ($content) {
            $vehicle->where(function ($q) use ($content) {
                $q->where('name', 'like', '%' . $content . '%')
                    ->orWhere('pono', 'like', '%' . $content . '%')
                    ->orWhere('vin', 'like', '%' . $content . '%')
                    ->orWhere('ga_seq', 'like', '%' . $content . '%')
                    ->orWhere('color', 'like', '%' . $content . '%')
                    ->orWhere('levl', 'like', '%' . $content . '%');
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
    public function okVin(Request $request)
    {
        $id = $request->input('vinid');
        $vehicle = Vehicle::where('id', $id)->first();

        date_default_timezone_set('Asia/Tashkent');
        $date = date('d-m-y h:i:s');
        $date = strtotime($date);
        $dateshift = date('H', $date);
        if ($dateshift >= 8 && $dateshift <= 20) {
            $shift = 1;
        } else {
            $shift = 2;
        }

        if ($vehicle) {
            // return $shift;
            $vehicle->shift = $shift;
            $vehicle->status = 2;
            $vehicle->ok_by = Auth::id();
            $vehicle->ok_at = date('Y-m-d H:i:s');
        } else {
            return 0;
        }

        $vehicle->save();

        return $vehicle;
    }
    public function printVin(Request $request)
    {
        $id = $request->input('vinid');
        $vehicle = Vehicle::where('id', $id)->first();
        if ($vehicle) {
            $vehicle->status = 3;
            $vehicle->print_by = Auth::id();
            $vehicle->print_at = date('Y-m-d H:i:s');
        } else {
            return 0;
        }

        $vehicle->save();

        return $vehicle;
    }
    public function printVinAgain(Request $request)
    {
        $id = $request->input('vinid');
        $vehicle = Vehicle::where('id', $id)->first();
        if ($vehicle) {
            // $vehicle->status = 3;
            $vehicle->print_by = Auth::id();
            $vehicle->print_at = date('Y-m-d H:i:s');
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

    public function android(Request $request)
    {
        $data = $request->all();
        // [{"vin":"X3333333333333333","sector":"1","ombor":"1:\"UzAuto Motors\" \u0410\u0416","traller":"60 125 GBA","shafyor1":"Shafyor1","shafyor2":"T094 : ERKINBEK HAMDAMOV","tabno":"2300","tcd_date":"2022-09-26","iScan_Time":"20220926131857"},{"vin":"X1111111111111111","sector":"1","ombor":"5:\u0410\u0441\u0430\u043a\u0430 \u0414\u049a\u049a\u0428","traller":"60 125 GBA","shafyor1":"Shafyor1","shafyor2":"T094 : ERKINBEK HAMDAMOV","tabno":"2300","tcd_date":"2022-09-26","iScan_Time":"20220926130901"}]
        // $data = $data[0]['vin'];
        // file_put_contents(public_path('abc.txt'),$data);
        $response = [];
        foreach ($data as $key => $value) {
            $vin = $value['vin'];
            $sector = $value['sector'];
            $ombor = $value['ombor'];
            $traller = $value['traller'];
            $shafyor1 = $value['shafyor1'];
            $shafyor2 = $value['shafyor2'];
            $status = $value['status'];

            // $row = $value['row'];  // "1"
            // $tabno = $value['tabno'];  // c.getString(iTxtUser).substring(2,6)
            // $tcd_date = $value['tcd_date'];  // c.getString(iScan_Data)
            // $iScan_Time = $value['iScan_Time'];  // c.getString(iScan_Time)

            $vehicle = Vehicle::where('vin', $vin)->first();
            $ombor_id = $ombor ? explode(':', $ombor)[0] : null;


            $triler = TrilerDriver::where('out_tr_number', $traller)
            ->where('out_first_driver', $shafyor1)
            ->where('out_second_driver', $shafyor2)
            ->first();

            if (!$triler) {
                $triler = new TrilerDriver();
                $triler->out_tr_number = $traller;
                $triler->out_first_driver = $shafyor1;
                $triler->out_second_driver = $shafyor2;
                $triler->save();
            }

            if ($ombor_id) {
                if (!$vehicle) {
                    $vehicle = new Vehicle();
                    $vehicle->vin = $vin;
                }
                $vehicle->status = $status;
                $vehicle->warehouse_id = $ombor_id;
                $vehicle->sector = $sector;
                $vehicle->triler_driver_id = $triler->id;

                if ($status==4) {
                    $vehicle->send_by = Auth::id();
                    $vehicle->send_at = date('Y-m-d H:i:s');
                } elseif ($status==5) {
                    $vehicle->warehouse_by = Auth::id();
                    $vehicle->warehouse_at = date('Y-m-d H:i:s');
                } elseif ($status==6) {
                    $vehicle->warehouse_out_by = Auth::id();
                    $vehicle->warehouse_out_at = date('Y-m-d H:i:s');
                }  elseif ($status==7) {
                    $vehicle->receive_by = Auth::id();
                    $vehicle->receive_at = date('Y-m-d H:i:s');
                }  elseif ($status==8) {
                    $vehicle->finish_by = Auth::id();
                    $vehicle->finish_at = date('Y-m-d H:i:s');
                }
                else{
                    print ("Bunday Status mavjud emas");
                }
                try {
                    $vehicle->save();
                    $response[] = ['vin' => $vin, 'status' => 200];
                } catch (\Throwable $th) {
                    $response[] = ['vin' => $vin, 'status' => 500, 'message' => $th->getMessage()];
                    // throw $th;
                }
            }
        }
        return $response;
    }
    public function forGaraj($gNumner,$sdate,$edate)
    {
        // return [$gNumner,$sdate,$edate];
        // $filter = $request->input('filter');
        $car=$gNumner;
        $start_date =$sdate . ' 00:00:00';
		$end_date = $edate . ' 23:59:59';
        $transport=TrilerDriver::select('id')->where('out_tr_number',$car)->get();
        $mydate=Vehicle::select('vin','modelname','send_at','warehouse_id','triler_driver_id')
            ->with('trilerInfo')
            ->with('warehouse:id,name')
            ->whereIn('triler_driver_id',$transport)
            ->whereBetween('send_at', [$start_date,$end_date])
            ->get()
        ;

        return ['request'=>$mydate,'count'=>$mydate->count(),'transport'=>$transport,$start_date,$end_date];
    }
}
