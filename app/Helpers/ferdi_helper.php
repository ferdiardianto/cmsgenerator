<?php
	function dateformatindo($vardate,$type='')
	{
        $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');   
        $bulan = array(1=>'Januari', 2=>'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        $dywk = date('w',strtotime($vardate));
        $dywk = $hari[$dywk];
        $dy = date('j',strtotime($vardate));
        $d = date('d',strtotime($vardate));
		$mth = date('n',strtotime($vardate));
		$m = date('M',strtotime($vardate));
		$y = date('y',strtotime($vardate));
        $mth = $bulan[$mth];
        $yr = date('Y',strtotime($vardate));
        $hr = date('H',strtotime($vardate));
        $mi = date('i',strtotime($vardate));
        
      	if ($type=='') {
			return $dywk.', '.$dy.' '.$mth.' '.$yr.'';
		} elseif ($type=='1') {
			return $dywk.', '.$dy.' '.$mth.' '.$yr.' | '.$hr.':'.$mi.' WIB';	
		}elseif($type=='2') {
			return $dy.' '.$mth.' '.$yr.'';
		}elseif($type=='3'){
			return $dywk.', '.$dy.' '.$mth.' '.$yr.' '.$hr.':'.$mi;
		}elseif($type=='4'){
			return $dywk.', '.$dy.' '.$mth.' '.$yr ;
		}elseif($type=='5'){
			return $dy.'/'.$m.'/'.$yr.' | '.$hr.':'.$mi.' WIB';
		}elseif($type=='d'){
			return $d;
		}elseif($type=='my'){
			return $m .' '.$y;
		}
    }

	function cleanteks($teks)
	{
        $find = array('|[_]{1,}|','|[ ]{1,}|','|[^0-9A-Za-z\-.]|','|[-]{2,}|','|[.]{2,}|'); 
		$replace = array('.','.','','.','.'); 
		$newname = strtolower(preg_replace($find,$replace,$teks));
		return $newname;
    }
	
	function get_image_attached($post)
	{
		preg_match_all('/data-ori=(["\'])(.*?)\1/', $post, $matches);
		$img = $matches[2];
		return $img;
		return false;
	}
	
	function get_image_src($post)
	{
		preg_match_all('/src=(["\'])(.*?)\1/', $post, $matches);
		$img = $matches[2];
		return $img;
		return false;
	}
	
	function explode_img($param="")
	{
		$image=array();
		if($param=="")
		{
			return '';
		}
		
		if (strpos($param,'http') !== false)
		{
			$image['img_headline']=$param;
			$image['img_preview']=$param;
			$image['img_thumb']=$param;
			$image['img_icon']=$param;
		}
		else
		{
			$img=explode('.',$param);
			
			$image['img_headline']=config_item('static_content'). $img[0].'_h.'.$img[1];
			$image['img_preview']=config_item('static_content').$img[0].'_p.'.$img[1];
			$image['img_thumb']=config_item('static_content').$img[0].'_t.'.$img[1];
			$image['img_icon']=config_item('static_content').$img[0].'_i.'.$img[1];
		}
		
		if($image)
		{
			return $image;
		}
		else
		{
			return '';
		}
	}
	
	function dateInd($tgl){
		$y=substr($tgl,0,4);
		$m=substr($tgl,5,2);
		$d=substr($tgl,-2);
		$tanggal=$d."/".$m."/".$y;
		return $tanggal;
	}
	
	function dateEng($tgl){
		$y=substr($tgl,-4);
		$m=substr($tgl,3,2);
		$d=substr($tgl,0,2);
		$tanggal=$y."-".$m."-".$d;
		return $tanggal;
	}

	function explodedate($datetime){
		$date_arr= explode(" ", $datetime);
		$date= $date_arr[0];
		return $date;
	}

	function geturl($domain,$tahun,$bulan,$tanggal,$id,$title){
		$url = $domain.'read/'.$tahun.'/'.$bulan.'/'.$tanggal.'/'.$id.'/'.cleanteks($title);
		return $url;
	}

?>