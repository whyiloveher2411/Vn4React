@extends(backend_theme('master'))

@section('content')
<?php 
 title_head( __('Help') );
?>

<?php 
    vn4_tabs_left([
      'shortcuts'=>[
        'title'=>'Shortcuts',
        'content'=>function(){
            echo vn4_view(backend_theme('page.help.shortcuts'));
        }
      ],
    ]);
 ?>
@stop


@section('js')
  <script type="text/javascript">

    window.timeoutClearShortcut = false;
    window.keysDown = [];

    $(window).load(function(){
      $(window).keydown(function(event) {
        // alert(event.keyCode);
          
          clearTimeout(timeoutClearShortcut);

          window.timeoutClearShortcut = setTimeout(function() {
            window.keysDown = [];
          }, 1000);

          keysDown[event.keyCode] = true;

          let strTitle = [];
          let keysCode = [];

          for( var key in keysDown ){
            if( keysDown[key] ){
              // console.log($('[data-code='+key+']').eq(0).data('title'));
              if( $('[data-code='+key+']').eq(0).data('title') != undefined ){
                strTitle.push( $('[data-code='+key+']').eq(0).data('title') );
              }else{
                strTitle.push( $('[data-code='+key+']').eq(0).text().trim() );
              }
              keysCode.push(key);
            }
          }

          keyCode = keysCode.join(',');

          if( $('.active_focus_shortcut').length ){

            event.preventDefault();
            event.stopPropagation();

            $('[data-code='+event.keyCode+']').css({'box-shadow':'0.1em 0.1em 0.1em rgba(0, 0, 0, 0.2),0 0 0 0.05em rgba(0, 0, 0, 0.4),-0.025em -0.05em 0.025em rgba(255, 255, 255, 0.8) inset','background':'aliceblue'});

            $('.active_focus_shortcut').val(strTitle.join(' + '));
            $('.active_focus_shortcut').closest('tr').find('input:eq(1)').val(keyCode);

            return false;
          }

      });

      $(window).keypress(function(event){
          if( $('.active_focus_shortcut').length ){
            event.stopPropagation();
            event.preventDefault();
          }
      });

      $(window).keyup(function(event) {
          if( $('.active_focus_shortcut').length ){
            event.preventDefault();
            event.stopPropagation();
            keysDown[event.keyCode] = false;
            $('[data-code='+event.keyCode+']').css({'box-shadow':'-0.2em -0.125em 0.125em rgba(0, 0, 0, 0.25), 0 0 0 0.04em rgba(0, 0, 0, 0.3), 0.02em 0.02em 0.02em rgba(0, 0, 0, 0.4) inset, -0.05em -0.05em 0.02em rgba(255, 255, 255, 0.8) inset','background':'#eee'});
            return false;
          }
      });

      $(document).on('focus','input[name*="[shortcut]"]',function(){
        $(this).addClass('active_focus_shortcut');
      });

      $(document).on('focusout','input[name*="[shortcut]"]',function(){
        $(this).removeClass('active_focus_shortcut');
      });

    });
  </script>
@stop