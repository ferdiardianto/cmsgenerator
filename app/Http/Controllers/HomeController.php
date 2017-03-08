<?php namespace App\Http\Controllers;
//load model
use App\Microsite;
use Request;
use Validator;


//load auth
use Auth;

//load session
use Session;

//load redirect
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//buat dapetin array drop down, dan llempar ke view
		$user_data = Session::get('user_data');
		$id_group = $user_data[0]['id_group'];

        $Microsite=Microsite::join('group_microsites', 'microsites.id', '=', 'group_microsites.id_microsite')
            ->select('microsites.id', 'microsites.website_name', 'microsites.slogan', 'microsites.author', 'microsites.description', 'microsites.email', 'microsites.themes', 'microsites.subdomain', 'microsites.user_id', 'microsites.created_at', 'microsites.updated_at')
            ->where('group_microsites.id_group_user', '=', $id_group)
            ->get();

		$act_menu='Home';
		$id_microsite=Session::get('id_microsite');
		return view('home',compact('Microsite','id_microsite','act_menu'));

	}

	public function create_microsite(){
		$act_menu='Home';
		return view('create_microsite',compact('act_menu'));
	}

	public function do_save_microsite(){
		
		//rule validation
	    $rules = array(
	        'website_name'		=> 'required',   
	        'subdomain'			=> 'required',
	        'slogan'			=> 'required',
	        'author'			=> 'required',
	        'email'				=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('home/create_microsite')->withInput()->with('error', $messages);

    	}else{

		    $newPost = new Microsite;
		   	$website_name = Request::input('website_name');
		   	$subdomain = Request::input('subdomain');
		   	$slogan = Request::input('slogan');
		   	$author = Request::input('author');
		   	$email = Request::input('email');
		   	$user_id = Auth::user()->getId();
		
			$newPost->website_name 	= $website_name;
			$newPost->subdomain 	= $subdomain;
			$newPost->slogan		= $slogan;
			$newPost->author 		= $author;
			$newPost->email 		= $email;
			$newPost->user_id		= $user_id;
			$newPost->save();

			if(!$newPost){
				return Redirect::to('home/create_microsite')->withInput()->with('error', "Terjadi Kesalahan");
			}else{	
				//direct
				return Redirect::to('home')->withInput()->with('success', "Data Berhasil disimpan");
			}	
    	}	
	}

	public function do_changemicrosite(){
		$id_microsite = Request::input('id_microsite');
		$putsession = Session::put('id_microsite', $id_microsite);
		if (Session::has('id_microsite'))
		{
		    //
		    echo "OK";
		}
	}

}
