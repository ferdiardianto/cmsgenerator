<?php namespace App\Http\Controllers;

//load model
use App\video_gallery;
use Request;
use lib_generator;
use Validator;


//load auth
use Auth;

//load session
use Session;

//load redirect
use Illuminate\Support\Facades\Redirect;

class Video_galleryController extends Controller {


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
		$id_microsite=Session::get('id_microsite');
		$list_video = video_gallery::where('id_microsite','=',$id_microsite)->get();
		$parent_menu='Galeri';
		$act_menu='video_gallery';
		return view('video_gallery.index',compact('parent_menu','act_menu','list_video'));
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
		//
		//rule validation
	    $rules = array(
	        'title'				=> 'required',   
	        'video_url'			=> 'required',
	        'deskripsi'			=> 'required'                 
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('video_gallery')->withInput()->with('error', $messages);

    	}else{

    		$title = Request::input('title');
			$video_url = Request::input('video_url');
			$deskripsi = Request::input('deskripsi');
			$user_data = Session::get('user_data');

			$query_string = array();
			parse_str(parse_url($video_url, PHP_URL_QUERY), $query_string);
			$id_url = @$query_string["v"];

			$newPost = new video_gallery;
			$newPost->title 		= $title;
			$newPost->video_url 	= $video_url;
			$newPost->embed_url 	= 'http://www.youtube.com/embed/'.$id_url;
			$newPost->description 	= $deskripsi;
			$newPost->large_img 	= 'http://i1.ytimg.com/vi/'.$id_url.'/hqdefault.jpg';
			$newPost->thumb_img 	= 'http://i1.ytimg.com/vi/'.$id_url.'/mqdefault.jpg';
			$newPost->id_microsite 	= Session::get('id_microsite');
			$newPost->id_user 		= $user_data[0]['id'];

			$newPost->save();

			if(!$newPost){
				return Redirect::to('video_gallery')->withInput()->with('error', "Terjadi Kesalahan");
			}else{

				//return id
				if($newPost->id){
					//generate json use lib generator
					$video_detail = new lib_generator;
					$video_detail->video_detail($newPost->id);
				}

				//direct
				return Redirect::to('video_gallery')->withInput()->with('success', "Data Berhasil disimpan");
				
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

			$post = video_gallery::find($id);
			$post->delete();
			if(!$post){
	    		App::abort(500, 'Error');
			}else{
				$video_list_gallery = new lib_generator;
				$video_list_gallery->video_list_gallery();
				echo "OK";
			}
    	}
	}

}
