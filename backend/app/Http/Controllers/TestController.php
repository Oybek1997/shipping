<?php

namespace App\Http\Controllers;

use App\Test;
use App\Employee;
use App\Order;
use App\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Detail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TestsImport;
use App\TrilerDriver;
use App\User;
use App\Vehicle;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function mplImport(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileName = microtime(true) * 1000 . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);

            $sheetname = 'Дата база (сариқ)';
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(public_path('uploads') . '/' . $fileName);
            $data = $spreadsheet->getSheet(0)->toArray();

            unset($data[0]);
            unset($data[1]);
            unset($data[2]);
            unset($data[3]);
            $error = [];
            foreach ($data as $key => $value) {
                if ($value[9]) {
                    $masulemp =  $value[2] ? User::where('tbn', $value[2])->first() : '';
                    if (!$masulemp) {
                        $error[] = ['user' => $value[3], 'error' => 4];
                    }
                    $sifatemp =  $value[5] ? User::where('tbn', $value[5])->first() : '';
                    if (!$sifatemp) {
                        $error[] = ['user' => $value[6], 'error' => 4];
                    }
                    $sendemp =  $value[111] ? User::where('tbn', $value[111])->first() : '';
                    if (!$sendemp) {
                        $error[] = ['user' => $value[112], 'error' => 4];
                    }
                    $warehouse = Warehouse::where('name', $value[114])->first();
                    if (!$warehouse) {
                        $warehouse = new Warehouse();
                        $warehouse->name = $value[114];
                        $warehouse->save();
                    }
                    if (isset($masulemp) && isset($sifatemp) && isset($sendemp)) {

                        $vehicle = Vehicle::where('vin', $value[9])->first();
                        if (!$vehicle) {
                            $vehicle = new Vehicle();
                            $vehicle->vin = $value[9];
                            $vehicle->modelname = $value[8];
                            if ($value[10]) {
                                if ($value[10] == "Сариқ") {
                                    $vehicle->color = 2;
                                } else {
                                    $vehicle->color = 1;
                                }
                            }
                        }

                        if($vehicle->warehouse_id == $warehouse->id) {
                            $error[] = ['error' => $value[114], 'error' => 5];
                        }

                        $vehicle->warehouse_id =  $warehouse->id;
                        $vehicle->trim_by = $masulemp->id;
                        $vehicle->trim_at = date('Y-m-d H:i:s');
                        $vehicle->ok_by = $sifatemp->id;
                        $vehicle->ok_at = date('Y-m-d', strtotime($value[7]));

                        if($vehicle->send_by == $sendemp->id) {
                            $error[] = ['errordata' => $value[112], 'error' => 5];
                        }

                        $vehicle->send_by = $sendemp->id;
                        $vehicle->send_at = $value[113] ? date('Y-m-d', strtotime($value[113])) : null;

                        $vehicle->status = $value[113] ? 4 : 3;
                        $vehicle->shift = $value[4];
                        $vehicle->save();

                        for ($i = 0; $i < 20; $i++) {
                            $k = 11 + ($i * 5);
                            if ($value[$k]) {
                                $detail = Detail::where('part', $value[$k])->first();
                                if (!$detail) {
                                    $error[] = ['detail' => $value[$k], 'error' => 2];
                                } else {
                                    $order = Order::where('vehicle_id', $vehicle->id)->where('detail_id', $detail->id)->first();
                                    if (!$order) {
                                        $order = new Order();
                                    }
                                    $order->created_by = Auth::id();
                                    $order->setup_date = date('Y-m-d', strtotime($value[$k + 4]));
                                    $order->upload_date = date('Y-m-d H:i:s');
                                    $order->vehicle_id = $vehicle->id;
                                    $order->detail_id = $detail->id;
                                    // $order->produced_date = date('Y-m-d', strtotime($value[7]));
                                    $order->save();
                                }
                            }
                            // else break;
                        }
                    }
                } else break;
            }
            unlink(public_path('uploads') . '/' . $fileName);
            if (empty($error)) {
                DB::commit();
                return  8;
            } else {
                DB::rollBack();
                return $error;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }



    public function mplImportday(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileName = microtime(true) * 1000000 . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);

            $sheetname = 'Дата база (сариқ)';
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(public_path('uploads') . '/' . $fileName);
            $data = $spreadsheet->getSheet(0)->toArray();

            unset($data[0]);
            unset($data[1]);
            unset($data[2]);
            $error = [];
            foreach ($data as $key => $value) {
                if ($value[5]) {
                    $vehicle = Vehicle::where('vin', $value[3])->first();
                    if (!$vehicle) {
                        $vehicle = new Vehicle();
                        $vehicle->vin = $value[3];
                        $vehicle->color = $value[4] == "Сариқ" ? 2 : 1;
                        $vehicle->modelname = $value[2];
                        // $vehicle->shift = ;
                        $vehicle->trim_by = Auth::id();
                        $vehicle->trim_at = date('Y-m-d H:i:s');
                        $vehicle->save();
                    }
                    for ($i = 0; $i < 20; $i++) {
                        $k = 5 + ($i * 2);
                        if ($value[$k]) {
                            $detail = Detail::where('part', $value[$k])->first();
                            if (!$detail) {
                                $error[] = ['detail' => $value[$k], 'error' => 2];
                                // $detail = new Detail();
                                // $detail->part = $value[$k];
                                // $detail->save();
                            } else {
                                $order = Order::where('vehicle_id', $vehicle->id)->where('detail_id', $detail->id)->first();
                                if (!$order) {
                                    $order = new Order();
                                }
                                $order->created_by = Auth::id();
                                $order->setup_date = date('Y-m-d', strtotime($value[$k + 1]));
                                $order->upload_date = date('Y-m-d H:i:s');
                                $order->vehicle_id = $vehicle->id;
                                $order->detail_id = $detail->id;
                                $order->save();
                            }
                        } else break;
                    }
                }
            }
            unlink(public_path('uploads') . '/' . $fileName);
            if (empty($error)) {
                DB::commit();
                return  8;
            } else {
                DB::rollBack();
                return $error;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function mplImportupdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileName = microtime(true) * 1000000 . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);

            $sheetname = 'Дата база (сариқ)';
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(public_path('uploads') . '/' . $fileName);
            $data = $spreadsheet->getSheet(0)->toArray();

            unset($data[0]);
            unset($data[1]);
            unset($data[2]);
            $error = [];
            foreach ($data as $key => $value) {
                if ($value[4]) {
                    // $validate = $this->validateVin($value[3]);     
                    $vehicle = Vehicle::where('vin', $value[3])->first();
                    // $error[] = (!$vehicle)? ['vin'=>$value[3]]: '';
                    if (!$vehicle) {
                        $error[] = ['vin' => $value[3], 'error' => 1];
                    } else {
                        $order = Order::where('vehicle_id', $vehicle->id)->get();
                        for ($i = 0; $i < 20; $i++) {
                            $k = 4 + ($i);
                            // return $value[$k];
                            if ($value[$k]) {
                                $detail = Detail::where('part', $value[$k])->first();
                                if (!$detail) {
                                    $error[] = ['detail' => $value[$k], 'error' => 2];
                                    $error[] = ['vin' => $value[3], 'detail' => $value[$k], 'error' => 3];
                                } else {
                                    $order = Order::where('vehicle_id', $vehicle->id)->where('detail_id', $detail->id)->first();
                                }
                                if (!$order) {
                                    $error[] = ['vin' => $value[3], 'detail' => $value[$k], 'error' => 3];
                                } else {
                                    $order->status = 1;
                                    $order->updated_by = Auth::id();
                                    $order->save();
                                }
                            } else break;
                        }
                    }
                }
            }
            unlink(public_path('uploads') . '/' . $fileName);
            if (empty($error)) {
                DB::commit();
                return  8;
            } else {
                DB::rollBack();
                return $error;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function mplImportok(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileName = microtime(true) * 1000 . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);

            $sheetname = 'Дата база (сариқ)';
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(public_path('uploads') . '/' . $fileName);
            $data = $spreadsheet->getSheet(0)->toArray();

            unset($data[0]);
            unset($data[1]);
            unset($data[2]);
            $error = [];
            foreach ($data as $key => $value) {
                if ($value[3]) {
                    // $validate = $this->validateVin($value[3]);     
                    $vehicle = Vehicle::where('vin', $value[3])->first();
                    // $error[] = (!$vehicle)? ['vin'=>$value[3]]: '';
                    if (!$vehicle) {
                        $vehicle = new Vehicle();
                        $vehicle->vin = $value[3];
                        $vehicle->modelname = $value[2];
                        $vehicle->trim_by = Auth::id();
                        $vehicle->trim_at = date('Y-m-d H:i:s');
                    }
                    $vehicle->finish_by = Auth::id();
                    $vehicle->finish_at = date('Y-m-d H:i:s');
                    $vehicle->status = 8;
                    $vehicle->save();
                    $order = Order::where('vehicle_id', $vehicle->id)->get();
                    foreach ($order as $key => $or) {
                        $or->status = 1;
                        $or->updated_at = date('Y-m-d H:i:s');
                        $or->updated_by = Auth::id();
                        $or->update_type = 2;
                        $or->save();
                    }
                }
            }
            unlink(public_path('uploads') . '/' . $fileName);
            if (empty($error)) {
                DB::commit();
                return  8;
            } else {
                DB::rollBack();
                return $error;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function mplImportdetails(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileName = microtime(true) * 1000000 . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);

            $sheetname = 'Дата база (сариқ)';
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(public_path('uploads') . '/' . $fileName);
            $data = $spreadsheet->getSheet(0)->toArray();

            unset($data[0]);
            unset($data[1]);
            unset($data[2]);
            unset($data[3]);
            $error = [];
            foreach ($data as $key => $value) {
                if ($value[2]) {
                    // $validate = $this->validateVin($value[3]);     
                    $detail = Detail::where('part', $value[2])->first();
                    $empl = User::where('name', $value[5])->first();
                    if (!$empl) {
                        $empl = new User();
                        $empl->name = $value[5];
                        $empl->role_id = 6;
                        $empl->save();
                    }
                    // $error[] = (!$vehicle)? ['vin'=>$value[3]]: '';
                    if (!$detail) {
                        $detail = new Detail();
                    }
                    $detail->part = $value[2];
                    $detail->part_name = $value[3];
                    $detail->suplier = $value[4];
                    $detail->yetkazuvchi_employee_id = $empl->id;
                    $detail->save();
                }
            }
            unlink(public_path('uploads') . '/' . $fileName);
            DB::commit();
            return  8;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function mplImportsend(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileName = microtime(true) * 1000000 . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);

            $sheetname = 'Дата база (сариқ)';
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(public_path('uploads') . '/' . $fileName);
            $data = $spreadsheet->getSheet(0)->toArray();

            unset($data[0]);
            unset($data[1]);
            unset($data[2]);
            $error = [];
            foreach ($data as $key => $value) {
                if ($value[3]) {

                    $send_user = User::where('tbn', $value[5])->first();
                    if (!$send_user) {
                        $error[] = ['user' => $value[5], 'error' => 4];
                    }
                    // $validate = $this->validateVin($value[3]);     
                    $triler = TrilerDriver::where('out_tr_number', $value[7])
                        ->where('out_first_driver', $value[9])
                        ->where('out_second_driver', $value[10])->first();

                    if (!$triler) {
                        $triler = new TrilerDriver();
                        $triler->out_tr_number = $value[8];
                        $triler->out_first_driver = $value[9];
                        $triler->out_second_driver = $value[10];
                        $triler->save();
                    }

                    $warehouse = Warehouse::where('name', $value[11])->first();
                    if (!$warehouse) {
                        $warehouse = new Warehouse();
                        $warehouse->name = $value[11];
                        $warehouse->save();
                    }
                    $vehicle = Vehicle::where('vin', $value[3])->first();
                    // $error[] = (!$vehicle)? ['vin'=>$value[3]]: '';
                    if (!$vehicle) {
                        $vehicle = new Vehicle();
                        $vehicle->vin = $value[3];
                        $vehicle->modelname = $value[2];
                        $vehicle->color = $value[4] == "Сариқ" ? 2 : 1;
                        $vehicle->trim_by = Auth::id();
                        $vehicle->trim_at = date('Y-m-d H:i:s');
                        // $vehicle->send_by = Auth::id();
                    }
                    $vehicle->triler_driver_id = $triler->id;
                    $vehicle->status = 4;
                    $vehicle->send_by = $send_user ? $send_user->id : '';
                    $vehicle->warehouse_id = $warehouse->id;
                    $vehicle->send_at = $value[7] ? date('Y-m-d', strtotime($value[7])) : null;
                    $vehicle->save();
                }
            }
            unlink(public_path('uploads') . '/' . $fileName);
            if (empty($error)) {
                DB::commit();
                return  8;
            } else {
                DB::rollBack();
                return $error;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updatemodelname()
    {
        $vehicle = Vehicle::whereNull('modelname')->where('status', '!=', 9)->limit(5)->get();
        // return
        $avtomodel = [
            '13U19' => 'Lacetti',
            '1CQ48' => 'Spark',
            '1CR48' => 'Spark',
            '1EW76' => 'Tracker',
            '1EX69' => 'Tracker',
            '1EX76' => 'Tracker',
            '1EY69' => 'Tracker',
            '1EY76' => 'Tracker',
            '1JX69' => 'Cobalt',
            '1TF69' => 'Nexia R3'
        ];
        if ($vehicle) {
            foreach ($vehicle as $v) {
                $api = "https://edo-db2.uzautomotors.com/api/updatemodel/" . $v->vin;
                $veh = json_decode(file_get_contents($api));
                $v->modelname =($veh) ?  $avtomodel[trim($veh[0]->h06model)] : null;
                $v->save();
            }
            return 'success';
        }
        return 'NOT VEHICLE';
        // URL : http://bg4.uz/updatemodel
    }

    public function index(Request $request)
    {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];

        $mpl = Test::whereNull('deleted_at')->orderByDesc('id');
        if ($content) {
            $mpl->where(function ($q) use ($content) {
                $q->where('models', 'like', '%' . $content . '%')
                    ->orWhere('pono', 'like', '%' . $content . '%')
                    ->orWhere('vin', 'like', '%' . $content . '%')
                    ->orWhere('ga_seq', 'like', '%' . $content . '%')
                    ->orWhere('color', 'like', '%' . $content . '%')
                    ->orWhere('levl', 'like', '%' . $content . '%')
                    ->orWhere('part', 'like', '%' . $content . '%')
                    ->orWhere('part_name', 'like', '%' . $content . '%');
            });
        }
        // dd(gettype($mpl));
        return $mpl->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
        // $model = Test::paginate($itemsPerPage == '-1' ? 1000 : $itemsPerPage, ['*'], 'page name', $page);
        // return $model;
    }
    public function getFile(Request $request)
    {
        $product = $request->input('product');
        if ($product == 'C') {
            $path = 'DRWNEW/C (M300)';
        } else if ($product == 'RT') {
            $path = 'DRWNEW/RT (T250)';
        } else if ($product == 'J') {
            $path = 'DRWNEW/J (GSVEM)';
        } else if ($product == 'R7') {
            $path = 'DRWNEW/R7 (B150)';
        } else if ($product == 'R3') {
            $path = 'DRWNEW/R3 (J200)';
        } else if ($product == 'E') {
            $path = 'DRWNEW/E (GEM (BSUV B-CAR))';
        } else if ($product == 'R71') {
            $path = 'DRWNEW/R7 (B100)';
        } else if ($product == 'R72') {
            $path = 'DRWNEW/R7 (B150)';
        } else if ($product == 'gem') {
            $path = 'GEM';
        }
        $partnum = $request->input('partnum');
        // $partnum = 11560996;
        $partnum = '/' . $partnum . '/i';
        $checkFile = Storage::disk('ftp')->allFiles($path);
        $checkFile = array_values(preg_grep($partnum, $checkFile));
        // $checkFile = array_values($checkFile);

        $checkdir = Storage::disk('ftp')->allDirectories($path);
        $checkdir = array_values(preg_grep($partnum, $checkdir));
        // dd($checkdir);
        // $checkdir = array_values($checkdir);
        if ($checkdir != NULL && $checkFile != null) {
            $files = $this->recursive_directory($checkdir[0]);
            foreach ($checkFile as $value) {
                array_push($files, $value);
            }
            $filter = preg_grep($partnum, $files);
        } else if ($checkdir != NULL && $checkFile == null) {
            $files = $this->recursive_directory($checkdir[0]);
            $filter = preg_grep($partnum, $files);
        }

        // Agarda Papka nomi ham fayl nomi ham topilmasa barcha papkalardan izlab keladi
        else if ($checkdir == NULL && $checkFile == null) {
            // return 1;
            $files = $this->recursive_directory($path);
            // dd($files);
            $filter = preg_grep($partnum, $files);
        } else {
            $filter = preg_grep($partnum, $checkFile);
        }

        // Har bir papkani ichiga kirib izlash
        // $files = $this->recursive_directory($path);
        // $filter = preg_grep($partnum, $files);

        return $filter;
    }
    public function downloadFile(Request $request)
    {
        $path = $request->input("path");
        $file = Storage::disk('ftp')->get($path);
        return $file;
        // $imagename = 'birnarsa.tif';
        // Storage::disk('local')->put($imagename, $file);

        // $url = Storage::url($imagename);
        // return $url;
    }
    public function recursive_directory($dirname, $maxdepth = 10, $depth = 0)
    {
        $directorycheck = Storage::disk('ftp')->allDirectories($dirname);
        // dd($directorycheck);
        $filecheck = Storage::disk('ftp')->allFiles($dirname);

        foreach ($directorycheck as $subdirectory) {
            $filecheck = array_merge($filecheck, $this->recursive_directory($subdirectory, $maxdepth, $depth + 1));
        }
        return $filecheck;
        // $filter = preg_grep($partnum, $filecheck);


        // $subdirectories = array();
        // $files = array();

        // if ($directorycheck) {
        //     $subdirectories = $directorycheck;
        //     dd($subdirectories);
        // } else {
        //     array_push($filecheck, $directorycheck);
        // }

        // }
        // if ($depth >= $maxdepth) {
        //     return false;
        // }
        // if (is_dir($dirname) && is_readable($dirname)) {
        //     $d = dir($dirname);
        //     while (false !== ($f = $d->read())) {
        //         $file = $d->path . '/' . $f;
        //         // skip . and ..
        //         if (('.' == $f) || ('..' == $f)) {
        //             continue;
        //         };
        //         if (is_dir($dirname . '/' . $f)) {
        //             array_push($subdirectories, $dirname . '/' . $f);
        //         } else {
        //             array_push($files, $dirname . '/' . $f);
        //         };
        //     };
        //     $d->close();
        //     foreach ($subdirectories as $subdirectory) {
        //         $files = array_merge($files, $this->recursive_directory($subdirectory, $maxdepth, $depth + 1));
        //     };
        // }
    }
    public function compareRows(Request $request)
    {
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];
        $newversion = Test::orderByDesc('id')->pluck('version')->take(1);
        // dd($newversion);
        foreach ($newversion as $newInt) {
            $newversion = intval($newInt . value(''));
        }
        $newversionDb = Test::where('version', '=', $newversion);
        // $oldversionDb = Test::where('version', '=', $newversion - 1);
        // dd($newversionDb . 'partnum');
        // $oldversionDb = [];
        foreach ($newversionDb as $newData) {
            $oldversionDb = Test::whereRaw([
                ['partnum', '=', $newData->partnum],
                ['qty', '=', $newData->qty]
            ]);
            return $oldversionDb;
        }
        // $compare = $newversionDb::join($oldversionDb, $newversionDb . 'partnum', '=', $oldversionDb . 'partnum')
        //     ->where($oldversionDb->qty, '!=', $newversionDb->qty);
        // return $oldversionDb->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
    }
    public function zipDownload()
    {
        $zip      = new ZipArchive;
        $fileName = 'attachment.zip';
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = Storage::disk('ftp')->allFiles('DRWNEW/C (M300)/95994890 17-Aug-2010_002');
            // dd($files);
            foreach ($files as $value) {
                // dd($value);
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }
            $zip->close();
        }
        return response()->download(public_path($fileName));
    }
}
