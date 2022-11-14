<?php

namespace App\Exports;

use App\Test;
use Maatwebsite\Excel\Concerns\FromCollection;

class TestsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Test::all();
    }
}
