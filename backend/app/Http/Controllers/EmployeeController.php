<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;
        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];

        $employee = Employee::whereNull('deleted_at');
        if ($content) {
            $employee->where(function ($q) use ($content) {
                $q->where('tabno', 'like', '%' . $content . '%')
                    ->orWhere('fio', 'like', '%' . $content . '%')
                    ->orWhere('otdel', 'like', '%' . $content . '%');
            });
        }
        // dd(gettype($employee));
        return $employee->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
        // $model = Test::paginate($itemsPerPage == '-1' ? 1000 : $itemsPerPage, ['*'], 'page name', $page);
        // return $model;
    }
    public function update(Request $request)
    {
        $id = $request['tabno'];
        $employee = Employee::where('tabno', $id)->first();
        // dd($user);
        if (!$employee) {
            $employee = new Employee();
            $employee->tabno = $request['tabno'];
            $employee->fio = $request['fio'];
            $employee->otdel = $request['otdel'];
        } else {
            $employee->fio = $request['fio'];
            $employee->otdel = $request['otdel'];
        }

        $employee->save();

        return $employee;
    }
    public function destroy($id)
    {
        Employee::find($id)->delete();
    }
}
