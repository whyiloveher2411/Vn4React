@extends(backend_theme('master'))
@section('css')
	<style>
		.vn4-user-permission-warp{
			
		}
	</style>
@stop
@section('content')
<?php 
    title_head('User Role Group');
 ?>
<form class="form-horizontal form-label-left" method="POST">
  <input type="text" value="{!!csrf_token()!!}" hidden name="_token">
  
  <?php 

      $list_group = apply_filter('vn4_permission',[]);

      $list_permission_html =  '';

      echo '<div class="meta-box-user-permission"><ul class="col-left">';


      foreach ($list_group as $key => $group) {
        
        echo '<li ><a href="#">'.$group['title'].'</a><ul>';


        foreach ($group['group'] as $key_tab => $tab_top) {
          echo '<li class="nav-child"><a href="#">'.$tab_top['title'].'</a></li>';

          foreach ($tab_top['permission'] as $key => $permission) {

            $list_permission_html = $list_permission_html.'<p><label>'.$permission['title'].' <input type="checkbox" value="'.$key.'"></label> </p>';
            
          }

        }

        echo '</ul></li>';

      }

      echo '</ul>';

      echo '<div class="col-right">'.$list_permission_html.'</div>';

      echo '</div>';

   ?>
</form>
  
@stop

