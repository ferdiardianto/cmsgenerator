<?php namespace App\Http\Controllers;

//load model
use App\Article_editor;
use App\Article;

use Request;
use Input;

//load auth
use Auth;

//load session
use Session;

//load redirect
use Illuminate\Support\Facades\Redirect;

use lib_generator;

//load datatables
use Datatables;

class Article_editorController extends Controller {

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
		$act_menu='article_editor';

	 	$list_editorchoice=Article_editor::join('articles', 'article_editors.id_article', '=', 'articles.id')
	            ->select('article_editors.id', 'article_editors.id_article', 'articles.title', 'articles.thumb_img', 'articles.prev_img')
	            ->where('article_editors.id_microsite', '=', $id_microsite)
	            ->get();

		return view('article_editor.index',compact('parent_menu','act_menu','list_editorchoice'));
		
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
			$delete = Article_editor::where('id_microsite','=',$id_microsite)->delete();
				
			foreach($id as $row)
			{
				//insert ke database
				$newPost = new Article_editor;
				$newPost->id_article 		= $row;
				$newPost->id_microsite 		= $id_microsite;
				$newPost->id_user 			= $user_data[0]['id'];
				$newPost->save();
			}

			//generator buat editor choice
			//
			$ec = new lib_generator;
			$ec->ec();


			return Redirect::to('article_editor')->withInput()->with('success', 'Editor choice Tersimpan');


		}else{
	    	return Redirect::to('article_editor')->withInput()->with('error', 'Editor choice tidak boleh kosong.');
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
