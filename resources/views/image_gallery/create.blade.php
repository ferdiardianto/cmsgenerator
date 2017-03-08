@extends('app')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li><a href="<?php url(); ?>/home">Home</a></li>
      <li><a href="<?php url(); ?>/image_gallery">Image</a></li>
      <li class="active">Buat/Edit Image</li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-body">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">
                        ×
                    </button>
                    <i class="fa fa-check-circle"></i>
                    {{ Session::get('success') }}
                </div>
                @endif


                @if(Session::has('error'))
                <div class="alert alert-danger">
                    <button class="close" data-dismiss="alert">
                        ×
                    </button>
                    <i class="fa fa-times-circle"></i>
                    {{ Session::get('error') }}
                </div>
                @endif     
            <form action="<?php if(isset($post_url)) echo $post_url; ?>" id="form" role="form" method="post">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <input type="hidden"  class="form-control" id="id" name="id" value="<?php echo (isset($Img_gallery_album->id)) ? $Img_gallery_album->id : ''; ?>">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label">
                                Nama Album <span class="symbol required"></span>
                            </label>
                            <input type="text"  class="form-control" id="album_name" name="album_name" value="<?php echo (isset($Img_gallery_album->album_name)) ? $Img_gallery_album->album_name : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                Deskripsi Album <span class="symbol required"></span>
                            </label>
                            <input type="text"  class="form-control" id="description" name="description" value="<?php echo (isset($Img_gallery_album->description)) ? $Img_gallery_album->description : ''; ?>">
                        </div>
                    </div>
                </div>
                <?php if($show_list===TRUE):?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="page-header" style="margin-top:5px;">
                                <button id="_image_gallery" type="button" class="btn btn-success pull-right btn-sm"><i class="fa fa-plus"></i> Tambahkan image</button>
                                <i class="clearfix"></a>
                            </div>
                            <div class="row" id="_list_img">
                            <?php if(isset($list_image) && $list_image):?>
                                <?php foreach($list_image as $row):?>
                                    <div style="overflow:hidden" class="col-md-3" id="_item_img_<?php echo $row['id_image']?>">
                                        <div class="thumbnail">
                                            <img alt="" src="<?php echo url().'/'.$row['img_preview']?>">
                                            <div class="caption">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <button onclick="remove_img('<?php echo $row['id_image']?>')" type="button" class="btn btn-danger  btn-xs">Hapus</button>
                                                    <input type="hidden" name="img_id[]" value="<?php echo $row['id_image']?>" class="class-img-id">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php else:?>
                                <div id="_no_img" class="col-md-12 text-center"><h4>Tidak ada Image yang ditambahkan...</h4></div>
                            <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-block" type="submit">
                            Submit <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>

                
            </form>
        </div>
    </div>
    
</div>

<div id="gallery-modal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog big">
        <div class="modal-content">
        <div class="modal-body" style="padding-bottom:0px;">
          <iframe   frameborder="0"  height="470" width="100%" src="<?php echo url(); ?>/image_manager"></iframe>
        </div>
        <div class="modal-footer" style="margin-top:0px;">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<!-- js and css -->
<script src="{{ asset('/js/jquery.pnotify.min.js')}}"></script>
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/js/image_gallery_form.js')}}"></script>

<link rel="stylesheet" href="{{ asset('/css/jquery.pnotify.default.css')}}">
@endsection