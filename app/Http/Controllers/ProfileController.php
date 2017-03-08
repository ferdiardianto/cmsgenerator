<?php namespace App\Http\Controllers;

//load model
use App\Microsite;

use Request;
use Validator;


//load auth
use Auth;

//load session
use Session;

use lib_generator;

//load redirect
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$parent_menu='Pengaturan';
		$act_menu='profile_setting';
		$id_microsite	= Session::get('id_microsite');
		$Microsite=Microsite::find($id_microsite);

		return view('profile_setting.index',compact('parent_menu','act_menu','Microsite'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//rule validation
	    $rules = array(
	        'id'		=> 'required',   
	        'website_name'			=> 'required',
	        'slogan'			=> 'required',
	        'description'			=> 'required',
	        'author'			=> 'required',
	        'email'			=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('profile_setting')->withInput()->with('error', $messages);

    	}else{

    		$id_microsite	= Session::get('id_microsite');
			$id = Request::input('id');
			$website_name = Request::input('website_name');
			$slogan = Request::input('slogan');
			$description = Request::input('description');
			$author = Request::input('author');
			$email = Request::input('email');
	
			$newPost = Microsite::find($id);
			$newPost->website_name 		= $website_name;
			$newPost->slogan 			= $slogan;
			$newPost->description 		= $description;
			$newPost->author 			= $author;
			$newPost->email 			= $email;

			$newPost->save();
			if(!$newPost){
				return Redirect::to('profile_setting')->withInput()->with('error', "Terjadi Kesalahan");
			}else{
				
				//generate json use lib generator
				$profile = new lib_generator;
				$profile->profile($id_microsite);

				//direct
				return Redirect::to('profile_setting')->withInput()->with('success', "Data Berhasil disimpan");
				
			}

    	}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
