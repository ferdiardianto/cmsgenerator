<!-- datatables -->
<table class="table table-striped table-bordered" id="data-table">
	<thead>
		<tr>
			<th>#Id</th>
			<th>Tanggal</th>
			<th>Judul</th>
			<th>Teaser</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="6">Loading....</td>
		</tr>
	</tbody>
</table>

<!-- js -->
<script src="{{ asset('/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/js/datatables.bootstrap.js')}}"></script>
<script src="{{ asset('/js/jquery.pnotify.min.js')}}"></script>

<script>
$(document).ready(function(){

   $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: base_url+'/getBasicData',
         columns: [
            {data: 'id', name: 'id'},
            {data: 'created_at', name: 'created_at'},
            {data: 'title', name: 'title'},
            {data: 'teaser', name: 'teaser'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
           
    });

   
}); 


function select_article(id_article,title,thumb){
    var _exist=false;
    if(thumb =='')
    {
        msg_noty('<i class="clip-info"></i>  Maaf artikel ini tidak mempunyai gambar.. Tidak dapat dijadikan headline','error');
        return false;
    }
    
    $(".class-article-id").each(function() {
        if($(this).val()==id_article)
        {
            _exist=true;
            return false;
        }
    });
    if(_exist==true)
    {
        msg_noty('<i class="clip-info"></i>  Maaf artikel ini sudah dijadikan headline','error');
        return false;
    }
    var html='<div class="col-md-4"  style="overflow:hidden" id="_item_headline_'+id_article+'">'+
            '<div class="thumbnail">'+
            '<img src="'+thumb+'" alt="..." >'+
            '<div class="caption">'+
            '<div style="height:50px;overflow:hidden" class="text-center">'+
                '<h4>'+title+'</h4>'+
            '</div>'+
            '<br>'+
            '<div class="row">'+
            '   <div class="col-md-12 text-center">'+
            '       <button class="btn btn-danger  btn-sm" type="button" onclick="remove_headline(\''+id_article+'\')"><i class="fa fa-times fa fa-white"></i> Hapus</button>'+
            '   </div>'+
            '</div>'+
            '</div>'+
            '<input type="hidden" name="article_id[]" value="'+id_article+'" class="class-article-id">'+
            '</div>'+
            '</div>';
        $("#_list_headline").prepend(html);
        msg_noty('<i class="clip-checkmark-circle-2"></i> Headline berhasil ditambahkan..' ,'success');
        $("#_no_headline").remove();
    
    
    return false;
}

function msg_noty(text,type){
    var add_class="";
    if(type=='error'){
        add_class="alert-danger"
    }
    if(type=='success'){
        add_class="alert-success"
    }
    
    $.pnotify_remove_all();
    $.pnotify({
            title: false,
            text: text,
            closer: true,
            type: type,
            icon: false,
            hide: true,
            shadow: true,
            sticker:false,
            addclass: add_class,
            history: false,
        });
}

</script>
<link href="{{ asset('/css/jquery.pnotify.default.css') }}" rel="stylesheet">
<link href="{{ asset('/css/dataTables.bootstrap.css') }}" rel="stylesheet">