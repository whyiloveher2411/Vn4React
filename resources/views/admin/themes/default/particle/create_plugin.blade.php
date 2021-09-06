@extends(backend_theme('master'))
@section('content')

<form method="POST">
   <br><br>
   <input type="hidden" name="_token" value="{!!csrf_token()!!}">
   <div class="form-group form-name">
      <label class="" for="name"> Name
      </label>
      <input name="name" required="" type="text" id="name" class="form-control">
   </div>
   <div class="form-group form-description">
      <label class="" for="description"> Description
      </label>
      <textarea class="form-control" name="description" rows="5" id="description"></textarea>
   </div>
   <div class="form-group form-author">
      <label class="" for="author"> Author
      </label>
      <input name="author" required="" type="text" id="author" class="form-control">
   </div>
   <div class="form-group form-author_url">
      <label class="" for="author_url"> Author Url
      </label>
      <input name="author_url" required="" type="text" id="author_url" class="form-control">
   </div>

   <div class="form-group form-screenshot">
     <label class="" for="author"> Image
     </label>
     {!!get_field('image',['key'=>'image','value'=>'','width'=>128,'height'=>128])!!}
   </div>

   <div class="form-group form-btn">
      <input type="submit" name="create_plugin_submit" value="Create Plugin" class="vn4-btn vn4-btn-blue">
   </div>
</form>

@stop