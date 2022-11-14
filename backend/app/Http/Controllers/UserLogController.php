<?php

namespace App\Http\Controllers;

use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (Auth::user()->role->name == 'admin') {
        $filter = $request->input('search');
        $content = isset($filter) ? $filter : 0;

        $page = $request->input('pagination')['page'];
        $itemsPerPage = $request->input('pagination')['itemsPerPage'];

        $userlog = UserLog::orderByDesc('id')->with('logBy');
        if ($content) {
            $userlog->where(function ($q) use ($content) {
                $q->where('request_json', 'like', '%' . $content . '%');
                // ->orWhere('product', 'like', '%' . $content . '%')
            });
        }
        // dd(gettype($userlog));
        return $userlog->paginate($itemsPerPage == '-1' ? 10000 : $itemsPerPage, ['*'], 'page name', $page);
        // $model = Test::paginate($itemsPerPage == '-1' ? 1000 : $itemsPerPage, ['*'], 'page name', $page);
        // return $model;
        // } else {
        //     return response(403);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserLog $userLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLog $userLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLog $userLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLog $userLog)
    {
        //
    }
}
