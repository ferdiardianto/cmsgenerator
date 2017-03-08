<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
//load session
use Session;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
		//$this->cek_login();
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('auth/login');
			}
		}else{
			$this->cek_login();
		}

		return $next($request);
	}


	public function cek_login(){

		$user_data = Session::get('user_data');
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$hak_akses=explode("|",$user_data[0]['hak_akses']);
		array_push($hak_akses,"home","forbidden","image_manager");
		$return=FALSE;
		//var_dump($hak_akses);die;
		foreach($hak_akses as $row)
		{
			if(strstr($actual_link, $row)!==FALSE)
			{
				$return=TRUE;
				break;
			}
			else
			{
				$return=FALSE;
			}
		}
		
		if($return==FALSE)
		{
			if($actual_link != url())
			{
				
				header("Location: ".url()."/forbidden");
				die();

			}
			
		}


	}

}
