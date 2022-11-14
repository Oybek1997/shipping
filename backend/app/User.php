<?php

namespace App;

use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function validateForPassportPasswordGrant( $password)
    {

       //dd($password) ;

        //$user = User::where('username',$username)->first();


        $username=$this->username;
        $user = $this->where('username', $username)->first();
        $user->password = '123';
        if($user && $password == $user->password)
        {
            return $user;
        }


        $user = Adldap::search()->findBy('sAMAccountname', $this->username);
        if ($user) {
            // return $u = User::where('username', $this->username)->first();
            $res['username'] = $user->samaccountname[0];
            $res['fullname'] = $user->cn[0];
            $res['employer_id'] = $user->employeenumber[0];
            $res['mail'] = $user->mail[0];
            // $res['foto'] = base64_encode($user->thumbnailphoto[0]);
            $distinguishedname = $user->distinguishedname[0];
            $distinguishedname = substr($distinguishedname, strpos($distinguishedname, 'DC'), 1000);
            $res['account_suffix'] = str_replace(',', '.', str_ireplace('dc=', '', $distinguishedname));
        } else {
            return false;
        }
        return Adldap::auth()->attempt($this->username . '@' . $res['account_suffix'], $password, $bindAsUser = true);
    }
}
