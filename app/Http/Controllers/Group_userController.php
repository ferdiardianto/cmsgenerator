<?php namespace App\Http\Controllers;

//load model
use App\Group_user;
use App\Microsite;
use App\group_microsite;

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


class Group_userController extends Controller {


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
		$parent_menu='Manajemen User';
		$act_menu='group_user';
		return view('group_user.index',compact('parent_menu','act_menu'));
	}

	/* list grid datatables */
	public function getBasicData()
    {
       	$Group_user = Group_user::select(['id','nama_group','hak_akses']);
        return Datatables::of($Group_user)
        ->addColumn('action', function ($Group_user) {
        	return '<a Title="Edit" href="group_user/edit/'.$Group_user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a> <a Title="Delete" href="javascript:void(0)" onclick="hapus('.$Group_user->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a> </a>';
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
		$act_menu='group_user';
		$Microsite = Microsite::all();
		return view('group_user.create',compact('Microsite','parent_menu','act_menu'));
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
	        'nm_group'		=> 'required',   
	        'chek_menu'		=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('group_user/create')->withInput()->with('error', $messages);

    	}else{

		   	$nm_group = Request::input('nm_group');
		   	$chek_menu = Request::input('chek_menu');
			if($chek_menu){
				$chek_menu= implode("|",$chek_menu);
			}

			$newPost = new Group_user;
			$newPost->nama_group 	= $nm_group;
			$newPost->hak_akses 	= $chek_menu;
			$newPost->save();

			if(!$newPost){
				return Redirect::to('group_user/create')->withInput()->with('error', "Terjadi Kesalahan");
			}else{
				
				$web_id = Request::input('web_id');
				if($web_id){
					foreach($web_id as $index=>$row)
					{
						//insert foreach group user
						$postgm = new group_microsite;
						$postgm->id_microsite 	= $row;
						$postgm->id_group_user 	= $newPost->id;
						$postgm->save();
					}

					//direct
					return Redirect::to('group_user')->withInput()->with('success', "Data Berhasil disimpan");
					
				}
				
				
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
		$act_menu='group_user';
		$Group_user=Group_user::find($id);
		$web_id = group_microsite::where('id_group_user', '=', $id)->get();
		$Microsite = Microsite::all();
		//var array
		$hak_akses = explode("|",$Group_user['hak_akses']);
   		return view('group_user.edit',compact('Group_user','web_id','hak_akses','Microsite','parent_menu','act_menu'));
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
	    	'id_group'		=> 'required',   
	        'nm_group'		=> 'required',   
	        'chek_menu'		=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			
			$id_group = Request::input('id_group');
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('group_user/edit/'.$id_group)->withInput()->with('error', $messages);

    	}else{
    		$id_group = Request::input('id_group');
		   	$nm_group = Request::input('nm_group');
		   	$chek_menu = Request::input('chek_menu');
			if($chek_menu){
				$chek_menu= implode("|",$chek_menu);
			}

			$newPost = Group_user::find($id_group);
			$newPost->nama_group 	= $nm_group;
			$newPost->hak_akses 	= $chek_menu;
			$newPost->save();
	
			if(!$newPost){
				return Redirect::to('group_user/edit/'.$id_group)->withInput()->with('error', "Terjadi Kesalahan");
			}else{
				
				$web_id = Request::input('web_id');
				if($web_id){
					//delete dlu
					group_microsite::where('id_group_user', $newPost->id)->delete();
					foreach($web_id as $index=>$row)
					{
						//insert foreach group user
						$postgm = new group_microsite;
						$postgm->id_microsite 	= $row;
						$postgm->id_group_user 	= $newPost->id;
						$postgm->save();
					}

					//direct
					return Redirect::to('group_user')->withInput()->with('success', "Data Berhasil disimpan");
					
				}
				
				
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

			$post = Group_user::find($id);
			$post->delete();

			if(!$post){
	    			App::abort(500, 'Error');
			}else{
				//delete juga detailny
				$delete = group_microsite::where('id_group_user', $id)->delete();
				if($delete){
					echo "OK";
				}

			}

    	}

	}

}
