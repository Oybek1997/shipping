<?php

namespace App\Imports;

use App\Detail;
use App\Test;
use App\Vehicle;
use App\Vehicle_detail;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class TestsImport implements ToModel, WithStartRow, WithCalculatedFormulas
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function startRow(): int
    {
        return 3;
    }

    public function model(array $row)
    {
        $vehicle = Vehicle::where('vin', $row[3])->first();
        if (!$vehicle) {
            $vehicle = new Vehicle();
                $vehicle->name = $row[1];
                $vehicle->pono = $row[2];
                $vehicle->vin = $row[3];
                $vehicle->ga_seq = $row[4];
                $vehicle->color = $row[5];
                $vehicle->levl = $row[6];
                $vehicle->save();

        }
        $part = 'GM'.$row[8];
        $detail = Detail::where('part', $part)->first();       
       

        $vehicle_detail = new Vehicle_detail();

        $vehicle_detail->supplychain_employee_id = Auth::id(); 
        $vehicle_detail->quality_employee_id = 1; //* kachestvani xodimi
        $vehicle_detail->change = 1; // * smena
        $vehicle_detail->color = 1;
        $vehicle_detail->production_date = new DateTime(); //* kiritilgan sana
        $vehicle_detail->vehicle_id =$vehicle->id;
        $vehicle_detail->detail_id =$detail->id;
        $vehicle_detail->delivery_date = new DateTime();
        $vehicle_detail->updated_at = null;
        $vehicle_detail->save();


    }
}
