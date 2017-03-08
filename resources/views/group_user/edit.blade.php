@extends('app')
@section('content')

<?php 
    if(!isset($hak_akses))
    {
        $hak_akses=array();
    }
?>
<div class="container">
    <ol class="breadcrumb">
      <li><a href="<?php url(); ?>/home">Home</a></li>
      <li><a href="<?php url(); ?>/group_user">Group User</a></li>
      <li class="active">Edit Group User</li>
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
            <form action="{{ url() }}/group_user/update" id="form" role="form" method="post">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Nama Grup
                            <span class="symbol required"></span>
                        </label>
                        <div class="controls">
                            <input type="hidden" name="id_group" class="input-xlarge" placeholder="" value="{{$Group_user->id}}" />
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <input type="text" name="nm_group" class="form-control" placeholder="" value="{{$Group_user->nama_group}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Akses Microsite
                        <span class="symbol required"></span>
                        </label>
                        <div class="controls">
                            
                            <?php
                                 $searchmicro = array();
                                 foreach ($web_id as $row){
                                    array_push($searchmicro, $row->id_microsite);
                                 }

                            ?>

                            <select id='web_id' style="width:100%" name="web_id[]"  multiple="multiple">
                                <?php
                                    foreach ($Microsite as $row):  
                                        $key = array_search($row->id, $searchmicro); 
                                        if($key!== false){
                                            $selectedx = 'selected';  
                                        }else{
                                            $selectedx = '';  
                                        }
                                ?>  
                                        <option value="{{ $row->id }}" <?php echo $selectedx; ?> >{{ $row->website_name }}</option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                           
                        </div>
                    </div>
                </div>
                </div>
                <br>

                <div class="control-group">
                    <div class="table-overflow">
                        <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th colspan="2">Menu</th>
                                <th width="120"><input type="checkbox"  name="chek_all" id="chek_all"> Pilih Semua </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="3"><strong>Pengaturan</strong></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Profile</td>
                                <td><input type="checkbox" class="chek_menu" value="profile_setting"  <?php if(array_search('profile_setting',$hak_akses) !==FALSE) echo 'checked="checked"' ?>name="chek_menu[]"></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Cover Headline</td>
                                <td><input type="checkbox" class="chek_menu" value="frontpage_setting"  <?php if(array_search('frontpage_setting',$hak_akses) !==FALSE) echo 'checked="checked"' ?>name="chek_menu[]"></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Editor Choice</td>
                                <td><input type="checkbox" class="chek_menu" value="article_editor"  <?php if(array_search('article_editor',$hak_akses) !==FALSE) echo 'checked="checked"' ?>name="chek_menu[]"></td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Posting</strong></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Kategori</td>
                                <td><input type="checkbox" class="chek_menu" value="category_article"  <?php if(array_search('category_article',$hak_akses) !==FALSE) echo 'checked="checked"' ?>name="chek_menu[]"></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Artikel</td>
                                <td><input type="checkbox" class="chek_menu" value="article"  <?php if(array_search('article',$hak_akses) !==FALSE) echo 'checked="checked"' ?>name="chek_menu[]"></td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Gallery</strong></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Image</td>
                                <td><input type="checkbox" class="chek_menu" value="image_gallery"  <?php if(array_search('image_gallery',$hak_akses) !==FALSE) echo 'checked="checked"' ?>name="chek_menu[]"></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Video</td>
                                <td><input type="checkbox" class="chek_menu" value="video_gallery"  <?php if(array_search('video_gallery',$hak_akses) !==FALSE) echo 'checked="checked"' ?>name="chek_menu[]"></td>
                            </tr>
                            
                            <tr>
                                <td colspan="3"><strong>Manajemen User</strong></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Grup User</td>
                                <td><input type="checkbox" class="chek_menu" value="group_user" name="chek_menu[]" <?php if(array_search('group_user',$hak_akses) !==FALSE) echo 'checked="checked"' ?> ></td>
                            </tr>
                            <tr>
                                <td width="10"></td>
                                <td>Data user</td>
                                <td><input type="checkbox" class="chek_menu" value="user" name="chek_menu[]" <?php if(array_search('user',$hak_akses) !==FALSE) echo 'checked="checked"' ?> ></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Manajemen Image</strong></td>
                                <td><input type="checkbox" class="chek_menu" value="manajemen_image" name="chek_menu[]" <?php if(array_search('manajemen_image',$hak_akses) !==FALSE) echo 'checked="checked"' ?>></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>  
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


<!-- js and css -->
<script src="{{ asset('/js/select2.min.js')}}"></script>
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/js/group_user_form.js')}}"></script>

<link href="{{ asset('/css/select2.css') }}" rel="stylesheet">


@endsection