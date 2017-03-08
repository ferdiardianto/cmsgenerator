<?php namespace App\libraries {
	
	//load session
	use Session;

	use DB;

	//load model
	use App\video_gallery;
	use App\Img_gallery_album;
	use App\Img_gallery_list;
	use App\Category_article;
	use App\Article;
	use App\Manajemen_image;
	use App\Microsite;
	use App\Article_headline;
	use App\Cover_headline;
	use App\Tag;
	use App\Article_editor;


    class lib_generator  {

 		/* S: buat WP */
 		public function wp(){
        	$id_microsite = Session::get('id_microsite');
        	//$namadomain = url().'/';
		
 			#Headline
			$data=array();
			$headline=Article_headline::join('articles', 'article_headlines.id_article', '=', 'articles.id')
		            ->select('article_headlines.id_article', 'articles.id_category', 'articles.title', 'articles.teaser', 'articles.prev_img', 'articles.thumb_img', 'articles.icon_img', 'articles.created_at', 'articles.updated_at')
		            ->where('article_headlines.id_microsite', '=', $id_microsite)
		            ->get();

			foreach($headline as $index=>$row)
			{
				$category_id=$row['id_category'];
				$category = Category_article::where('id','=',$category_id)->first();

				$data['headline'][$index]=$row;
				$data['headline'][$index]['category']=$category;
				$data['headline'][$index]['prev_img']=$row['prev_img'];
				$data['headline'][$index]['thumb_img']=$row['thumb_img'];
				$data['headline'][$index]['icon_img']=$row['icon_img'];
				unset($data['headline'][$index]['id_category']);	
			}

			
			#cover
			$cover = Cover_headline::where('id_microsite','=',$id_microsite)->first();		
			$data['cover']=$cover;
			if($cover)
			{
				$data['cover']['image']=$cover['image'];
			}
			
			#latest artikel
			$latest_article = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->orderBy('created_at', 'desc')
		            ->take(9)
					->get();

			foreach($latest_article as $index=>$row)
			{
				$category = Category_article::where('id','=',$row['id_category'])->first();

				$data['latest'][$index]=array(
					'id'=>$row['id'],
					'title'=>$row['title'],
					'created_at'=>$row['created_at'],
					'updated_at'=>$row['updated_at'],
					'category'=>$category,
					'teaser'=>$row['teaser'],
					'prev_img'=>(!empty($row['prev_img'])?$row['prev_img']:''),
					'thumb_img'=>(!empty($row['thumb_img'])?$row['thumb_img']:''),
					'icon_img'=>(!empty($row['icon_img'])?$row['icon_img']:'')
				);
			}

			#kategori
			$data['category']=array();
			$list_category = Category_article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->get();

			foreach($list_category as $index=>$row)
			{
				$data['category'][$index]=$row;
				$latest = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->where('id_category', '=', $row['id'])
					->orderBy('created_at', 'desc')
		            ->take(5)
					->get();

				$dataarray=[];
				foreach($latest as $idx=>$q)
				{
					$dataarray[$idx]=array(
						'id'=>$q['id'],
						'title'=>$q['title'],
						'created_at'=>$q['created_at'],
						'updated_at'=>$q['updated_at'],
						'teaser'=>$q['teaser'],
						'prev_img'=>(!empty($q['prev_img'])?$q['prev_img']:''),
						'thumb_img'=>(!empty($q['thumb_img'])?$q['thumb_img']:''),
						'icon_img'=>(!empty($q['icon_img'])?$q['icon_img']:'')
					);
				}
				$data['category'][$index]['latest']=$dataarray;
				
			}
			
			#album
			$list_album = Img_gallery_album::where('id_microsite','=',$id_microsite)
							->orderBy('created_at', 'desc')
							->take(15)
							->offset(0)
							->get();
			foreach($list_album as $index=>$row)
			{
				$data['image_gallery'][$index]=$row;
				$list=Img_gallery_list::join('manajemen_images', 'img_gallery_lists.id_image', '=', 'manajemen_images.id')
		            ->select('img_gallery_lists.id', 'img_gallery_lists.created_at','img_gallery_lists.updated_at', 'manajemen_images.caption', 'manajemen_images.author', 'manajemen_images.img_origin', 'manajemen_images.img_preview', 'manajemen_images.img_thumb', 'manajemen_images.img_icon')
		            ->where('manajemen_images.id_microsite', '=', $id_microsite)
		            ->where('img_gallery_lists.id_album', '=', $row['id'])
					->take(3)
		            ->get();
		    	
		    	$dataarray=[];
				foreach($list as $idx=>$q)
				{
					$dataarray[$idx]=array(
							'id'=>$q['id'],
							'caption'=>$q['caption'],
							'created_at'=>$q['created_at'],
							'updated_at'=>$q['updated_at'],
							'author'=>$q['author'],
							'origin_img'=>(!empty($q['img_origin'])?$q['img_origin']:''),
							'prev_img'=>(!empty($q['img_preview'])?$q['img_preview']:''),
							'thumb_img'=>(!empty($q['img_thumb'])?$q['img_thumb']:''),
							'icon_img'=>(!empty($q['img_icon'])?$q['img_icon']:'')
						);	
				}
				$data['image_gallery'][$index]['list']=$dataarray;
			}


			
			$data_video = video_gallery::where('id_microsite','=',$id_microsite)
							->orderBy('created_at', 'desc')
							->take(5)
							->offset(0)
							->get();
			$data['video_gallery']=$data_video;
			
			$this->create_file(json_encode($data),'wp.json',$id_microsite.'/');
			return $this->return_file;

 		}
 		/* E: buat WP */





 		/* S: buat video */
        public function video_detail($video_id=""){
        	//microsite
        	$microsite = Session::get('id_microsite');
        
			$data = video_gallery::where('id','=',$video_id)->get();
			$this->create_file(json_encode($data),'video_'.$video_id.'.json',$microsite.'/');
			
			$this->video_list_gallery();

			$this->wp();
			
			return $this->return_file;
		}

		public function video_list_gallery(){
			
			//jumlah record
			$id_microsite=Session::get('id_microsite');
			$count = video_gallery::where('id_microsite','=',$id_microsite)->count();

			#jumlah page
			$total_page=ceil($count/5);
			$total_page=($total_page>=10)?10:$total_page;	
			
			for ($i = 0; $i < $total_page; $i++) 
			{
				$offset=((int)$i)*5;
				$data['total_page']=$total_page;
				$data['page']=$i +1;
				$list = video_gallery::where('id_microsite','=',$id_microsite)->take(5)->offset($offset)->get();
				$data['list']=$list;
				if($i==0)
				{
					$this->create_file(json_encode($data),'video_gallery.json',$id_microsite.'/');
				}
				else
				{
					$this->create_file(json_encode($data),'video_gallery_page_'.($i+1).'.json',$id_microsite.'/');
				}
				
			}

			$this->wp();
			return $this->return_file;
		}

		/* E: buat video */



		/* S: buat image */
		function list_album_image()
		{
			
			//jumlah record
			$id_microsite=Session::get('id_microsite');
			$count = Img_gallery_album::where('id_microsite','=',$id_microsite)->count();

			//jumlah page
			$total_page=ceil($count/10);
			for ($i = 0; $i < $total_page; $i++) 
			{
				$offset=((int)$i)*10;
				$data['total_page']=$total_page;
				$data['page']=$i +1;

				$list = Img_gallery_album::where('id_microsite','=',$id_microsite)->take(10)->offset($offset)->get();
				$data['list']=$list;
				if($i==0)
				{
					$this->create_file(json_encode($data),'album_gallery.json',$id_microsite.'/');
				}
				else
				{
					$this->create_file(json_encode($data),'album_gallery_page_'.($i+1).'.json',$id_microsite.'/');
				}
			}
			$this->wp();
			return $this->return_file;
		}
		
		function image_gallery($album_id="")
		{
			//$namadomain = url().'/';
			$id_microsite=Session::get('id_microsite');
			//jumlah record
			$count = Img_gallery_list::where('id_album','=',$album_id)->count();

			//jumlah page
			$total_page=ceil($count/15);
			
			//get atau first tinggal ganti aja nanti
			$album = Img_gallery_album::where('id','=',$album_id)->first();
			$data=$album;
			for ($i = 0; $i < $total_page; $i++) 
			{
				$offset=((int)$i)*15;
				$data['total_page']=$total_page;
				$data['page']=$i +1;

				//join ke image manager (ganti pake eloquent)
		        $list=Img_gallery_list::join('manajemen_images', 'img_gallery_lists.id_image', '=', 'manajemen_images.id')
		            ->select('img_gallery_lists.id', 'img_gallery_lists.id_image', 'img_gallery_lists.created_at','img_gallery_lists.updated_at', 'manajemen_images.caption', 'manajemen_images.author', 'manajemen_images.img_origin', 'manajemen_images.img_preview', 'manajemen_images.img_thumb', 'manajemen_images.img_icon')
		            ->offset($offset)
		            ->take(15)
		            ->where('manajemen_images.id_microsite', '=', $id_microsite)
		            ->get();

				//$data['list']=array();
		        $dataarray=[];

				foreach($list as $idx=>$q)
				{
					$dataarray[$idx]=array(
						'id'=>$q['id'],
						'id_image'=>$q['id_image'],
						'img_icon'=>(!empty($q['img_icon'])?$q['img_icon']:''),
						'img_thumb'=>(!empty($q['img_thumb'])?$q['img_thumb']:''),
						'img_preview'=>(!empty($q['img_preview'])?$q['img_preview']:''),
						'img_origin'=>(!empty($q['img_origin'])?$q['img_origin']:''),
						'caption'=>$q['caption'],
						'author'=>$q['author'],
						'created_at'=>$q['created_at'],
						'updated_at'=>$q['updated_at'],
					);
				}
				$data['list'] = $dataarray;
				if($i==0)
				{
					$this->create_file(json_encode($data),'album_'.$album_id.'.json',$id_microsite.'/');
				}
				else
				{
					$this->create_file(json_encode($data),'album_'.$album_id.'_page_'.($i+1).'.json',$id_microsite.'/');
				}
				
			}
			$this->list_album_image();

			$this->wp();
			
			return $this->return_file;
			
		}
		/* E: buat image */


	
		/* S: buat list category and latest */
		function list_category($category_id=FALSE)
		{
			//session id microsite
			$id_microsite = Session::get('id_microsite');

			//$namadomain = url().'/';

			$category = Category_article::where('id','=',$category_id)->first();
			
			$count = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->where('id_category', '=', $category_id)
					->count();

			#jumlah page
			$total_page=ceil($count/12);
			$total_page=($total_page>=10)?10:$total_page;		
			for ($i = 0; $i < $total_page; $i++) 
			{
				$data=array();
				if($category)
				{
					$data['category']=$category;
				}
				
				$offset=((int)$i)*12;
				$data['total_page']=$total_page;
				$data['page']=$i +1;
				$latest = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->where('id_category', '=', $category_id)
					->orderBy('created_at', 'desc')
					->offset($offset)
		            ->take(12)
					->get();

				foreach($latest as $index=>$row)
				{
					
					$data['latest'][$index]['id']=$row['id'];
					$data['latest'][$index]['title']=$row['title'];
					$data['latest'][$index]['teaser']=$row['teaser'];
					$data['latest'][$index]['origin_img']=(!empty($row['origin_img'])?$row['origin_img']:'');
					$data['latest'][$index]['prev_img']=(!empty($row['prev_img'])?$row['prev_img']:'');
					$data['latest'][$index]['thumb_img']=(!empty($row['thumb_img'])?$row['thumb_img']:'');
					$data['latest'][$index]['icon_img']=(!empty($row['icon_img'])?$row['icon_img']:'');
					$data['latest'][$index]['created_at']=$row['created_at'];
					$data['latest'][$index]['updated_at']=$row['updated_at'];
				}
				if($i==0)
				{
					$this->create_file(json_encode($data),'list_category_'.$category_id.'.json',$id_microsite.'/');
				}
				else
				{
					$this->create_file(json_encode($data),'list_category_'.$category_id.'_page_'.($i+1).'.json',$id_microsite.'/');
				}
			}
			$this->wp();
			return $this->return_file;


			
		}
		/* E:  buat list category and latest */


		/* S:  buat aarticle */
		function article_read($id=FALSE)
		{
			$id_microsite = Session::get('id_microsite');

			//$namadomain = url().'/';
		
			$data = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->where('id', '=', $id)
					->first();

			if($data)
			{
				$content=$data['content'];
				$category_id=$data['id_category'];
				$category = Category_article::where('id','=',$category_id)->first();
				$data['category']=$category;
				unset($data['id_category'],$data['id_microsite'],$data['id_user']);

				preg_match_all('/<img[^>]+>/i',$content, $images); 
				if(isset($images[0]) && $images[0])
				{
					$dataarray=[];
					foreach($images[0] as $index=>$img_tag)
					{
						preg_match_all('/data-id=(["\'])(.*?)\1/', $img_tag, $data_id);
						if($data_id[2])
						{

							$image = Manajemen_image::where('id','=',$data_id[2][0])->first();

							$dataarray[$index]=$image;
							
							$dataarray[$index]['origin_img']=$image['img_origin'];
							$dataarray[$index]['prev_img']=$image['img_preview'];
							$dataarray[$index]['thumb_img']=$image['img_thumb'];
							$dataarray[$index]['icon_img']=$image['img_icon'];
							
							$content = str_replace($img_tag, '<!--IMG-'.$data_id[2][0].'-->', $content);
						}
					}
					$data['images'] = $dataarray;

				}

				$data['content']=$content;
				$data['origin_img']=(!empty($data['origin_img'])?$data['origin_img']:'');
				$data['prev_img']=(!empty($data['prev_img'])?$data['prev_img']:'');
				$data['thumb_img']=(!empty($data['thumb_img'])?$data['thumb_img']:'');
				$data['icon_img']=(!empty($data['icon_img'])?$data['icon_img']:'');
				
				//$data['related']=array();
				$dataarray=[];
				
				$latest = Article::where('id_microsite','=',$id_microsite)
					->where('id', '<', $data['id'])
					->where('status', '=', 1)
					->where('id_category', '=', $category_id)
					->orderBy('created_at', 'desc')
					->offset(0)
		            ->take(5)
					->get();

				foreach($latest as $index=>$row)
				{
					$dataarray[$index]=array(
									'id'=>$row['id'],
									'id_category'=>$row['id_category'],
									'title'=>$row['title'],
									'teaser'=>$row['teaser'],
									'prev_img'=>(!empty($row['prev_img'])?$row['prev_img']:''),
									'thumb_img'=>(!empty($row['thumb_img'])?$row['thumb_img']:''),
									'icon_img'=>(!empty($row['icon_img'])?$row['icon_img']:''),
									'created_at'=>$row['created_at'],
									'updated_at'=>$row['updated_at'],
									);
				}
				$data['related'] = $dataarray;

				$data['tag']=$data['tag'];

				$pecahdate = explode("-",explodedate($data['created_at']));

				$this->create_file(json_encode($data),'article_'.$id.'.json',$id_microsite.'/'.$pecahdate[0].'/'.$pecahdate[1].'/'.$pecahdate[2].'/');
				

				$this->list_category($category_id);
				$this->indeks_article($id_microsite);
				
				return $this->return_file;
			}
		}

		/* E:  buat aarticle  */

		/* S:  buat profile  */
		function profile($id=FALSE)
		{
			$data = Microsite::where('id','=',$id)
					->first();

			$this->create_file(json_encode($data),'profile.json',$id.'/');

			$this->wp();

			return $this->return_file;
		}


		/* E:  buat profile  */


		/* S: buat tagging */
        public function tag_all($id_microsite){

			$data = Tag::orderBy(DB::raw('RAND()'))->take(10)->get();		

			$this->create_file(json_encode($data),'tag_all.json',$id_microsite.'/tag/');
			return $this->return_file;
		}

		/* S: buat aartikel tagging */
        public function tag_article($id_microsite,$tag){
			

        	//dibuat per paging
			$count = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->where('tag', 'LIKE', '%'.$tag.'%')
					->orderBy('created_at', 'desc')
					->count();

			#jumlah page
			$total_page=ceil($count/10);
			$total_page=($total_page>=10)?10:$total_page;	

			
			for ($i = 0; $i < $total_page; $i++) 
			{
				$offset=((int)$i)*10;
				$data['total_page']=$total_page;
				$data['page']=$i +1;

				$list = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->where('tag', 'LIKE', '%'.$tag.'%')
					->offset($offset)
		            ->take(10)
					->orderBy('created_at', 'desc')
					->get();

				$list_array=array();
				foreach($list as $idx=>$row)
				{
					$list_array[$idx]=$row;
					
				}

				$data['list']=$list_array;

				if($i==0)
				{
					$this->create_file(json_encode($data),'tag_'.$tag.'.json',$id_microsite.'/tag/');
				}
				else
				{
					$this->create_file(json_encode($data),'tag_'.$tag.'_'.($i+1).'.json',$id_microsite.'/tag/');
				}
			}

			return $this->return_file;
		}

		public function ec(){

			$id_microsite = Session::get('id_microsite');
        	//$namadomain = url().'/';
		
 			#Article_editor
			$data=array();
			$ec=Article_editor::join('articles', 'article_editors.id_article', '=', 'articles.id')
		            ->select('article_editors.id_article', 'articles.id_category', 'articles.title', 'articles.teaser', 'articles.prev_img', 'articles.thumb_img', 'articles.icon_img', 'articles.created_at','articles.updated_at')
		            ->where('article_editors.id_microsite', '=', $id_microsite)
		            ->get();

			foreach($ec as $index=>$row)
			{
				$category_id=$row['id_category'];
				$category = Category_article::where('id','=',$category_id)->first();

				$data['ec'][$index]=$row;
				$data['ec'][$index]['category']=$category;
				$data['ec'][$index]['prev_img']=$row['prev_img'];
				$data['ec'][$index]['thumb_img']=$row['thumb_img'];
				$data['ec'][$index]['icon_img']=$row['icon_img'];
				unset($data['ec'][$index]['id_category']);	
			}


			$this->create_file(json_encode($data),'ec.json',$id_microsite.'/');
			return $this->return_file;


		}



		/* S: buat aartikel latest indeks */
        public function indeks_article($id_microsite){
			
        	#latest artikel
			$count = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->orderBy('created_at', 'desc')
					->count();

			#jumlah page
			$total_page=ceil($count/10);
			$total_page=($total_page>=10)?10:$total_page;	

			
			for ($i = 0; $i < $total_page; $i++) 
			{
				$offset=((int)$i)*10;
				$data['total_page']=$total_page;
				$data['page']=$i +1;

				$list = Article::where('id_microsite','=',$id_microsite)
					->where('status', '=', 1)
					->offset($offset)
		            ->take(10)
					->orderBy('created_at', 'desc')
					->get();


				$list_array=array();
				foreach($list as $idx=>$row)
				{
					$list_array[$idx]=$row;
					
				}

				$data['latest']=$list_array;

				if($i==0)
				{
					$this->create_file(json_encode($data),'indeks_article.json',$id_microsite.'/');
				}
				else
				{
					$this->create_file(json_encode($data),'indeks_article_'.($i+1).'.json',$id_microsite.'/');
				}
			}

			return $this->return_file;
		}



		/* create file */
		private function create_file($json_data="",$file_name="",$folder=""){
			//create json file
			$directory = '../public/json/'.$folder;
			if (!is_dir($directory))
			{
				mkdir($directory,0777,TRUE);
			}
			
			$File = $directory.$file_name;
			$Handle = fopen($File, 'w');
			
			if(fwrite($Handle, $json_data))
			{
				$this->return_file['status']=1;
			}
			else
			{
				$this->return_file['status']=0;
			}

			fclose($Handle);
		}




    }
}
?>