@extends(backend_theme('master'))
<?php 
    title_head('Restore Database');

    File::isDirectory(cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'])) or File::makeDirectory(cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST']), 0777, true, true);

	function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

    function GetDirectorySize($path){
        $bytestotal = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                $bytestotal += $object->getSize();
            }
        }
        return $bytestotal;
    }

    $detail = Request::get('detail');

    if( $detail ){

        $detail = Crypt::decrypt($detail);


        $path = cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'].'/'.$detail.'/');

        if( file_exists($path) ){
            $files = scandir($path);
        }
        
    }

 ?>
@section('content')

<style>
  .img_over_1{
    margin: -1px -1px 0 -1px;
    height: 180px;
    overflow: hidden;
    position: relative;
}
.img_over_1 img{
    position: absolute;
    top:50%;
    left: 50%;
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    -o-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);;
}
.profile_details .profile_view{
    padding:0;
    width: 100%;
}
.page-title .title_right .pull-right, .list_status .post-status{
  margin: 0;
}
.list_status .post-status:not(.active){
    background-color: buttonface;
    color: black;
    font-weight: normal;
}
.page-title .title_right, .page-title .title_left{
  width: auto;
}
.notify-plugin{
  padding: 10px;
  border-left: 5px solid;
  background: #fff8e5;
  margin-bottom: 10px;
}
.tr_notify td{
  border-top: none !important;
  padding: 0;
}
td form{
    display: inline-block;
    float: left;
    margin: 0 5px;
}
.form-group.input-file{
    display: inline-block;
}
</style>


<div class="row">

<div class="col-md-12">


    @if( isset($files) && isset($path) )
    <div style="max-width: 1000px;margin: 0 auto;display: block;">
    <a href="{!!route('admin.page','restore-database')!!}" class="vn4-btn vn4-btn-blue" style="margin-bottom: 5px;">Back</a>
    <div class="x_panel" >
      <div class="x_title">
        <h2>@__('List Backup Table')</h2>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php 
                $totalRow = 0;
                $totalSize = 0;
            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>Table</th>
                        <th>Row</th>
                        <th>Size</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($files as $file)
                    @if( $file !== '.' && $file !== '..' )

                    @if( substr($file, -5) === '.json' )
                        <?php 
                            $row = count(json_decode(file_get_contents($path.$file),true));   
                            $file_size = filesize($path.$file);

                            $totalRow += $row;  
                            $totalSize += $file_size;              
                         ?>
                    <tr>
                        <td>{!!substr($file, 0, -5)!!}</td>
                        <td>{!!$row!!}</td>
                        <td>{!!formatSizeUnits($file_size)!!}</td>
                    </tr>
                    @else
                    <tr>
                        <td>{!!$file!!}</td>
                        <td></td>
                        <td>{!!formatSizeUnits(filesize($path.$file))!!}</td>
                    </tr>
                    @endif

                    @endif
                    @endforeach
                    <tr>
                        <td>@__('Total')</td>
                        <td>{!!number_format($totalRow)!!}</td>
                        <td>{!!formatSizeUnits($totalSize)!!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    @else
    <div class="x_panel">
        <div class="x_title">
            <h2>@__('List Backup DB')</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

              <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>
              <table class="table ">
                <thead>
                  <tr>
                        <th class="col-xs-3">@__('Name')</th>
                        <th >@__('Size')</th>
                        <th >@__('Created at')</th>
                        <th >@__('Action')</th>
                    </tr>
                </thead>
                <tbody>
                	<?php 

            			$path = cms_path('storage','cms/database/'.$_SERVER['HTTP_HOST'].'/');

            			$files = scandir($path);
                        $dk = true;
            			foreach ($files as $v) {

            				if( $v !== '.' && $v !== '..' && is_dir($path.$v) ){
                                $dk = false;
            					$date = date ("F d Y H:i:s.",filemtime($path.$v));
            					?>
                				<tr>
                					<td><p>{!!$v!!}</p></td>
                					<td><p>{!!formatSizeUnits(GetDirectorySize($path.$v))!!}</p></td>
                					<td><p>{!!date ("l, M, d-Y, h:i:s A",filemtime($path.$v))!!}</p></td>
                					<td>
                                        <a href="?detail={{ \Illuminate\Support\Facades\Crypt::encrypt($v) }}">
                                            <div class="vn4-btn vn4-btn-img" style="">
                                            <i class="fa fa-eye" aria-hidden="true" style=""></i>  @__('Detail')
                                            </div>
                                        </a>

                                        <form action="{!!route('admin.page',['page'=>'restore-database','download'=>\Illuminate\Support\Facades\Crypt::encrypt($v)])!!}" method="POST">
                                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                            <button type="submit" class="vn4-btn vn4-btn-img download-database" style="color: #23527c;">
                                                <i class="fa fa-download" aria-hidden="true" style="color: #23527c;"></i>  @__('Download')
                                            </button>
                                        </form>
            						    

                                        <a href="#" class="vn4-btn vn4-btn-img vn4-btn-red delete-database" data-delete="{{ \Illuminate\Support\Facades\Crypt::encrypt($v) }}">
            						      <i class="fa fa-trash-o" aria-hidden="true"></i>  @__('Delete')	
                                        </a>

            						    <a href="#" class="vn4-btn vn4-btn-img restore-link" data-restore="{{ \Illuminate\Support\Facades\Crypt::encrypt($v) }}" style="color: green;">
            						    <i class="fa fa-upload" aria-hidden="true" style="color: green;"></i>  @__('Restore')	
            						    </a>

                					</td>
                				</tr>
            					<?php
            				}
            			}

                        if( $dk ){
                            echo '<tr class="odd"><td valign="top" colspan="1000" class="dataTables_empty"><h4 style="font-size:18px;"><img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="'.asset('admin/images/data-not-found.png').'"><strong>'.__('Nothing To Display.').' <br> <span style="color:#ababab;font-size: 16px;">Seems like no backup have been created yet.</span></strong></h4></td></tr>';
                        }
            		?>
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
</div>

@stop

@section('js')
<script type="text/javascript">
    $(window).load(function(){
        $('textarea[name=upload_database]').change(function(){
            if( $(this).val() != '""' ){
                vn4_ajax({
                    data:{
                        upload: $(this).val(),
                    },
                    show_loading:true,
                    callback:function(result){

                        if( data.message ){
                            show_message(data.message);
                        }
                        
                       if( result.success ){
                        window.location.reload();
                       }
                    }
                });
            }
        });
        $(document).on('click','.delete-database',function(){
            event.stopPropagation();
            event.preventDefault();

            var r = confirm("Are You Sure!");

            if (r == true) {
                show_loading();
                $.ajax({

                    type:'POST',
                    dataType:'Json',
                    data:{
                        _token:"{!!csrf_token()!!}",
                        delete: $(this).data('delete')
                    },
                    success:function(data){

                        if( data.message ){
                            show_message(data.message);
                        }

                        if( data.success ){
                            window.location.reload();
                        }

                        hide_loading();
                    }

                });
            }

        });
    	$(document).on('click','.restore-link',function(){
            var r = confirm("Are You Sure!");
            if (r == true) {
              show_loading();
                $.ajax({

                    type:'POST',
                    dataType:'Json',
                    data:{
                        _token:"{!!csrf_token()!!}",
                        restore: $(this).data('restore')
                    },
                    success:function(data){

                        if( data.message ){
                            show_message(data.message);
                        }

                        if( data.success ){
                            window.location.reload();
                        }

                        hide_loading();
                    }

                });
            }

    		
    	});
    });
</script>
@stop