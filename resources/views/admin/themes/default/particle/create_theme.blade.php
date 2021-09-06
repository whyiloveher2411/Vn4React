@extends(backend_theme('master'))
@section('content')
 <form method="POST">
  <br><br>
  <input type="hidden" name="_token" value="{!!csrf_token()!!}">
  <div class="form-group form-name">
    <label class="" for="theme_name"> Name
    </label>
    <input name="theme_name" required="" type="text" id="theme_name" class="form-control">
  </div>

  <div class="form-group form-description">
    <label class="" for="description"> Description
    </label>
    <textarea class="form-control" name="description" rows="5" id="description"></textarea>
  </div>

  <div class="form-group form-author">
    <label class="" for="author"> Author
    </label>
    <input name="author" type="text" id="author" class="form-control">
  </div>

  


  <div class="form-group form-author_url">
    <label class="" for="author_url"> Author Url
    </label>
    <input name="author_url" type="text" id="author_url" class="form-control">
  </div>

   <div class="form-group form-tags">
    <label class="" for="tags"> Tags
    </label>

    <textarea class="form-control" name="tags" rows="5" id="tags"></textarea>
  </div>

  <div class="form-group form-screenshot">
    <label class="" for="author"> Screenshot
    </label>
    {!!get_field('image',['key'=>'screenshot','value'=>''])!!}
  </div>
  
  <div class="form-group form-btn">
    <input type="submit" name="create_theme_submit" value="Create Theme" class="vn4-btn vn4-btn-blue">
  </div>
</form>

@stop