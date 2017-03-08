<?php namespace App\Http\Controllers;

//load model
use App\Img_gallery_album;
use App\Img_gallery_list;
use Request;
use lib_generator;
use Validator;


//load auth
use Auth;

//load session
use Session;

//load redirect
use Illuminate\Support\Facades\Redirect;

//load datatables
use Datatables;

class Img_galleryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		//
		$parent_menu='Galeri';
		$act_menu='image_gallery';
		return view('image_gallery.index',compact('parent_menu','act_menu'));
	}

	/* list grid datatables */
	public function getBasicData()
    {
		$id_microsite	= Session::get('id_microsite');
       	$Img_gallery_album = Img_gallery_album::select(['id','album_name','description','created_at'])
        					->where('id_microsite','=', $id_microsite);

        return Datatables::of($Img_gallery_album)
        ->addColumn('action', function ($Img_gallery_album) {
        	return '<a Title="Edit" href="image_gallery/edit/'.$Img_gallery_album->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a> <a Title="Delete" href="javascript:void(0)" onclick="hapus('.$Img_gallery_album->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a> </a>';
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
		$parent_menu='Galeri';
		$act_menu='image_gallery';
		$show_list=FALSE;
		$post_url=url().'/image_gallery/store';
		return view('image_gallery.create',compact('show_list','post_url','parent_menu','act_menu'));

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
	        'album_name'		=> 'required',   
	        'description'			=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('image_gallery/create')->withInput()->with('error', $messages);

    	}else{

    		$album_name = Request::input('album_name');
			$description = Request::input('description');
			$user_data = Session::get('user_data');

			$newPost = new Img_gallery_album;
			$newPost->album_name 	= $album_name;
			$newPost->description 	= $description;
			$newPost->id_microsite 	= Session::get('id_microsite');
			$newPost->id_user 		= $user_data[0]['id'];

			$newPost->save();

			if(!$newPost){
				return Redirect::to('image_gallery/create')->withInput()->with('error', "Terjadi Kesalahan");
			}else{

				//return id
				if($newPost->id){
					//generate json use lib generator
					$image_gallery = new lib_generator;
					$image_gallery->image_gallery($newPost->id);
					
				}

				//direct
				return Redirect::to('image_gallery')->withInput()->with('success', "Data Berhasil disimpan");
				
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
		$parent_menu='Galeri';
		$act_menu='image_gallery';

        $list_image=Img_gallery_list::join('manajemen_images', 'img_gallery_lists.id_image', '=', 'manajemen_images.id')
            ->select('img_gallery_lists.id_image','manajemen_images.img_preview')
            ->where('img_gallery_lists.id_album', '=', $id)
            ->get();


		$Img_gallery_album=Img_gallery_album::find($id);
		$show_list=TRUE;
		$post_url=url().'/image_gallery/update';
		return view('image_gallery.create',compact('show_list','post_url','Img_gallery_album','list_image','parent_menu','act_menu'));
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
	        'album_name'		=> 'required',   
	        'description'		=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			
			$id 			= Request::input('id');
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('image_gallery/edit/'.$id)->withInput()->with('error', $messages);

    	}else{

    		$album_name = Request::input('album_name');
			$description = Request::input('description');
			$user_data = Session::get('user_data');
			$img_id = Request::input('img_id');
			$id = Request::input('id');
			$img_array=array();

			if($img_id)
			{
				foreach($img_id as $index=>$row)
				{
					$img_array[$index]=array(
										'id_album'=>$id,
										'id_image'=>$row,
										'created_at'=>date("Y-m-d H:i"),
										);
				}
			}

			$newPost = Img_gallery_album::find($id);
			$newPost->album_name 	= $album_name;
			$newPost->description 	= $description;
			$newPost->id_microsite 	= Session::get('id_microsite');
			$newPost->id_user 		= $user_data[0]['id'];
			$newPost->save();

			if(!$newPost){
				return Redirect::to('image_gallery/edit/'.$id)->withInput()->with('error', "Terjadi Kesalahan");		
			}else{

				//delete dulu, baru insert batch
				Img_gallery_list::where('id_album', $id)->delete();

				//insert batch
				Img_gallery_list::insert($img_array);


				//return id
				if($newPost->id){
					//generate json use lib generator
					$image_gallery = new lib_generator;
					$image_gallery->image_gallery($newPost->id);
					
				}

				//direct
				return Redirect::to('image_gallery')->withInput()->with('success', "Data Berhasil disimpan");
				
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

		//rule validation
	    $rules = array(
	    	'id'				=> 'required'         
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			App::abort(500, 'Error');	
    	}else{

    		$id = Request::input('id');
		
			$post = Img_gallery_album::find($id);
			$post->delete();
			if(!$post){
	    			App::abort(500, 'Error');
			}else{
				//delete juga detailny
				$delete = Img_gallery_list::where('id_album', $id)->delete();
				if($delete){
					echo "OK";
				}
			}
    	}

	}

}
