<?php namespace App\Http\Controllers;

//load model
use App\Article_headline;
use App\Cover_headline;
use App\Article;

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

use lib_generator;

//load datatables
use Datatables;

class Frontpage_setting extends Controller {

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
		$id_microsite=Session::get('id_microsite');
		$parent_menu='Pengaturan';
		$act_menu='frontpage_setting';

	 	$list_headline=Article_headline::join('articles', 'article_headlines.id_article', '=', 'articles.id')
	            ->select('article_headlines.id', 'article_headlines.id_article', 'articles.title', 'articles.thumb_img', 'articles.prev_img')
	            ->where('article_headlines.id_microsite', '=', $id_microsite)
	            ->get();

		$cover = Cover_headline::where('id_microsite','=',$id_microsite)
				->first();



		return view('frontpage_setting.index',compact('parent_menu','act_menu','list_headline','cover'));


	}

	function do_upload(){
		if(Input::file('userfile')!=""){

			// getting all of the post data
	  		$file = array('image' => Input::file('userfile'));

	  		// setting up rules
	  		$rules = array('image' => 'required', 'image' => 'mimes:jpeg,bmp,png'); //mimes:jpeg,bmp,png and for max size max:10000

	  		// doing the validation, passing post data, rules and the messages
	  		$validator = Validator::make($file, $rules);
	  		if ($validator->fails()) {
	    		// send back to the page with the input data and errors
	    		return Redirect::to('frontpage_setting')->withInput()->with('error', 'Terjadi Kesalahan, coba lagi.');
	    	}else{

	    		// checking file is valid.
	    		if (Input::file('userfile')->isValid()) {

	    			$destinationPath = 'uploads/image'; // upload path
	      			$extension = Input::file('userfile')->getClientOriginalExtension(); // getting image extension
	      			$fileName = rand(11111,99999).'.'.$extension; // renaming image
	      			Input::file('userfile')->move($destinationPath.'/origin/', $fileName); // uploading file to given path
			      	
	      			//resize
	      			//preview
	      			$manipulation = ImageIntervention::make($destinationPath.'/origin/' . $fileName);
					$manipulation->resize(780, null, function ($constraint) {
    					$constraint->aspectRatio();
					});
					$manipulation->save($destinationPath.'/cover/' . $fileName);

					//save to database
					$user_data = Session::get('user_data');
					$caption = Request::input('caption');
					$id_cover = Request::input('id_cover');

					if($id_cover!=""){
						$newPost = Cover_headline::find($id_cover);	
					}else{
						$newPost = new Cover_headline;
					}
					
					$newPost->image 		= $destinationPath.'/cover/' . $fileName;
					$newPost->caption 		= $caption;
					$newPost->id_user 		= $user_data[0]['id'];
					$newPost->id_microsite 	= Session::get('id_microsite');
					$newPost->save();

					//generate wp
					$wp = new lib_generator;
					$wp->wp();

			      	// sending back with message
			      	return Redirect::to('frontpage_setting')->withInput()->with('success', 'Upload file berhasil.');
	    		}else {
			      	// sending back with error message.
			      	return Redirect::to('frontpage_setting')->withInput()->with('error', 'Terjadi Kesalahan, coba lagi.');
	    		}

	    	}

		}else{
	    	return Redirect::to('frontpage_setting')->withInput()->with('error', 'File upload kosong.');
	    }

	}	


	//get detail grid
	public function getBasicData()
    {
		$id_microsite=Session::get('id_microsite');
    	$Article = Article::select(['id','title','teaser','content','thumb_img','prev_img','created_at'])
    				->orderBy('created_at', 'desc')
    				->where('id_microsite','=', $id_microsite);

        return Datatables::of($Article)
        ->addColumn('action', function ($Article) {
        	return '<a href="javascript:void(0)" onclick="select_article(\''.$Article->id.'\',\''.$Article->title.'\',\''.$Article->prev_img.'\')" class="btn btn-xs btn-primary">Pilih</a> </a>';
        })
        ->make(true);
    }

	function popup(){

		if(Request::ajax()) // This is check ajax request
    	{
			return view('frontpage_setting.grid');
    	}else{
    		App::abort(500, 'Error');
    	}

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
		$user_data = Session::get('user_data');
		$id_microsite=Session::get('id_microsite');
		$id = Request::input('article_id');

		if($id)
		{
			//deleete berdasarkan microsite
			$delete = Article_headline::where('id_microsite','=',$id_microsite)->delete();
				
			foreach($id as $row)
			{
				//insert ke database
				$newPost = new Article_headline;
				$newPost->id_article 		= $row;
				$newPost->id_microsite 		= $id_microsite;
				$newPost->id_user 			= $user_data[0]['id'];
				$newPost->save();
			}

			//generator 
			//WP
			$wp = new lib_generator;
			$wp->wp();


			return Redirect::to('frontpage_setting')->withInput()->with('success', 'Headline Tersimpan');


		}else{
	    	return Redirect::to('frontpage_setting')->withInput()->with('error', 'Headline tidak boleh kosong.');
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
