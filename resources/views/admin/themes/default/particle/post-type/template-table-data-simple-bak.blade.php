@extends(backend_theme('master'))
@section('content')

  <?php
    
    use_module('post');
    
    $admin_object = get_admin_object();

    $title = $r->get('title', $admin_object[$type]['title']);
    

    if( $post_related = $r->get('post_related') ){

      $post = get_post($post_related['type'],$post_related['id']);

      $field = $admin_object[ $post_related['type'] ] ['fields'][$post_related['key']];

      $posts = $post->related( $field['object'], $field['field'],['paginate'=>'page','count'=>10] );

    }else{

      $posts = Vn4Model::table($admin_object[$type]['table']);

      $where = $r->get('where');

      if( $where ){
        foreach ($where as $dk) {
          $posts = $posts->where($dk[0],$dk[1],$dk[2]);
        }
      }

      $posts = $posts->paginate(10);

    }
    
  ?>
  <style type="text/css">
    html, body{
      padding-bottom: 10px !important;
    }
    .container.body .right_col{
      padding: 0;
    }
    .message-warper{
      display: none;
    }
  </style>
  <div>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Title</th>
        </tr>
      </thead>
      <tbody>

        @forelse($posts as $p)
        <tr>
          <th scope="row">{!!$p->id!!}</th>
          <td><a target="_blank" data-popup="1" href="#" data-title="Editing: {{$p->title}}" data-winparent="1" data-iframe="{!!route('admin.create_data',['type'=>$type,'post'=>$p->id,'action_post'=>'edit'])!!}">{!!$p->title!!}</a></td>
        </tr>
        @empty
        <tr class="odd">
          <td valign="top" colspan="1000" class="dataTables_empty">
            <h4 style="font-size:18px;"><img style="box-shadow: none;width: 200px;max-width: 200px;height: auto;max-height: 200px;display: block;margin: 0 auto;" src="{!!asset('admin/images/data-not-found.png')!!}"><strong>@__('Nothing To Display.')<br> <span style="color:#ababab;font-size: 16px;">Seems like no {!!$title!!} have been created yet.</span></strong></h4>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    </div>

    {!!vn4_view(backend_theme('particle.post-type.paginate-simple'),['list_data'=>$posts])!!}
  </div>

@stop


