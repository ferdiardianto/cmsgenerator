<?php namespace App\Http\Controllers;


//load model
use App\Category_article;

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

use lib_generator;

class Category_articleController extends Controller {

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
		$parent_menu='Posting';
		$act_menu='category_posting';
		return view('category_article.index',compact('parent_menu','act_menu'));
	}


	/* list grid datatables */
	public function getBasicData()
    {
		$id_microsite	= Session::get('id_microsite');
    	$category_posting = Category_article::select(['id','category_name','status'])
    						->where('id_microsite','=', $id_microsite);

        return Datatables::of($category_posting)
        ->addColumn('action', function ($category_posting) {
        	return '<a data-toggle="tooltip" title="Edit" href="category_article/edit/'.$category_posting->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a> <a data-toggle="tooltip" title="Hapus" href="javascript:void(0)" onclick="hapus('.$category_posting->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a> </a>';
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
		$parent_menu='Posting';
		$act_menu='category_posting';
		return view('category_article.create',compact('parent_menu','act_menu'));
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
	        'category_name'		=> 'required',   
	        'status'			=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('category_article/create')->withInput()->with('error', $messages);

    	}else{

    		$category_name = Request::input('category_name');
			$status = Request::input('status');
			$user_data = Session::get('user_data');

			$newPost = new Category_article;
			$newPost->category_name 	= $category_name;
			$newPost->status 			= $status;
			$newPost->id_microsite 		= Session::get('id_microsite');
			$newPost->id_user 			= $user_data[0]['id'];

			$newPost->save();

			if(!$newPost){
				return Redirect::to('category_article/create')->withInput()->with('error', "Terjadi Kesalahan");
			}else{	
				//direct
				return Redirect::to('category_article')->withInput()->with('success', "Data Berhasil disimpan");
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
		$parent_menu='Posting';
		$act_menu='category_posting';
		$Category_article=Category_article::find($id);
   		return view('category_article.edit',compact('Category_article','parent_menu','act_menu'));
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
	        'category_name'		=> 'required',   
	        'status'			=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			
			$id 			= Request::input('id');
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('category_article/edit/'.$id)->withInput()->with('error', $messages);

    	}else{

    		$id 			= Request::input('id');
	   		$category_name 	= Request::input('category_name');
	   		$status 		= Request::input('status');

	   		$newPost = Category_article::find($id);
			$newPost->category_name 	= $category_name;
			$newPost->status 			= $status;
			$newPost->save();
			
			if(!$newPost){
				return Redirect::to('category_article/edit/'.$id)->withInput()->with('error', "Terjadi Kesalahan");
			}else{	
				//direct
				return Redirect::to('category_article')->withInput()->with('success', "Data Berhasil disimpan");
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
			$post = Category_article::find($id);
			$post->delete();

			if(!$post){
	    		App::abort(500, 'Error');
			}else{
				echo "OK";
			}
    	}

	}

}
