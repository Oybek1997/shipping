<?php

namespace App\Http\Controllers;

use Adldap\Laravel\Facades\Adldap;
use App\Imports\UsersImport;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    //Original login function
//    public function login()
//    {
//        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
//            $user = Auth::user();
//            $success['token'] = $user->createToken('MyApp')->accessToken;
//            return response()->json(['success' => $success], $this->successStatus);
//        } else {
//            return response()->json(['error' => 'Unauthorised'], 401);
//        }
//    }





    public function login(Request $request)
    {
        $auth = $request->header('Authorization');
        $auth_array = explode(" ", $auth);
        $un_pw = explode(":", base64_decode($auth_array[1]));
        $login = $un_pw[0];
        $password = $un_pw[1];

       // return $login;

        //dd($login);
        $user = Adldap::search()->findBy('sAMAccountname', $login);

        if ($user){
            $res['username'] = $user->samaccountname[0];
            $distinguishedname = $user->distinguishedname[0];
            $distinguishedname = substr($distinguishedname, strpos($distinguishedname, 'DC'), 1000);
            $res['account_suffix'] = str_replace(',', '.', str_ireplace('dc=', '', $distinguishedname));
        }else{
            return response()->json(['error' => 'User not found'], 401);
        }

        $login_ad = Adldap::auth()->attempt($res['username'] . '@' . $res['account_suffix'], $password, $bindAsUser = true);

        if ($login_ad){
            return response()->json(['success' => 'OK'], $this->successStatus);
        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }






    //--------------------------------
    //    public function actionGetFullname($tabno)
    //    {
    //        try {
    //            $user = \Yii::$app->ad->search()->findBy('employeenumber', $tabno);
    //            if ($user) {
    //                $fullname = $user->cn[0];
    //            } else {
    //                return false;
    //            }
    //            return $fullname;
    //        } catch (\Exception $ex) {
    //            return $ex->getMessage();
    //        }
    //    }

    //    -----------------------------------

    public function usercreate($tbn)
    {
        $user = Adldap::search()->findBy('employeenumber', $tbn);
        if ($user) {
            $username = $user->samaccountname[0];
            $fuulname = $user->cn[0];
            $email = $user->mail[0];
            $tbnumber = $user->employeenumber[0];
            return [
                'username' => $username,
                'name' => $fuulname,
                'email' => $email,
                'tbnumber' => $tbnumber
            ];
        }
    }

    public function simpleusercreate(Request $request)
    {
        //return $request->username;

        $this->validate($request, [
            'tbnumber' => '',
            'username' => 'required',
            'name' => 'required',
            'email' => '',
            'role' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);



        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        //return $input['password'];
        $userModel = new User();
        $userModel->username = $request->username;
        $userModel->tbn = $request->tbnumber;
        $userModel->name = $request->username;
        $userModel->email = $request->email;
        $userModel->role_id = $request->role;
        $userModel->password = $input['password'];
        //return $userModel;
        $userModel->save();
        $success['token'] =  $userModel->createToken('MyApp')->accessToken;
        $success['name'] =  $userModel->name;
        return response()->json(['success' => $success], $this->successStatus);
    }

    //----------------------------------------
    //    public function getAdInfo($username)
    //    {
    //        $user = Adldap::search()->findBy('sAMAccountname', $username);
    //        if ($user) {
    //            $res['username'] = $user->samaccountname[0];
    //            $res['fullname'] = $user->cn[0];
    //            $res['employer_id'] = $user->employeenumber[0];
    //            $res['mail'] = $user->mail[0];
    //            $res['foto'] = base64_encode($user->thumbnailphoto[0]);
    //            $distinguishedname = $user->distinguishedname[0];
    //            $distinguishedname = substr($distinguishedname, strpos($distinguishedname, 'DC'), 1000);
    //            $res['account_suffix'] = str_replace(',', '.', str_ireplace('dc=', '', $distinguishedname));
    //        } else {
    //            return false;
    //        }
    //        return $res;
    //    }
    // --------------------------------------

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //        $validator = Validator::make($request->all(), [
        //            'name' => 'required',
        //            'email' => 'required|email',
        //            'password' => 'required',
        //            'c_password' => 'required|same:password',
        //        ]);
        //        if ($validator->fails()) {
        //            return response()->json(['error'=>$validator->errors()], 401);
        //        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        //        $success['name'] =  $user->name;
        //        return response()->json(['success'=>$success], $this-> successStatus);
        return "created okk";
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    //    public function details()
    //    {
    //        $user = Auth::user();
    //        return response()->json(['success' => $user], $this-> successStatus);
    //    }
    public function index()
    {



        //        $users = User::with('roles')
        //            ->with('roles.permissions')->get();
        //        return ['users' => $users,  'roles' => Role::get()];
        $users = User::with('role')->get();
        return ['users' => $users];
    }

    public function show()
    {
        // return 55;
        //        return User::with('roles.permissions:name')
        //            ->where('id', Auth::id())->first();
        return User::where('id', Auth::id())->with('role')->first();
        //        return $id = Auth::id();
    }

    public function update(Request $request)
    {
        $username = $request['username'];
        $user = User::withTrashed()->where('username', $username)->first();
        // dd($user);
        if (!$user) {
            $user = new User();
            $user->username = $request['username'];
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->role_id = $request['role'];
            $user->tbn = $request['tbnumber'];
        } else {
            $user->deleted_at = null;
            $user->role_id = $request['role'];
        }

        $user->save();

        return $user;
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        // dd($user);
        // $user->delete();
    }

    //    public function import(Request $request)
    //    {
    //        $request->validate([
    //            'import_file' => 'required|file|mimes:xls,xlsx'
    //        ]);
    //
    //        $path = $request->file('import_file');
    //        $data = Excel::import(new UsersImport, $path);
    //
    //        return response()->json(['message' => 'uploaded successfully'], 200);
    //    }

    public function getRoles()
    {
        $roles = Role::get();
        return $roles;
    }
}
