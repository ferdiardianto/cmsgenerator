<?php namespace App\Http\Controllers;

//load model
use App\Article;
use App\Category_article;
use App\Tag;

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

class ArticleController extends Controller {

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
		$act_menu='article';
		return view('article.index',compact('parent_menu','act_menu'));
	}


	/* list grid datatables where id microsite ?belum */
	public function getBasicData()
    {
    	//variable yg dibutuhkan
		$id_microsite	= Session::get('id_microsite');

    	//join table
    	$Article = Article::join('category_articles', 'articles.id_category', '=', 'category_articles.id')
            ->select(['articles.id', 'category_articles.category_name', 'articles.created_at', 'articles.title', 'articles.status'])
			->orderBy('articles.created_at', 'desc')
			->where('articles.id_microsite','=', $id_microsite);

        return Datatables::of($Article)
        ->addColumn('action', function ($Article) {
        	return '<a  title="Edit" href="article/edit/'.$Article->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a> <a title="Delete" href="javascript:void(0)" onclick="hapus('.$Article->id.')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a> </a>';
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
		//variable yg dibutuhkan
		$id_microsite	= Session::get('id_microsite');
		$parent_menu='Posting';
		$act_menu='article';
		$Tag = Tag::all();

		//ambil data category
		$Category_article = Category_article::where('id_microsite','=',$id_microsite)->get();
		
		return view('article.create',compact('Category_article','parent_menu','act_menu','Tag'));	
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
	        'title_article'		=> 'required',   
	        'teaser'			=> 'required',   
	        'content_article'	=> 'required',
	        'category_id'		=> 'required',
	        'status'			=> 'required'                        
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('article/create')->withInput()->with('error', $messages);

    	}else{
    		$title_article = Request::input('title_article');
    		$teaser = Request::input('teaser');
			$content_article = Request::input('content_article');
			$category_id = Request::input('category_id');
			$status = Request::input('status');
			$date_schedule = Request::input('date_schedule');
			$user_data = Session::get('user_data');
			$tag = Request::input('tag');

			if($tag!=""){
				$tagfinal ="";
				foreach ($tag as $key => $row) {
					$tagfinal.= $row.'|';

					//cek row
					$cekdata = Tag::where('name_tag','=',$row)->count();

					//insert row
					if($cekdata==0){
						$Tagpost = new Tag;
						$Tagpost->name_tag 			= $row;
						$Tagpost->id_microsite 		= Session::get('id_microsite');
						$Tagpost->id_user 			= $user_data[0]['id'];
						$Tagpost->save();
					}

				}

				$tagfinal = rtrim ($tagfinal, '|');
			}else{
				$tagfinal ="";
			}


			$status_schedule = (Request::input('status_schedule')=="") ? $status : Request::input('status_schedule');

			$newPost = new Article;
			$newPost->title 			= $title_article;
			$newPost->id_category 		= $category_id;
			$newPost->content 			= $content_article;
			$newPost->teaser 			= $teaser;
			$newPost->status 			= $status_schedule;
			$newPost->tag 				= $tagfinal;
			$newPost->date_schedule 	= $date_schedule;
			$newPost->id_microsite 		= Session::get('id_microsite');
			$newPost->id_user 			= $user_data[0]['id'];

			//buat catch image
			$img=get_image_attached($content_article);
			if($img)
			{
				$image=$img[0];
				$newPost->origin_img=$image;
				if (strpos($image,'http') !== false) 
				{
					$newPost->prev_img=$image;
					$newPost->thumb_img=$image;
					$newPost->icon_img=$image;
				}
				else
				{
					$replace_image = str_replace("uploads/image/origin/", "", $image);
					$newPost->prev_img="uploads/image/preview/".$replace_image;
					$newPost->thumb_img="uploads/image/thumb/".$replace_image;
					$newPost->icon_img="uploads/image/icon/".$replace_image;
				}
			}

			$newPost->save();
			if(!$newPost){
				return Redirect::to('article/create')->withInput()->with('error', "Terjadi Kesalahan");
			}else{
				//return id
				if($newPost->id){

					//generate json use lib generator
					$article_read = new lib_generator;
					$article_read->article_read($newPost->id);
				}

				//direct
				return Redirect::to('article')->withInput()->with('success', "Data Berhasil disimpan");
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
		//variable yg dibutuhkan
		$id_microsite	= Session::get('id_microsite');
		$parent_menu='Posting';
		$act_menu='article';

		//ambil data category
		$Category_article = Category_article::where('id_microsite','=',$id_microsite)->get();
		
		$Tag = Tag::all();

		//ambiil data article berdasarkan id
		$Article=Article::find($id);

		return view('article.edit',compact('Category_article','Article','parent_menu','act_menu','Tag'));

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
	        'title_article'		=> 'required', 
	        'teaser'			=> 'required',   
	        'content_article'	=> 'required',
	        'category_id'		=> 'required',
	        'status'			=> 'required',               
	    );

	    $validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()){
			
			$id 	= Request::input('id');
			// get the error messages from the validator
        	$messages = $validator->messages();
			return Redirect::to('article/edit/'.$id)->withInput()->with('error', $messages);

    	}else{

    		$id = Request::input('id');
			$title_article = Request::input('title_article');
			$teaser = Request::input('teaser');
			$content_article = Request::input('content_article');
			$category_id = Request::input('category_id');
			$status = Request::input('status');
			$user_data = Session::get('user_data');
			$date_schedule = Request::input('date_schedule');


			$status_schedule = (Request::input('status_schedule')=="") ? $status : Request::input('status_schedule');
			
			$tag = Request::input('tag');
			if($tag!=""){
				$tagfinal ="";
				foreach ($tag as $key => $row) {
					$tagfinal.= $row.'|';

					//cek row
					$cekdata = Tag::where('name_tag','=',$row)->count();

					//insert row
					if($cekdata==0){
						$Tagpost = new Tag;
						$Tagpost->name_tag 			= $row;
						$Tagpost->id_user 			= $user_data[0]['id'];
						$Tagpost->id_microsite 		= Session::get('id_microsite');
						$Tagpost->save();
					}

				}

				$tagfinal = rtrim ($tagfinal, '|');
			}else{
				$tagfinal ="";
			}

			$newPost = Article::find($id);
			$newPost->title 			= $title_article;
			$newPost->id_category 		= $category_id;
			$newPost->content 			= $content_article;
			$newPost->teaser 			= $teaser;
			$newPost->status 			= $status_schedule;
			$newPost->tag 				= $tagfinal;
			$newPost->date_schedule 	= $date_schedule;
			$newPost->id_microsite 		= Session::get('id_microsite');
			$newPost->id_user 			= $user_data[0]['id'];

			//buat catch image
			$img=get_image_attached($content_article);
			if($img)
			{
				$image=$img[0];
				$newPost->origin_img=$image;
				if (strpos($image,'http') !== false) 
				{
					$newPost->prev_img=$image;
					$newPost->thumb_img=$image;
					$newPost->icon_img=$image;
				}
				else
				{
					$replace_image = str_replace("uploads/image/origin/", "", $image);
					$newPost->prev_img="uploads/image/preview/".$replace_image;
					$newPost->thumb_img="uploads/image/thumb/".$replace_image;
					$newPost->icon_img="uploads/image/icon/".$replace_image;
				}
			}

			$newPost->save();
			if(!$newPost){
				return Redirect::to('article/edit/'.$id)->withInput()->with('error', "Terjadi Kesalahan");
			}else{
				
				//return id
				if($id){
					//generate json use lib generator
					$article_read = new lib_generator;
					$article_read->article_read($id);
				}

				//direct
				return Redirect::to('article')->withInput()->with('success', "Data Berhasil disimpan");
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

			$post = Article::find($id);
			$post->delete();

			if(!$post){
	    		App::abort(500, 'Error');
			}else{
				echo "OK";
			}
    	}

	}

}
