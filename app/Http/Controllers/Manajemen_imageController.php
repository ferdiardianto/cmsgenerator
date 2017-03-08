<?php namespace App\Http\Controllers;

//load model
use App\Manajemen_image;

use Request;
use Input;
use Validator;
use ImageIntervention;


//load auth
use Auth;

//load session
use Session;

//load redirect
use Illuminate\Support\Facades\Redirect;

//load datatables
use Datatables;

class Manajemen_imageController extends Controller {

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
		$act_menu='manage_image';
		return view('manajemen_image.index',compact('act_menu'));
	}

	/* list grid datatables */
	public function getBasicData()
    {
       	$Manajemen_image = Manajemen_image::select(['id','img_thumb','caption','created_at']);
        return Datatables::of($Manajemen_image)
        ->addColumn('action', function ($Manajemen_image) {
        	return '<a Title="Delete" href="javascript:void(0)" onclick="hapus('.$Manajemen_image->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a> </a>';
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
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		if(Input::file('userfile')!=""){
			// getting all of the post data
	  		$file = array('image' => Input::file('userfile'));

	  		// setting up rules
	  		$rules = array('image' => 'required', 'image' => 'mimes:jpeg,bmp,png'); //mimes:jpeg,bmp,png and for max size max:10000

	  		// doing the validation, passing post data, rules and the messages
	  		$validator = Validator::make($file, $rules);
	  		if ($validator->fails()) {
	    		// send back to the page with the input data and errors
	    		return Redirect::to('manajemen_image')->withInput()->with('error', 'Terjadi Kesalahan, coba lagi.');
	    	}else{

	    		// checking file is valid.
	    		if (Input::file('userfile')->isValid()) {
	    			$destinationPath = 'uploads/image'; // upload path
	      			$extension = Input::file('userfile')->getClientOriginalExtension(); // getting image extension
	      			$fileName = rand(11111,99999).'.'.$extension; // renaming image
	      			Input::file('userfile')->move($destinationPath.'/origin/', $fileName); // uploading file to given path
			      	

					$type_img = Request::input('type_img');

					if($type_img==1){

						$img_x1 = Request::input('img_x1') * 2;
						$img_y1 = Request::input('img_y1') * 2;
						$img_x2 = 390 * 2;
						$img_y2 = 195 * 2;

						//cropping
						$manipulation = ImageIntervention::make($destinationPath.'/origin/' . $fileName);
						$manipulation->resize(780, null, function ($constraint) {
	    					$constraint->aspectRatio();
						});
						
						//width, height, x, y
						$manipulation->crop($img_x2, $img_y2, $img_x1, $img_y1);
						$manipulation->save($destinationPath.'/preview/' . $fileName);

					}else{

						//resize dengan cara canvas
		      			$manipulation = ImageIntervention::make($destinationPath.'/origin/' . $fileName);
						
		      			//create canvas
						$background = ImageIntervention::canvas(780, 390);

						//$manipulation->fit(780, 390);
						$manipulation->resize(780, 390, function ($constraint) {
						   	$constraint->aspectRatio();
						    $constraint->upsize();
						});

						// insert resized image centered into background
						$background->insert($manipulation, 'center');

						$background->save($destinationPath.'/preview/' . $fileName);

					}
	      			
					//thumbnail
					$manipulation = ImageIntervention::make($destinationPath.'/origin/' . $fileName);
					$manipulation->resize(230, null, function ($constraint) {
    					$constraint->aspectRatio();
					});
					$manipulation->save($destinationPath.'/thumb/' . $fileName);

					//icon
					$manipulation = ImageIntervention::make($destinationPath.'/origin/' . $fileName);
					$manipulation->resize(90, null, function ($constraint) {
    					$constraint->aspectRatio();
					});
					$manipulation->save($destinationPath.'/icon/' . $fileName);
					
					//save to database
					$user_data = Session::get('user_data');
					$author = Request::input('author');
					$caption = Request::input('caption');

					$newPost = new Manajemen_image;
					$newPost->caption 		= $caption;
					$newPost->author 		= $author;
					$newPost->img_origin 	= $destinationPath.'/origin/'.$fileName;
					$newPost->img_preview 	= $destinationPath.'/preview/' . $fileName;
					$newPost->img_thumb 	= $destinationPath.'/thumb/' . $fileName;
					$newPost->img_icon 		= $destinationPath.'/icon/' . $fileName;
					$newPost->id_user 		= $user_data[0]['id'];
					$newPost->id_microsite 	= Session::get('id_microsite');
					$newPost->save();



			      	// sending back with message
			      	return Redirect::to('manajemen_image')->withInput()->with('success', 'Upload file berhasil.');
	    		}else {
			      	// sending back with error message.
			      	return Redirect::to('manajemen_image')->withInput()->with('error', 'Terjadi Kesalahan, coba lagi.');
	    		}

	    	}
	    }else{
	    	return Redirect::to('manajemen_image')->withInput()->with('error', 'File upload kosong.');
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
		

		//rule validation
	    $rules = array(
	    	'id'				=> 'required'         
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			App::abort(500, 'Error');	
    	}else{

    		$id = Request::input('id');
			$post = Manajemen_image::find($id);
			$post->delete();

			if(!$post){
	    		App::abort(500, 'Error');
			}else{
				echo "OK";
			}
    	}
	}

}
