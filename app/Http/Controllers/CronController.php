<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Article;
use App\Tag;

use App;


use lib_generator;


class CronController extends Controller {

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$stat_img = "http://www.admin-cms.ketemuberita.com/";
		$domain   = "http://www.ketemuberita.com/";

		$this->stat_img = $stat_img;
		$this->domain 	= $domain;
	}
	
	public function schedule(){

		$article_schedule = Article::where('status', '=', 2)
					->where('date_schedule', '<=', date("Y-m-d H:i"))
					->get();

		//foreach and update data and create
		foreach ($article_schedule as $key => $row) {
			
			//update data
			$newPost = Article::find($row->id);
			$newPost->created_at 		= $row->date_schedule;
			$newPost->status 			= 1;
			$newPost->save();

			if($newPost){
				$article_read = new lib_generator;
				$article_read->article_read($row->id);

				echo "Generated";
			}

			
		}

		
	}

	//tambahin paramerter id microsite
	public function tagging($id_microsite){
		
		$tagging = Tag::where('id_microsite','=',$id_microsite)
					->get();


		$tag_gen = new lib_generator;
		$tag_gen->tag_all($id_microsite);
			
		foreach ($tagging as $key => $row) {
			#artikel by tagging
			$tag_gen->tag_article($id_microsite,$row->name_tag);
		}
		
		

	}

	public function sitemap($id_microsite){
		// create new sitemap object
    	$sitemap = App::make("sitemap");


    	$list = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
		            //->take(500)
					->orderBy('created_at', 'desc')
					->get();


		foreach ($list as $key => $row) {
				
			// add item with images
        	$images = [
                    ['url' => $this->stat_img.$row->prev_img, 'title' => $row->title],
            	];

            $pecahdate = explode("-",explodedate($row->created_at));

            $url    = geturl($this->domain,$pecahdate[0],$pecahdate[1],$pecahdate[2],$row->id,$row->title);

            // add items to the sitemap (url, date, priority, freq, images)
	   		$sitemap->add($url,date('c',time()), '0.7', 'daily',$images);
		}

	    // generate your sitemap (format, filename)
	    $sitemap->store('xml', 'json/'.$id_microsite.'/sitemap/sitemap');
	    // this will generate file mysitemap.xml to your public folder
    
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
