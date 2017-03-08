<?php namespace App\Http\Controllers;

//load model
use App\User;
use App\Group_user;

//load request
use Request;
use Validator;


//load auth
use Auth;

//load session
use Session;

//load redirect
use Illuminate\Support\Facades\Redirect;

//load datatables
use Datatables;

//load hash
use Hash;

class UserController extends Controller {
	
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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$parent_menu='Manajemen User';
		$act_menu='admin_user';
		return view('user.index',compact('parent_menu','act_menu'));
	}

	/* list grid datatables */
	public function getBasicData()
    {
    	//join table
    	$User = User::join('group_users', 'users.id_group', '=', 'group_users.id')
            ->select(['users.id', 'group_users.nama_group', 'users.email', 'users.name', 'users.status']);
		
        return Datatables::of($User)
        ->addColumn('action', function ($User) {
        	return '<a Title="Edit" href="user/edit/'.$User->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a> <a Title="Delete" href="javascript:void(0)" onclick="hapus('.$User->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a> </a>';
        })
        ->make(true);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$parent_menu='Manajemen User';
		$act_menu='admin_user';
		$Group_user = Group_user::all();
		return view('user.create',compact('Group_user','parent_menu','act_menu'));
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
	        'name'				=> 'required',   
	        'email'				=> 'required',
	        'password'			=> 'required',
	        'cmbgroup'			=> 'required',
	        'cmbstatus'			=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('user/create')->withInput()->with('error', $messages);

    	}else{

    		$name = Request::input('name');
			$email = Request::input('email');
			$passwordpost = Request::input('password');
			$cmbgroup = Request::input('cmbgroup');
			$cmbstatus = Request::input('cmbstatus');

			$password = Hash::make($passwordpost);

			$newPost = new User;
			$newPost->name 		= $name;
			$newPost->email 	= $email;
			$newPost->password 	= $password;
			$newPost->status 	= $cmbstatus;
			$newPost->id_group 	= $cmbgroup;
			$newPost->save();

			if(!$newPost){
				return Redirect::to('user/create')->withInput()->with('error', "Terjadi Kesalahan");	
			}else{
				//direct
				return Redirect::to('user')->withInput()->with('success', "Data Berhasil disimpan");
				
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
		$parent_menu='Manajemen User';
		$act_menu='admin_user';
		$User=User::find($id);
		$Group_user = Group_user::all();
		return view('user.edit',compact('Group_user','User','parent_menu','act_menu'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		//rule validation
	    $rules = array(
	    	'id'				=> 'required',   
	        'name'				=> 'required',   
	        'email'				=> 'required',
	        'cmbgroup'			=> 'required',
	        'cmbstatus'			=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			
			$id 			= Request::input('id');
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('user/edit/'.$id)->withInput()->with('error', $messages);

    	}else{
    		$id = Request::input('id');
			$name = Request::input('name');
			$email = Request::input('email');
			$cmbgroup = Request::input('cmbgroup');
			$cmbstatus = Request::input('cmbstatus');

			$newPost = User::find($id);
			$newPost->name 		= $name;
			$newPost->email 	= $email;
			$newPost->status 	= $cmbstatus;
			$newPost->id_group 	= $cmbgroup;
			$newPost->save();

			if(!$newPost){
				return Redirect::to('user/edit/'.$id)->withInput()->with('error', "Terjadi Kesalahan");
			}else{
				//direct
				return Redirect::to('user')->withInput()->with('success', "Data Berhasil disimpan");
			}
    	}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		//
		//rule validation
	    $rules = array(
	    	'id'				=> 'required'         
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			App::abort(500, 'Error');	
    	}else{

    		$id = Request::input('id');	
			$post = User::find($id);
			$post->delete();

			if(!$post){
	    		App::abort(500, 'Error');
			}else{
				echo "OK";

			}
    	}

		
		
	}

}
