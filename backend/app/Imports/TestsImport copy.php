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
    // public function  __construct($version)
    // {
    //     // $this->version = $version;
    // }
    public function model(array $row)
    {
        $vehicle = Vehicle::where('vin', $row[3])->first();
        if (!$vehicle) {

            $vehicle = Vehicle::create([
                'name' => $row[1],
                'pono' => $row[2],
                'vin' => $row[3],
                'ga_seq' => $row[4],
                'color' => $row[5],
                'levl' => $row[6],
            ]);
        }

        $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        // $detail1 = Detail::where('part', $row[7])->first();
        if (!$detail1) {
            $detail1 = Detail::create([
                'part' => $row[7],
                'part_name' => $row[8],
                'suplier' => 1,
                'source' => 1,
            ]);
        }

        $vehicle_detail = new Vehicle_detail();
        $vehicle_detail->supplychain_employee_id = Auth::id();
        $vehicle_detail->quality_employee_id = 1;
        $vehicle_detail->change = 1;
        $vehicle_detail->production_date = new DateTime();
        $vehicle_detail->vehicle_id =$vehicle->id;
        $vehicle_detail->detail_id =$detail->id;
        $vehicle_detail->delivery_date = new DateTime();
        $vehicle_detail->save();



        // return new Vehicle_detail([
        //     'supplychain_employee_id' =>  Auth::id(),
        //     'quality_employee_id' => 1,
        //     'change' =>  1,
        //     'production_date' => new DateTime(),
        //     'vehicle_id' =>  $vehicle->id,
        //     'detail_id' =>  $detail->id,
        //     'delivery_date' => new DateTime(),
        // ]);


        // 'year' => $row['year'],
        // 'product' => $row['product'],
        // 'funpartmod' => $row['functional_name_modifier'],

        // 'partnum' => $row['part no.'],
        // 'partname' => $row['part_name'],
        // 'qty' => $row['qty'],
        // 'hand' => $row['l/r_hand'],
        // 'drawingno' => $row['drawing_no.'],
        // 'dwgrevdate' => $row['dwg._Rev._date'],
        // 'engineername1' => $row['eng._name_1'],
        // 'engineergroup1' => $row['engineer_group_description_1'],
        // 'engineername2' => $row['eng._name'],
        // 'engineergroup2' => $row['engineer_group_description_2'],
        // 'ewo' => $row['ewo'],
        // 'model' => $row['model_code'],
        // 'bodystyle' => $row['body_style'],
        // 'options' => $row['options'],
        // 'firstyear' => $row['first_yr'],
        // 'lastyear' => $row['last_yr'],
        // 'makefrom' => $row['make_from'],
        // 'version' => $this->version,
        // $employeeId = Test::where('tabel', '=', $row[0])
        //     ->first();
        // $user = EmployeeEducationHistory::where('employee_id', '=', $employeeId->id)->first();
        // // dd($user);
        // if ($user == null) {

        //     $degree = HrStudyDegree::where('name_uz_cyril', '=', $row[1])
        //         ->first();

        //     if ($degree == null) {
        //         $degree = new HrStudyDegree();
        //         $degree->name_uz_latin = $row[1];
        //         $degree->name_uz_cyril = $row[1];
        //         $degree->name_ru = $row[1];
        //         $degree->save();

        //         $studyDegree = $degree;
        //     } else {
        //         $studyDegree =  $degree;
        //     }

        //     $univer = HrUniversity::where('name_uz_cyril', '=', $row[2])
        //         ->first();

        //     if ($univer == null) {
        //         $univer = new HrUniversity();
        //         $univer->name_uz_latin = $row[4];
        //         $univer->name_uz_cyril = $row[2];
        //         $univer->name_ru = $row[3];
        //         $univer->save();

        //         $university = $univer;
        //     } else {
        //         $university =  $univer;
        //     }

        //     $major = HrMajor::where('name_uz_cyril', '=', $row[5])
        //         ->first();
        //     if ($major == null) {
        //         $major = new HrMajor();
        //         $major->name_uz_latin = $row[7];
        //         $major->name_uz_cyril = $row[5];
        //         $major->name_ru = $row[6];
        //         $major->save();

        //         $maj = $major;
        //     } else {
        //         $maj =  $major;
        //     }

        //     $studyType = HrStudyType::where('name_uz_cyril', '=', $row[9])
        //         ->first();
        //     if ($studyType == null) {
        //         $studyType = new HrStudyType();
        //         $studyType->name_uz_latin = $row[9];
        //         $studyType->name_uz_cyril = $row[9];
        //         $studyType->name_ru = $row[9];
        //         $studyType->save();

        //         $type = $studyType;
        //     } else {
        //         $type =  $studyType;
        //     }
        //     if ($row[8] == null) {
        //         $row[8] = NULL;
        //     } else {
        //         $row[8] = $row[8] . '-01-01';
        //     }
        //     return new EmployeeEducationHistory([

        //         'employee_id' => $employeeId->id,
        //         'study_degree_id' => $studyDegree->id,
        //         'university_id' => $university->id,
        //         'major_id' => $maj->id,
        //         'end_date' => $row[8],
        //         'study_type_id' => $type->id,
        //     ]);
        // }
    }
}
