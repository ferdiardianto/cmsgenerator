<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//load session
use Session;

//load model
use App\User;


class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	//disable regiteer
	public function getRegister()
	{
		return redirect('auth/login'); // or something else
	}

	public function getLogout()
    {
        $this->auth->logout();
        Session::flush();
        return redirect('/');
    }

    public function postLogin(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        //cek count
        $user_data=User::join('group_users', 'users.id_group', '=', 'group_users.id')
	            ->select('users.id_group', 'users.id', 'users.name', 'users.email', 'group_users.nama_group', 'group_users.hak_akses')
	            ->where('users.email', '=', $email)
	            ->where('users.status', '=', 1)
	            ->get();

	    $count = count($user_data);

	    if($count>=1){

	        if ($this->auth->attempt(['email' => $email, 'password' => $password]))
	        {
	                    
	            $putsession = Session::put('user_data', $user_data);
	            if (Session::has('user_data'))
	            {
	                //
	                return redirect('home');
	            }
	            
	        }
	        return redirect('auth/login')->withErrors([
	            'email' => 'Email dan Kata Sandi tidak cocok,coba lagi?',
	        ]);
	     }else{
	     	return redirect('auth/login')->withErrors([
	            'email' => 'Akun tidak aktif',
	        ]);
	     }
	        
	   

    }

}
