<div class="x_panel x_panel_status" style="z-index: 999;">
  <div class="x_title">
    <h2>@__('Status')</h2>
    <ul class="nav navbar-right panel_toolbox">
      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
      <div style="display:table;width:100%">
        <button type="submit" tabindex="100" value="draft" class="vn4-btn pull-left change-status-post"> @__('Save Draft')</button>
        @if( $action_post === 'edit' && $hasPost )

          @if( $post->status == 'trash' )

            @if( check_permission($post_type.'_delete'))
            <button type="submit" style="margin-left:5px;" value="delete" data-url="{!!route('admin.show_data',['type'=>$post_type,'post'=>$post->id,'action_post'=>'delete','submit_action_post'=>'delete','getJsonData'=>true])!!}" class="vn4-btn vn4-btn-img pull-left vn4-btn-red delete-post">
              <i class="fa fa-times" aria-hidden="true"></i> @__('Delete')
            </button>
            @endif

          @else

            @if( check_permission($post_type.'_trash'))
            <button type="submit" style="margin-left:5px;" value="trash" class="vn4-btn vn4-btn-img pull-left vn4-btn-red change-status-post">
              <i class="fa fa-trash" aria-hidden="true"></i> @__('Move to Trash')
            </button>
            @endif

          @endif

        @endif
      </div>
     <div class="vn4-published-status">

        @if( !isset($status) || $status)
       <p><i class="fa fa-key" aria-hidden="true"></i>  @__('Status'): <strong class="text-publish-status" >  </strong> <a href="#" class="btn-open-select-status btn-open-toggle not-href vn4-blink" data-toggle=".select-status">@__('Edit')</a></p>
       <p class="select-status warpper-toggle">
        
          <select class="form-control publish-status vn4-wat vn4-h28 pull-left" name="status" id="select_status">
            @if( check_permission($post_type.'_publish') )
            <option @if( ($hasPost && $post->status === 'publish') || ( !$hasPost )  ) is-fisrt-chose="true" selected @endif value="publish">@__('Public')</option>@endif

            <option value="draft" @if( $hasPost && $post->status === 'draft'  ) is-fisrt-chose="true" selected @endif>@__('Draft')</option>
            <option value="pending" @if( $hasPost && $post->status === 'pending'  ) is-fisrt-chose="true" selected @endif>@__('Pending')</option>
            <option value="trash" style="color:red;" @if( $hasPost && $post->status === 'trash'  ) is-fisrt-chose="true" selected @endif>@__('Trash')</option>

          </select>
          <button type="button" class="vn4-btn-white btn-ok-publish btn-ok-publish-status pull-left" data-toggle=".btn-open-select-status" > @__('Ok') </button><a href="#" class="cancel-open-toggle not-href btn-cancel-publish btn-cancel-publish-status vn4-blink pull-left" data-toggle=".btn-open-select-status">@__('Cancel')</a>
          <span class="clearfix "></span>
       </p>
        @endif
      
      @if( !isset($visibility) || $visibility)
       <p>
          <i class="fa fa-eye" aria-hidden="true"></i> @__('Visibility'): <strong class="text-publish-password"></strong> <a href="#" class="btn-open-toggle btn-open-select-status-password not-href vn4-blink" data-toggle=".select-status-password">@__('Edit')</a>
       </p>
       <div class="select-status-password warpper-toggle">

           <label class="form-check-label">
              <input class="form-check-input" @if( !$hasPost || $post->visibility === 'publish' || trim($post->visibility) === '' ) is-fisrt-chose="true"  checked @endif  name="select-status-password" type="radio" value="publish">
               @__('Public Key')
            </label> <br>

            <label class="form-check-label">
              <input @if( $hasPost && $post->visibility === 'password'  ) is-fisrt-chose="true" checked @endif class="form-check-input" name="select-status-password" type="radio" value="password">
               @__('Password protected')
            </label> <br>
            
            <div class="form-group post-status-password-warrper">
              <label class="" for="publish-password"> @__('Password')
              </label>
              <input style="height:28px;" name="publish-password" value="@if( $hasPost ){!!$post->password!!}@endif" type="text" id="publish-password" class="form-control col-md-7 col-xs-12">
            </div>

            <label class="form-check-label">
              <input @if( $hasPost && $post->visibility === 'private'  ) is-fisrt-chose="true" checked @endif  class="form-check-input" name="select-status-password" type="radio" value="private">
              @__('Private')
            </label> <br>
          <button type="button" class="vn4-btn-white btn-ok-publish btn-ok-publish-password pull-left" data-toggle=".btn-open-select-status-password"> @__('Ok') </button><a href="#" class="cancel-open-toggle not-href btn-cancel-publish btn-cancel-publish-password vn4-blink pull-left" data-toggle=".btn-open-select-status-password">@__('Cancel')</a>
          <span class="clearfix "></span>
       </div>
       @endif


       @if( !isset($published_on) || $published_on)
       <p><i class="fa fa-calendar" aria-hidden="true"></i>  @__('Published on'):  <strong class="text-publish-date"></strong> <a href="#" class="btn-open-toggle btn-open-select-status-date not-href vn4-blink" data-toggle=".select-status-date">@__('Edit')</a>
       </p>
       <div class="select-status-date warpper-toggle">
          <input type="date" class="vn4-wat form-control" name="publish-date" @if( $hasPost && $post->post_date_gmt ) value="{!!date('Y-m-d', $post->post_date_gmt)!!}" data-view="{!!date('l, F d, Y - ', $post->post_date_gmt)!!}" @endif"> 
          <input  type="time" class="vn4-wat form-control"  name="publish-hour" @if( $hasPost && $post->post_date_gmt )value="{!!date('H:i', $post->post_date_gmt)!!}" @endif >
          <p>
            <button type="button" class="vn4-btn-white btn-ok-publish pull-left btn-ok-publish-date" data-toggle=".btn-open-select-status-date"  > @__('Ok') </button>
            <a href="#" class="cancel-open-toggle not-href btn-cancel-publish btn-cancel-publish-date vn4-blink pull-left" data-toggle=".btn-open-select-status-date">@__('Cancel')</a>
            <span class="clearfix "></span>
          </p>
       </div>
        @endif
        
     </div>
      
  </div>
  <div class="clearfix"></div>
  <div class="x_footer">
       @if( $action_post === 'edit' && $hasPost )

          <?php 
             if( $post->type ){



                $postNext = get_post($post->type,function($q) use ($post) {
                   return $q->orderBy(Vn4Model::$id,'desc')->where(Vn4Model::$id,'<',$post->id);
                });

                if( isset($postNext) ){
                  echo '<a class="vn4-btn" href="?post='.$postNext->id.'&action_post=edit">Previous Post</a>';
                }

                $postNext = get_post($post->type,function($q) use ($post) {
                   return $q->where(Vn4Model::$id,'>',$post->id);
                });

                if( isset($postNext) ){
                  echo '<a class="vn4-btn" href="?post='.$postNext->id.'&action_post=edit">Next Post</a>';
                }

            }
          ?>

          <button type="submit" class="vn4-btn vn4-btn-blue" data-message="The process is running, please wait a moment" style="float: right;" tabindex="99"  name="action" value="edit">@__('Update')</button>
       @endif

       @if( $action_post === false || !$hasPost || $action_post === 'copy' )


          @if( $action_post === 'copy' )
          <button type="submit" class="vn4-btn vn4-btn-blue" data-message="The process is running, please wait a moment" tabindex="99">@__('Copy') {!!$postTypeConfig['title']!!}</button>
          @else
          <button type="submit" class="vn4-btn vn4-btn-blue" data-message="The process is running, please wait a moment" tabindex="99">@__('Publish') {!!$postTypeConfig['title']!!}</button>
          @endif

       @endif
       <div class="clearfix"></div>
  </div>
</div>

<?php 
add_action('vn4_footer',function() use ($hasPost, $post ){
  ?>

<script>
  $(window).load(function() {

      $('#form_create').keypress(function(e) {
          event.stopPropagation();
          if (e.which == 13) {
              event.preventDefault();
              $(this).submit();
          }
      });

      $(document).on('click','.change-status-post',function(event) {
          $('#select_status').val($('#select_status option[value="'+$(this).val()+'"]').attr('value'));
      });

      $(document).on('click','.delete-post',function(event){

        event.stopPropagation();
        event.preventDefault();

        var result = confirm('Are you sure?');

        if( result ){


          var url = $(this).data('url');
          var form = $('<form action="' + url + '" method="post"><input type="hidden" name="_token" value="{!!csrf_token()!!}" /></form>');
          $(form).submit();
          $('body').append(form);
          form.submit();
        }

        return false;

      });
      
      $(document).on('click','.btn-ok-publish-status',function(event) {
          $(this).closest('.warpper-toggle').slideUp('fast');
          $($(this).attr('data-toggle')).css({
              display: 'inline'
          });
      });
      $('.text-publish-status').text($('#select_status option:selected').text());
      $(document).on('change','#select_status',function(event) {
          $('.text-publish-status').text($('#select_status option:selected').text());
      });


      $(document).on('click','.btn-cancel-publish-status',function(event) {
          $("#select_status").val($('#select_status option[is-fisrt-chose="true"]').val());
          $('.text-publish-status').text($('#select_status option[is-fisrt-chose="true"]').text());
      });

      $(document).on('click','.btn-ok-publish-status',function(event) {
          $(this).closest('.warpper-toggle').slideUp('fast');
          $($(this).attr('data-toggle')).css({
              display: 'inline'
          });
      });

      $(document).on('change','#select_status',function(event) {
          $('.text-publish-status').text($('#select_status option:selected').text());
      });


      if ($('input[name="select-status-password"]:checked').val() === 'password') {
          $('.post-status-password-warrper').css({
              display: 'block'
          });
      } else {
          $('.post-status-password-warrper').css({
              display: 'none'
          });
      }

      $(document).on('click','.btn-cancel-publish-password',function(event) {
          $('input[is-fisrt-chose="true"]').prop({
              'checked': true
          });
          $('.text-publish-password').text($('input[is-fisrt-chose="true"]').closest('label').text());

          if ($(this).val() === 'password') {
              $('.post-status-password-warrper').css({
                  display: 'block'
              });
          } else {
              $('.post-status-password-warrper').css({
                  display: 'none'
              });
          }
      });

      $(document).on('click','.btn-ok-publish-status',function(event) {
          $(this).closest('.warpper-toggle').slideUp('fast');
          $($(this).attr('data-toggle')).css({
              display: 'inline'
          });
      });

      $(document).on('click','.btn-ok-publish-password',function(event) {
          $(this).closest('.warpper-toggle').slideUp('fast');
          $($(this).attr('data-toggle')).css({
              display: 'inline'
          });
      });

      $('.text-publish-password').text($('input[is-fisrt-chose="true"]').closest('label').text());

      $(document).on('change','input[name="select-status-password"]',function(event) {
          $('.text-publish-password').text($(this).closest('label').text());

          if ($(this).val() === 'password') {
              $('.post-status-password-warrper').css({
                  display: 'block'
              });
          } else {
              $('.post-status-password-warrper').css({
                  display: 'none'
              });
          }
      });


      $(document).on('click','.btn-cancel-publish-date',function(event) {
          $('.text-publish-date').html('@__('immediately')');
          $('input[name="publish-date"]').val(null);
          $('input[name="publish-hour"]').val(null);
      });

      var $date = $('input[name="publish-date"]'),
          $hour = $('input[name="publish-hour"]');
      var date = $date.val(),
          hour = $hour.val();

      if (date && hour) {
          $('.text-publish-date').html($date.data('view') + ' ' + $hour.val());
      } else {
          @if($hasPost && $post->created_at)
          $('.text-publish-date').html('{!!date_format($post->created_at, 'l, F d, Y - H: i')!!}');
          @else
          $('.text-publish-date').html('@__('immediately')');
          @endif
      }

      $(document).on('click','.btn-ok-publish-date',function(event) {

          var $date = $('input[name="publish-date"]'),
              $hour = $('input[name="publish-hour"]');
          var date = $date.val(),
              hour = $hour.val();

          var date2 = new Date();
          var currentDate = date2.toISOString().slice(0, 10);
          var currentTime = date2.getHours() + ':' + date2.getMinutes();

          if (!date) {
              $date.val(currentDate);
          }

          if (!hour) {
              $hour.val(currentTime);
          }
          $('.text-publish-date').text($date.val() + ' ' + $hour.val());

          $(this).closest('.warpper-toggle').slideUp('fast');
          $($(this).attr('data-toggle')).css({
              display: 'inline'
          });

      });



      $('.layout_tab_content').each( function(index, el) {
        $($(el).val()).appendTo($(el).closest('.content-item'));
      });

      $(window).scroll(function(event) {


          let $warpper = $('.x_panel_status'), subtop = 0,
              top = $warpper[0].getBoundingClientRect().top + $warpper[0].offsetHeight - $('.x_panel_status .x_footer')[0].offsetHeight;


          if( $('body').hasClass('is-iframe') ){
            subtop = 44;
          }



          if (top < ( 44 - subtop ) ) {

              $('.x_panel_status .x_footer').css({
                  position: 'fixed',
                  'z-index': 999999999999,
                  top: 44 - subtop,
                  width: $warpper[0].offsetWidth 
              });
              $warpper.css({
                  'padding-bottom': $('.x_panel_status .x_footer')[0].offsetHeight
              });

          } else {

              $('.x_panel_status .x_footer').css({
                  position: 'relative',
                  top: 'initial',
                  width: 'auto',
              });
              $warpper.css({
                  'padding-bottom': 0
              });

          }

      });

  });
  </script>
<?php },'input-status',true) ?>