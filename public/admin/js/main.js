var isInIframe = (window.location != window.parent.location) ? true : false;

if (!isInIframe) {
    

} else {

    window.onresize = displayWindowSize;
    function displayWindowSize() {
        if( !$(window.frameElement).parent().hasClass('popup-content') ){
            window.parent.resizeIframe(  window.frameElement );
        }
    };

    if( $('.session-message').length ){

        let id = $('.session-message').data('id');

        if( !$('.session-message.fadeIn[data-id="'+id+'"]').length ){
            let color = $('.session-message .warpper').css('background-color');
            if( color == 'rgb(202, 33, 33)' ){
                window.parent.show_message({
                    title: $('.session-message-title').text(),
                    color:color,
                    icon:$('.session-message .fa').attr('class'),
                    content:$('.lobibox-notify-msg').text(),
                });

                $('.popup-fixed iframe' ,window.parent.document ).stop();

                $('html',window.parent.document).removeClass('show-popup-fixed');
                $('.popup-fixed iframe' ,window.parent.document ).remove();
            }
        }

    }

    $('body').css({'padding':0}).addClass('is-iframe');;
    $('#vn4-nav-top-login').remove();
}

// $(document).on('DOMNodeInserted', function(e) {
//     //check is iframe is loaded
//     if(e.target.localName=="iframe"){
//         e.a
//     };
// });

function show_loading(message, image = $('meta[name="domain"]').attr('content')+'/admin/images/image-loading-data-1.svg' ) {

    $('.popup-loadding img').attr('src',image);

    if (!message) {
        message = 'The process is running, please wait a moment';
    }

    $('.popup-loadding .content span').text(message);
    $('html').addClass('show-popup');
}

function show_message( message = 'Message' ) {
    if( message.title ){
        var d = new Date();
        var n = d.getTime();

        $('.message-warper').prepend('<div class="session-message session-message-'+n+' fadeIn"><div class="warpper" style="background-color:'+message.color+';"><div class="session-message-icon-wrapper"><i class="fa '+message.icon+'"></i></div><div class="session-message-body"><div class="session-message-title">'+message.title+'<div></div></div><div class="lobibox-notify-msg">'+message.content+'</div></div><i class="fa fa-times session-message-icon-close" aria-hidden="true"></i><div class="progress-bar"></div></div></div>');

        $(".session-message .progress-bar").animate({
            width: "100%"
        }, 10000, function() {
            $('.session-message-'+n+'').addClass('fadeInDown');

            setTimeout(function() {
                $('.session-message-'+n+'').hide(300,function(){
                    $('.session-message-'+n+'').remove();
                });
            },1);

        });
    }else{
        if (message) {
            $('.vn4-message h4').html(message);
        }
        $('html').addClass('show-message');
    }
}

function hide_message() {
    $('html').removeClass('show-message');
}

$(document).on('click','.hide_message',function(){
    hide_message();
});

function hide_loading() {
    $('html').removeClass('show-popup');
}

function show_popup($this){

     if( $this.data('iframe') ){
        
        if( isInIframe ){
            window.parent.show_popup($this);
        }else{
            let width = '70%';

            if( $this.data('max-width') ){
                width = $this.data('max-width');
            }

            let data = 'data=\''+$this.attr('data')+'\'';

            $('.popup-fixed .popup-warper').css({'width': '500px'});
            $('.popup-fixed .popup-warper').css({'max-width': width});
            $('.a-poupup-title').attr('href', $this.data('iframe') );
            $('.popup-fixed .popup-title').html($this.data('title'));

            // $('.popup-fixed .popup-content').css({ height:'65vh',overflow:'hidden'}).html('<iframe style="display:none" onload="this.style.display = \'block\';" src="'+replaceUrlParam($this.data('iframe'),'iframe',1) +'"></iframe>');
            $('.popup-fixed .popup-content').css({ height:'50px'}).html('<img class="loadding" src="'+$('meta[name="domain"]').attr('content')+'/admin/images/loading2.gif"><iframe style="display:none" '+data+' onload="onload_popup(this);" src="'+replaceUrlParam($this.data('iframe'),'iframe',1) +'"></iframe>');
            $('.popup-fixed .popup-footer').html('');
            $('html').addClass('show-popup-fixed');
        }

    }else{
        vn4_ajax({
            url: $this.data('popup'),
            data: $this.data(),
            callback:function(result){
                $('.popup-fixed .popup-title').html(result.title);Z
                $('.popup-fixed .popup-content').html(result.content);
                $('.popup-fixed .popup-footer').html(result.footer);
                $('html').addClass('show-popup-fixed');
            }
        });
    }
}



function onload_popup(el){

    if( !$(el).data('onload') ){
        $(el).closest('.popup-warper').css({width:'70%'});
        $(el).closest('.popup-content').find('.loadding').remove();
        $(el).closest('.popup-content').animate({height:'65vh'},700,function(){

            $(el).attr('data-onload',1);

            $(el).closest('.popup-content').find('iframe').css({'display':'block','opacity':'0'}).animate({
                opacity:'1'
            },300);
        });
    }else{
        $(el).trigger('reload-iframe');
    }
}

$('body').on('reload-iframe','iframe', function(){
    let data = JSON.parse($(this).attr('data'));

    if( data.iframe_reload ){
        document.querySelector(data.iframe_reload).contentWindow.location.reload();
    }
});

function vn4_ajax(arg) {
    var url = window.location.href,
        dataType = 'Json',
        type = 'POST',
        data = {};
    if (arg['url']) {
        url = arg['url'];
    }

    if (arg['type']) {
        type = arg['type'];
    }

    if (arg['dataType']) {
        dataType = arg['dataType'];
    }

    data._token = $('#laravel-token').val();

    if (arg['data']) {

        for (var attrname in arg['data']) {
            data[attrname] = arg['data'][attrname];
        }

    }

    $.ajax({
            url: url,
            type: type,
            dataType: dataType,
            data: data,
            cache: false,
            beforeSend: function() {
                if (arg['show_loading']) {

                    if( typeof arg['show_loading'] == 'string' ){
                        show_loading(arg['show_loading']);
                    }else{
                        show_loading();
                    }
                }
            },
            success: function(data) {

                if (arg['callback']) {
                    arg['callback'](data);
                }

                if (arg['default_handling'] == undefined || arg['default_handling']) {

                    if (data.url_redirect) {
                        window.location.href = data.url_redirect;
                    }

                    if( data.message ){
                        if (typeof data.message === 'string') {
                            alert(data.message);
                        }else{
                            show_message(data.message)
                        }
                    }
                    
                    if (data.reload) {
                        location.reload();
                    }


                    if (data.append) {
                        htmls = data.append;
                        for (i = 0; i < htmls.length; i++) {
                            $(htmls[i].selector).append(htmls[i].html);
                        }
                    }

                }
            },
            error: function(data) {
                if (arg['error_callback']) {
                    arg['error_callback'](data);
                }
            }

        }).fail(function(data) {

            if (arg['fail_callback']) {
                arg['fail_callback'](data);
            }

            console.log('vn4_ajax fail');
        })
        .always(function() {
            if (arg['show_loading']) {
                hide_loading();
            }
        });

}

$('body').on('click', '.ajax', function() {
    vn4_ajax({
        url: $(this).data('url'),
    });
});



function search($this) {
    $('.form-search .sub-menu').css({
        'display': 'block',
        'opacity': 1
    });
    $('.form-search .sub-menu').html('<p>...</p>');
    vn4_ajax({
        url: $this.data('url'),
        data: {
            search: $this.val()
        },
        callback: function(result) {
            if (result.data.length) {
                let warpper = $('.form-search .sub-menu ');

                warpper.empty();

                for (var i = 0; i < result.data.length; i++) {

                    let data = '';

                    if( result.data[i].data ){
                        for (const [key, value] of Object.entries(result.data[i].data)) {
                            data += key + '="' + value +'" ';
                        }
                    }

                    warpper.append('<a href="' + result.data[i].link + '" '+data+' ><strong>[' + result.data[i].title_type + ']</strong> ' + result.data[i].title + '</a>');
                }

                warpper.append('<a style="text-align: center;border-top: 1px solid #D8D8D8;line-height: 28px;" href="' + result.learn_more.link + '"><strong></strong> ' + result.learn_more.title + '</a>');
            } else {
                $('.form-search .sub-menu ').html('<p>Nothing</p>');
                 $('.form-search .sub-menu ').append('<a style="text-align: center;border-top: 1px solid;line-height: 28px;" href="' + result.learn_more.link + '"><strong></strong> ' + result.learn_more.title + '</a>');

            }


        }
    });
}

$(document).on('click','#inputSearch',function() {
    $('.form-search .sub-menu').css({
        'display': 'block',
        'opacity': 1
    });
});
$('#inputSearch').focusout(function() {
    // setTimeout(function() {
    $('.form-search .sub-menu').fadeTo(500, 0, function() {
        $('.form-search .sub-menu').hide();
    });
    // }, 1000);

});

$('body').on('click', '.form-search .fa', function(event) {
    search($('#inputSearch'));
});

$('body').on('keydown', '#inputSearch', function(event) {

    var keyCode = event.keyCode;

    if (keyCode == 13) {

        if ($('.form-search .sub-menu a.active').length) {

            if( ctrlDown ){
                window.open($('.form-search .sub-menu a.active').attr('href'));
                return;
            }

            window.location.href = $('.form-search .sub-menu a.active').attr('href');
            return ;
        }

        search($(this));
    } else if (keyCode == 40) {
        event.preventDefault();
        if ($('.form-search .sub-menu a.active').length) {
            $('.form-search .sub-menu a.active').removeClass('active').next('a').addClass('active');
        } else {
            $('.form-search .sub-menu a:eq(0)').addClass('active');
        }
    } else if (keyCode == 38) {
        event.preventDefault();
        if ($('.form-search .sub-menu a.active').length) {
            $('.form-search .sub-menu a.active').removeClass('active').prev('a').addClass('active');
        } else {
            $('.form-search .sub-menu a:last-child').addClass('active');
        }
    } else if (keyCode != 17) {
        $('.form-search .sub-menu a.active').removeClass('active');
    }


});


    var is_admin_page = document.getElementById("is_link_admin_vn4_cms");

    if (is_admin_page) {


        $(window).on("beforeunload", function() {
            if (window._formHasChanged && !window.submitted) {
                var message = "Are you sure? You didn't finish the form!",
                    e = e || window.event;
                if (e) {
                    e.returnValue = message;
                }
                return message;
            }
        });

        $(document).on('change', 'form', function() {
            window._formHasChanged = true;
        });

        $("form").submit(function() {
            window.submitted = true;
        });

        function loadScript(url, callback) {

            var script = document.createElement("script")
            script.type = "text/javascript";

            if (script.readyState) { //IE
                script.onreadystatechange = function() {
                    if (script.readyState == "loaded" ||
                        script.readyState == "complete") {
                        script.onreadystatechange = null;
                        callback();
                    }
                };
            } else { //Others
                script.onload = function() {
                    callback();
                };
            }

            script.src = url;
            document.getElementsByTagName("head")[0].appendChild(script);
        }



        $('body').on('click', '.onAjax', function(event) {

            event.preventDefault();
            event.stopPropagation();

            $url = $(this).data('url');

            vn4_ajax({
                'url': $url
            });
        });

        window.resizeIframe = function(obj, add_height = 0) {
            if( obj ){
                obj.style.height = (obj.contentWindow.document.body.offsetHeight + add_height) + 'px';
            }
            hide_loading();
        }


        $(document).ready(function() {

            if ($.fn.mCustomScrollbar) {
                $('.menu_fixed').mCustomScrollbar({
                    autoHideScrollbar: true,
                    theme: 'minimal',
                    mouseWheel: {
                        preventDefault: true
                    }
                });
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.x_panel .collapse-link', function(event) {
                event.stopPropagation();
                event.preventDefault();
                let $BOX_PANEL = $(this).closest('.x_panel'),
                    $ICON = $(this).find('i'),
                    $BOX_CONTENT = $BOX_PANEL.find('.x_content:first');


                $BOX_CONTENT.slideToggle(200);

                $ICON.toggleClass('fa-chevron-up fa-chevron-down');
            });

            $(document).on('click','.close-link',function() {
                let $BOX_PANEL = $(this).closest('.x_panel');

                $BOX_PANEL.remove();
            });
        });
     
        if ($(".progress .progress-bar")[0]) {
            $('.progress .progress-bar').progressbar();
        }
        $(document).ready(function() {
            if ($(".js-switch")[0]) {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                elems.forEach(function(html) {
                    var switchery = new Switchery(html, {
                        color: '#26B99A'
                    });
                });
            }
        });
        $(document).ready(function() {
            if ($("input.flat")[0]) {
                $(document).ready(function() {
                    $('input.flat').iCheck({
                        checkboxClass: 'icheckbox_flat-green',
                        radioClass: 'iradio_flat-green'
                    });
                });
            }
        });
        $('table input').on('ifChecked', function() {
            checkState = '';
            $(this).parent().parent().parent().addClass('selected');
            countChecked();
        });
        $('table input').on('ifUnchecked', function() {
            checkState = '';
            $(this).parent().parent().parent().removeClass('selected');
            countChecked();
        });

        var checkState = '';

        $('.bulk_action input').on('ifChecked', function() {
            checkState = '';
            $(this).parent().parent().parent().addClass('selected');
            countChecked();
        });
        $('.bulk_action input').on('ifUnchecked', function() {
            checkState = '';
            $(this).parent().parent().parent().removeClass('selected');
            countChecked();
        });
        $('.bulk_action input#check-all').on('ifChecked', function() {
            checkState = 'all';
            countChecked();
        });
        $('.bulk_action input#check-all').on('ifUnchecked', function() {
            checkState = 'none';
            countChecked();
        });

        function countChecked() {
            if (checkState === 'all') {
                $(".bulk_action input[name='table_records']").iCheck('check');
            }
            if (checkState === 'none') {
                $(".bulk_action input[name='table_records']").iCheck('uncheck');
            }

            var checkCount = $(".bulk_action input[name='table_records']:checked").length;

            if (checkCount) {
                $('.column-title').hide();
                $('.bulk-actions').show();
                $('.action-cnt').html(checkCount + ' Records Selected');
            } else {
                $('.column-title').show();
                $('.bulk-actions').hide();
            }
        }

        $(document).ready(function() {
            $(".expand").on("click", function() {
                $(this).next().slideToggle(200);
                $expand = $(this).find(">:first-child");

                if ($expand.text() == "+") {
                    $expand.text("-");
                } else {
                    $expand.text("+");
                }
            });
        });

        if (typeof NProgress != 'undefined') {
            $(document).ready(function() {
                NProgress.start();
            });

            $(window).load(function() {
                NProgress.done();
            });
        }
     
        (function($, sr) {
            var debounce = function(func, threshold, execAsap) {
                var timeout;

                return function debounced() {
                    var obj = this,
                        args = arguments;

                    function delayed() {
                        if (!execAsap)
                            func.apply(obj, args);
                        timeout = null;
                    }

                    if (timeout)
                        clearTimeout(timeout);
                    else if (execAsap)
                        func.apply(obj, args);

                    timeout = setTimeout(delayed, threshold || 100);
                };
            };

            jQuery.fn[sr] = function(fn) {
                return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
            };

        })(jQuery, 'smartresize');



        function replaceUrlParam(url, paramName, paramValue) {
            if (paramValue == null)
                paramValue = '';
            var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)');
            if (url.search(pattern) >= 0) {
                return url.replace(pattern, '$1' + paramValue + '$2');
            }
            return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
        }

        function removeParam(key, sourceURL) {
            var rtn = sourceURL.split("?")[0],
                param,
                params_arr = [],
                queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
            if (queryString !== "") {
                params_arr = queryString.split("&");
                for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                    param = params_arr[i].split("=")[0];
                    if (param === key) {
                        params_arr.splice(i, 1);
                    }
                }
                rtn = rtn + "?" + params_arr.join("&");
            }
            return rtn;
        }

        function url_value(url, k) {

            var params = url.split('?');
            if (params[1]) {
                params = params[1].split('&');

                if( !k ) return params;

                for (var i = 0; i < params.length; i++) {
                    var temp = params[i].split('=');
                    var key = temp[0];
                    var value = temp[1];

                    if (k == key) {
                        return value;
                    }

                }

                return null;

            }

            return null;

        }

        if( url_value(window.location.href,'iframe') && !isInIframe ){
            window.location.href = 'https://vn4cms.com';
            exit();
        }


        function get_val_checkbox(select) {
            return list_object = $(select + ':checked').map(function(index, el) {
                return $(el).val();
            }).get();

        }


        $(document).on('click','#backUrl',function() {
            window.history.back();
        });


        function clickIconTopnav() {
            $('.topnav').toggleClass('responsive');
        }

        $(document).on('click','.iconbacktotop',function(e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });

        WebFontConfig = {
            google: {
                families: ['Roboto::latin,latin-ext']
            }
        };

        $('body').on('click','.session-message-icon-close, .warpper',function(event) {

            $this = $(this);
            $this.closest('.session-message').addClass('fadeInDown');
            setTimeout(function() {
                $this.closest('.session-message').remove();
            }, 1000);
        });



        $(".session-message .progress-bar").animate({
            width: "100%"
        }, 10000, function() {
            $('.session-message').addClass('fadeInDown');

            setTimeout(function() {
                $('.session-message').remove();
            }, 1000);

        });



        $(document).on('click', '.not-href', function(event) {
            event.preventDefault();
        });

        $(document).on('click','.btn-open-toggle',function(event) {
            $($(this).attr('data-toggle')).slideDown('fast');
            $(this).css({
                display: 'none'
            });
        });

        $(document).on('click','.cancel-open-toggle',function(event) {
            $(this).closest('.warpper-toggle').slideUp('fast');
            $($(this).attr('data-toggle')).css({
                display: 'inline'
            });
        });

        $(document).on('click','.screen-warp-button button',function(event) {


            $('.screen-warp-button button.active:not(#' + $(this).attr('id') + ')').removeClass('active');

            $(this).toggleClass('active');

            $('#screen-meta .screen-meta-warp.active').removeClass('active').slideUp('fast');

            if ($(this).hasClass('active')) {
                $('#screen-meta .screen-meta-warp.' + $(this).attr('aria-controls')).addClass('active').slideToggle('fast');
            }

        });


        $(document).on('click','.contextual-help-tabs li a',function(event) {
            $('.contextual-help-tabs li.active').removeClass('active');
            $(this).closest('li').addClass('active');

            $('.contextual-help-tabs-wrap .active').removeClass('active');
            $('.contextual-help-tabs-wrap .' + $(this).attr('aria-controls').trim()).addClass('active');
        });

        //tabs
        $(document).on('click', '.vn4_tabs_left  .menu-left li a', function(event) {

            event.preventDefault();
            window.history.pushState("object or string", "Page", replaceUrlParam(window.location.href, 'vn4-tab-left-' + ($(this).closest('.vn4_tabs_left').data('id')), $(this).attr('aria-controls')));
            if ($(this).hasClass('new-link')) {
                window.location.reload();
                return;
            }

            $(this).closest('.vn4_tabs_left').find('.menu-left li.active').removeClass('active');
            $(this).closest('li').addClass('active');

            $(this).closest('.vn4_tabs_left').find('>.content-right>.tab.active').removeClass('active');
            $(this).closest('.vn4_tabs_left').find('>.content-right>.tab.content-tab-' + $(this).attr('aria-controls').trim()).addClass('active');

        });

        $(document).on('click', '.vn4_tabs_top .menu-top a', function(event) {

            event.preventDefault();
            if ($(this).hasClass('drop-menu')) {
                return;
            }
            window.history.pushState("object or string", "Page", replaceUrlParam(window.location.href, 'vn4-tab-top-' + ($(this).closest('.vn4_tabs_top').data('id')), $(this).attr('aria-controls')));

            if ($(this).hasClass('new-link')) {
                window.location.reload();
                return;
            }

            $(this).closest('.menu-top').find('a.active').removeClass('active');

            $(this).addClass('active');

            if ($(this).closest('div').hasClass('dropdown')) {
                $(this).closest('div').find('>a').addClass('active');
            }

            if ($(this).attr('aria-controls')) {
                $(this).closest('.vn4_tabs_top').find('>.content-bottom>.active').removeClass('active');
                $(this).closest('.vn4_tabs_top').find('>.content-bottom>.tab-content-' + $(this).attr('aria-controls').trim()).addClass('active');
            }

        });

        $('body').on('click', '.open-loading', function() {
            show_loading();
        });
        
        var ctrlDown = false,shiftDown = false,altDown = false,
            ctrlKey = 17,
            altKey = 18,
            cmdKey = 91,
            shiftkey = 16,
            dkey = 68,
            vKey = 86,
            pkey = 80,
            fkey = 70,
            cKey = 67;
            position = 0;

        $(window).keydown(function(e) {
            // alert(e.keyCode);

            // $('[data-code='+e.keyCode+']').css({'background':'green'});

            if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
            if (e.keyCode == altKey) altDown = true;
            if( e.keyCode == shiftkey ) shiftDown = true;
            //keypress F
            if( ctrlDown && e.keyCode == 70 ){
                $('#inputSearch').focus();
                $('.form-search .sub-menu').css({
                    'display': 'block',
                    'opacity': 1
                });
                e.preventDefault();
                e.stopPropagation();
            }
        });

        $(window).keyup(function(e) {
             if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
             if (e.keyCode == shiftkey ) shiftDown = false;
             if (e.keyCode == altKey ) altDown = false;
        });

      $('[data-toggle="tooltip"]').tooltip();

        $(window).load(function(){

            let CURRENT_URL = window.location.href.split('?')[0],
                $SIDEBAR_MENU = $('#sidebar-menu');
            $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

            $SIDEBAR_MENU.find('a:not(.menu_toggle)').filter(function() {
                return this.href == CURRENT_URL || $(this).hasClass('current-link');
            }).parent('li').addClass('current-page').parents('ul').show(0).parent().addClass('active');
            
            if( $('.tab-ace-editor, .tab-visual, iframe, .custom_scroll').length ){
                let toolbox = $('.tab-ace-editor, .tab-visual, iframe, .custom_scroll'),
                      height = toolbox.height(),
                      scrollHeight = toolbox.get(0).scrollHeight;

                toolbox.bind('mousewheel', function(e, d) {
                    if((this.scrollTop === (scrollHeight - height) && d < 0) || (this.scrollTop === 0 && d > 0)) {
                      // e.preventDefault();
                    }
                });
            }



            $('body').on('click', '.menu_toggle', function() {
                $('.left_col,.sidebar-footer').toggleClass('active');
                event.stopPropagation();
                event.preventDefault();
            });

             $(document).on('click','#sidebar-menu a',function(){
                var $li = $(this).parent();

                if ($li.is('.active')) {
                    $li.removeClass('active active-sm');
                    $('ul:first', $li).slideUp();
                } else {
                    if (!$li.parent().is('.child_menu')) {
                        $('#sidebar-menu').find('li').removeClass('active active-sm');
                        $('#sidebar-menu').find('li ul').slideUp();
                    }

                    $li.addClass('active');

                    $('ul:first', $li).slideDown();
                }
            });
           

            $(document).on('click','.collapse-menu-main', function(){

                var $this = $(this);

                $('body').toggleClass('collapse-body');
                $this.find('.fa').toggleClass('fa-caret-right fa-caret-left');

                vn4_ajax({
                    url: $this.data('url'),
                    data:{
                        name: $this.data('name'),
                    }
                });
                event.stopPropagation();

            });

            $(document).on('click','html',function(){
                if( $('body').hasClass('collapse-body') ){
                    $('.left_col,.sidebar-footer').removeClass('active');
                }
                $('html').removeClass('show-popup-fixed');
            });

            $(document).on('click','.left_col, .popup-warper',function(event){
                event.stopPropagation();
            });

            $(document).on('click','[data-message]',function(){
                show_loading($(this).data('message'), $(this).data('image'));
            });

            $(document).on('click','[data-popup]',function(event){
                event.stopPropagation();
                event.preventDefault();
                show_popup($(this));
            });

            $(document).on('click','.popup-fixed .icon-close',function(){
                $('html').removeClass('show-popup-fixed');
            });

            setTimeout(function() {
                $('.data-iframe').each(function(index, el) {
                    $(el).append('<iframe style="width:100%;float:left;" onload="resizeIframe(this)" id="iframe-'+$(el).data('name')+'" seamless frameborder="0" scrolling="no" src="' + replaceUrlParam($(el).data('url'),'iframe',1) + '"></iframe><div class="clearfix"></div>');
                });

                $('.load-more').each(function(index,el){

                    if( $(el).data('type') == 'js' ){
                        let tag = document.createElement("script");
                        tag.src = $(el).attr('content');
                        document.getElementsByTagName("head")[0].appendChild(tag);
                    }else{
                        let link = document.createElement('link');
                        link.rel = 'stylesheet';
                        link.href = $(el).attr('content');
                        document.head.appendChild(link);
                    }
                });

            }, 10);


            window.timeoutClearShortcut = false;
            window.keysDown = [];

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
                  strTitle.push( $('[data-code='+key+']').eq(0).text().trim() );
                  keysCode.push(key);
                }
              }

              keyCode = keysCode.join(',');

              if( typeof listShortcutkey !== 'undefined' && listShortcutkey[keyCode] ){

                if( listShortcutkey[keyCode].message ){
                    show_loading(listShortcutkey[keyCode].message, listShortcutkey[keyCode].image_loading );
                }

                if( listShortcutkey[keyCode].target == '_self' ){
                    if( isInIframe ){
                        window.parent.location.href = replaceUrlParam(listShortcutkey[keyCode].link,'rel','shortcut');
                    }else{
                        window.location.href = replaceUrlParam(listShortcutkey[keyCode].link,'rel','shortcut');
                    }
                    return;
                }

                if( listShortcutkey[keyCode].target == '_blank' ){
                  window.open( replaceUrlParam(listShortcutkey[keyCode].link,'rel','shortcut') );
                  return;
                }

                if( listShortcutkey[keyCode].target == 'popup' ){
                    if( isInIframe ){

                        $('body', window.parent.document).append('<a href="#" id="openLinkShortcutPopup" data-popup="1" data-title="'+listShortcutkey[keyCode].title+'" data-iframe="'+replaceUrlParam(listShortcutkey[keyCode].link,'rel','shortcut')+'" style="opacity:0"></a>')
                        $('#openLinkShortcutPopup', window.parent.document ).trigger('click');

                        setTimeout(function() {
                            $('#openLinkShortcutPopup', window.parent.document ).remove();
                        },1000);

                    }else{
                        $('body').append('<a href="#" id="openLinkShortcutPopup" data-popup="1" data-title="'+listShortcutkey[keyCode].title+'" data-iframe="'+replaceUrlParam(listShortcutkey[keyCode].link,'rel','shortcut')+'" style="opacity:0"></a>')
                        $('#openLinkShortcutPopup').trigger('click');

                        setTimeout(function() {
                            $('#openLinkShortcutPopup').remove();
                        },1000);
                    }
                    return;
                }
              }
            });

            $(window).keyup(function(event) {
              if( $('.active_focus_shortcut').length ){
                event.preventDefault();
                event.stopPropagation();
                keysDown[event.keyCode] = false;
                return false;
              }
            });
        
           

            window.udpateNumberPositionRepeater  = function(parent){
                if( parent.find('>.list-input>.repeater-item').length > 0 ){
                    parent.find('>.input-clear-data').remove();
                    parent.find('>.list-input>.repeater-item').each(function(index2, el2) {
                        $(el2).css({'z-index':(1000-index2)}).find('>.x_panel>.x_title>h2>.number_position').text(index2 + 1+'. ');
                    });
                    parent.find('>.add-box-repeater-warpper').hide();
                }else{
                    parent.append('<input type="hidden" value="" class="input-clear-data" name="'+parent.data('name')+'">');
                    parent.find('>.add-box-repeater-warpper').show();
                }
                $( ".input-repeater .list-input" ).sortable({
                    handle:'.x_title',
                    stop:function(event, ui){
                        ui.item.attr('style','');
                    },
                    update: function(event, ui) {
                        udpateNumberPositionRepeater($(ui.item[0]).closest('.input-repeater'));
                    },
                    start:function(event,ui){
                        event.stopPropagation();
                        ui.placeholder.height(ui.item.height() - 4);
                    }
               });

                parent.find(':input').eq(0).trigger('change');

            }


            $(document).on('click','.input-repeater>.list-input>.repeater-item>.x_panel>.x_title',function(event){
                event.stopPropagation();
                $(this).find('.collapse-link').trigger('click');

            });
            $(document).on('click','.input-repeater>.list-input>.repeater-item>.x_panel>.x_title>.panel_toolbox>li>a>.fa-trash-o',function(event){

                event.stopPropagation();
                $(this).closest('.x_title').toggleClass('btn-danger');

                if( $(this).closest('.x_title').hasClass('btn-danger') ){
                    $(this).closest('.x_panel').find('>.x_content .input-trash:first-child').val(1).trigger('change');
                }else{
                    $(this).closest('.x_panel').find('>.x_content .input-trash:first-child').val(0).trigger('change');

                }

            });
            $(document).on('click','.input-repeater>.list-input>.repeater-item>.x_panel>.x_title>ul>li>a>.fa-times',function(event){
                event.stopPropagation();

                var r = confirm("Are you sure!");

                if (r == true) {

                    var $parent = $(this).closest('.input-repeater');
                    $(this).closest('.repeater-item').remove();

                    udpateNumberPositionRepeater($parent);
                }
            });

            window.input_repeater_update_class_title_item = function(){
                $('.input-repeater .x_panel').each(function(index,el){
                    $(el).find(':input:not(.input-trash):first').addClass('change_title_item_input_repeater');
                });
            };
            input_repeater_update_class_title_item();

            $('.change_title_item_input_repeater').each(function(index,el){

                if( $( el ).val() ){ 
                    $(el).closest('.x_panel').find('>.x_title>h2>.title').text($(el).val());
                }
            });

            $(document).on('keyup','.change_title_item_input_repeater',function(){
                $(this).closest('.x_panel').find('>.x_title>h2>.title').text($(this).val());
            });

            $(document).on('change','.change_title_item_input_repeater',function(){
                $(this).closest('.x_panel').find('>.x_title>h2>.title').text($(this).val());
            });

            window.input_repeaters_add_item = function($this){
                var max = $this.closest('.input-repeater').data('max'), count = $this.closest('.input-repeater').find('>.x_panel').length;

                if( max && parseInt(count) >= parseInt(max)  ){
                    alert('Đã đủ số lượng.'); return;
                }
                
                var element = $($('#'+$this.data('template')).html());

                element.find('.x_content').css({'display':'block'});

                element.find('textarea.editor-content').attr('id','___change__id__group__input__'+$('textarea.editor-content').length);
                element.find(':input:not(.input-trash):first').addClass('change_title_item_input_repeater');

                $this.parent().find('>.list-input').append(element);

                udpateNumberPositionRepeater($this.closest('.input-repeater'));
            };

            $(document).on('click', '.input-repeater .add-group-item', function(event) {
                event.preventDefault();
                event.stopPropagation();
                input_repeaters_add_item($(this));
               
            });
            window._group_input_open = function(){

                $('.input-repeater .x_content:has(.input-group-new)').css({display:'block'});
            };

            _group_input_open();

            $(document).on('click','.add-box-repeater-warpper',function(event){
                event.stopPropagation();
                event.preventDefault();
                input_repeaters_add_item($(this).closest('.input-repeater').find('>.add-group-item'));
            });


            function change_name_repeater_input(){
                $('.validate-repeater').remove();
                $('.input-repeater').each(function(index, el) {
                    $(el).find('>.list-input>.repeater-item>.x_panel').each(function(index2, el2) {
                        $(el2).find('[name]').each(function(index3, el3) {
                            $(el3).attr('name',($(el3).attr('name')).replace(/index_repeater/, index2 ));
                        });
                    });

                    var min = parseInt($(el).data('min')), max = parseInt($(el).data('max')), count = parseInt($(el).find('.x_panel').length);

                    if( min > count || count > max ){
                        $(el).append('<span class="not-validate validate-repeater"></span>');
                        event.preventDefault();
                    }

                });
                
            }
            $('form:not(.form-rel)').submit(function(){
                change_name_repeater_input();
            });
            $('.right_col').on('change',':input',function(){
                change_name_repeater_input();
            });

            setTimeout(function() {
                change_name_repeater_input();
            }, 10);
            

            $('.right_col').on('focus',':input',function(){
                change_name_repeater_input();
            });
            // End: Repeater
            //Begin: flexible
           

            function udpateNumberPositionFlexible(parent){

                if( parent.find('>.list-box>.flexible-item').length > 0 ){
                    parent.find('>.list-box>.flexible-item').each(function(index2, el2) {
                        $(el2).find('>.x_panel>.x_title>.number_position').text(index2 + 1+'. ');
                    });
                    parent.find('>.add-box-flexible-warpper').hide();
                }else{
                    parent.find('>.add-box-flexible-warpper').show();
                }
                
                parent.find(':input').eq(0).trigger('change');
            }


            $(document).on('click','.input-flexible>.list-box>.flexible-item>.x_panel>.x_title',function(event){
                event.stopPropagation();
                $(this).find('.collapse-link').trigger('click');
            });

            function change_name_flexible_input(){
                $('.validate-flexible').remove();
                $('.input-flexible').each(function(index, el) {

                    $(el).find('>.list-box>.flexible-item>.x_panel').each(function(index2, el2) {
                        $(el2).find('[name]').each(function(index3, el3) {
                            $(el3).attr('name',($(el3).attr('name')).replace(/index_flexible/, index2 ));
                        });
                    });

                    var min = parseInt($(el).data('min')), max = parseInt($(el).data('max')), count = parseInt($(el).find('.x_panel').length);

                    if( min > count || count > max ){
                        $(el).append('<span class="not-validate validate-flexible"></span>');
                        event.preventDefault();
                    }

                });
            }
            $('.right_col').on('change',':input',function(){
                change_name_flexible_input();
            });

            setTimeout(function() {
                change_name_flexible_input();
            }, 10);
            

            $('form:not(.form-rel)').submit(function(){
                change_name_flexible_input();
            });
            $('.right_col').on('focus',':input',function(){
                change_name_flexible_input();
            });

            $(document).on('click','.input-flexible>.list-box>.flexible-item>.x_panel>.x_title>.panel_toolbox>li>a>.fa-trash-o',function(event){
                event.stopPropagation();
                $(this).closest('.x_title').toggleClass('btn-danger');

                if( $(this).closest('.x_title').hasClass('btn-danger') ){
                    $(this).closest('.x_panel').find('>.x_content>.input-trash').val(1).trigger('change');
                }else{
                    $(this).closest('.x_panel').find('>.x_content>.input-trash').val(0).trigger('change');
                }
            });
            $(document).on('click','.input-flexible>.list-box>.flexible-item>.x_panel>.x_title>ul>li>a>.fa-times',function(event){

                event.stopPropagation();

                var r = confirm("Are you sure!");

                if (r == true) {

                    var $parent = $(this).closest('.input-flexible');
                    $(this).closest('.flexible-item').remove();

                    udpateNumberPositionFlexible($parent);
                }
                
            });

            window.input_flexible_update_class_title_item = function(){
                $('.input-flexible .x_panel').each(function(index,el){
                    $(el).find(':input:not(.input-trash):not(.flexible-type):first').addClass('change_title_item_input_flexible');
                });
            };
            input_flexible_update_class_title_item();

            $('.change_title_item_input_flexible').each(function(index,el){

                if( $(el).val() && $(el).val().length > 3 && $(el).val().length < 90 ){
                    let element = $(el).closest('.x_panel');
                    element.find('>.x_title>.title-flexible-item').text($(el).val());
                }
            });

            $(document).on('keyup','.change_title_item_input_flexible',function(){

                if( $(this).val() && $(this).val().length > 3 && $(this).val().length < 90 ){
                    $(this).closest('.x_panel').find('>.x_title>.title-flexible-item').text($(this).val());
                }

            });

            $(document).on('click','.add-box-flexible-warpper',function(event){
                event.stopPropagation();
                $(this).closest('.input-flexible').find('.list_template_title').addClass('open');
            });
            $(document).on('click', '.input-flexible>.list_template_title>.dropdown-menu>li>a', function(event) {

                event.preventDefault();

                var max = $(this).closest('.input-flexible').data('max'), count = $(this).closest('.input-flexible').find('.x_panel').length;

                if( max && parseInt(count) >= parseInt(max)  ){
                    alert('Đã đủ số lượng.'); return;
                }
                var element = $($('#script-template-flexible-'+ $(this).closest('.dropdown-menu').data('field')+'-'+$(this).data('field')).html());

                element.find('.x_content').css({'display':'block'}).closest('.flexible-item').append('<div class="clearfix"></div>');

                element.find(':input:not(.input-trash):not(.flexible-type):first').addClass('change_title_item_input_flexible');

                // element.find('textarea.editor-content').attr('id','___change__id__group__input__'+$('textarea.editor-content').length);
                // element.find('input:first-child').addClass('change_title_item_group_input');

                $(this).closest('.input-flexible').find('>.list-box').append(element);

                udpateNumberPositionFlexible($(this).closest('.input-flexible'));

                for( let i in update_after_add ){
                    update_after_add[i]();
                }
                
            });
            //End: flexible


            // Asset File
            $('body').on('click', '.button_add_file_tiny ', function(event) {

                window._data_validate_img = $(this).data();

                event.preventDefault();

                $(this).addClass('chose-file-active');
                $('#filemanager_file_chose').val('');
                $('.modal-wapper-add-file').show().addClass('input-file-active');

            });

            $('.input_file_asset').each(function(i,el){
                if( $(el).val() ){

                    var obj = JSON.parse($(el).val());

                    if( obj ){
                        var extension = obj.type_file,
                            file_name = obj.file_name;

                        if( obj.type_link == 'local' ){
                            file_url = $('meta[name="domain"]').attr('content')+ '/'+obj.link;
                        }else{
                            file_url = obj.link;
                        }
                            

                        if ( obj.is_image ) {
                            $(el).parent().find('.preview_file').attr('href',file_url).html('<img style="margin:5px 0;display: block;" src="'+file_url+'" >'+file_name).show();
                        } else{
                             $(el).parent().find('.preview_file').attr('href',file_url).html('<img style="margin:5px 0;display: block;" src="'+$('meta[name="domain"]').attr('content')+'/'+'filemanager/filemanager/img/ico/'+extension+'.jpg" >'+file_name).show();
                        }

                    }

                }
            });

            $('body').on('change','.name_file_preview',function(){

                var warpper = $(this).closest('.input-file'),
                    link_file = warpper.find('.preview_file').attr('href'),
                    name_file_preview = $(this).val();

                var value = {'name':name_file_preview,'link':link_file};
                value = JSON.stringify(value);
                warpper.find('textarea').val(value);

            });

            $('body').on('click', '#add-file-btn-ok', function(event) {

                event.preventDefault();
                
                if( $('#filemanager_file_chose').val() ){
                    var file_url = $('#filemanager_file_chose').val();

                    var extension = file_url.split('.').pop(),
                        file_name = decodeURIComponent(file_url).split('/').pop(),
                        is_image = file_name.match(/\.(jpg|jpeg|png|gif)$/);

                    if ( is_image ) {
                        $('.input-file:has(.chose-file-active)').find('.preview_file').attr('href',file_url).html('<img style="margin:5px 0;display: block;" src="'+file_url+'" >'+file_name).show();
                    } else{
                         $('.input-file:has(.chose-file-active)').find('.preview_file').attr('href',file_url).html('<img style="margin:5px 0;display: block;" src="'+$('meta[name="domain"]').attr('content')+'/'+'filemanager/filemanager/img/ico/'+extension+'.jpg" >'+file_name).show();
                    }

                    var comp = new RegExp( $('meta[name="domain"]').attr('content') );

                    if( comp.test( file_url ) || file_url.substr(0, 8) == '/uploads' ){
                        var value = {link:file_url.substring(file_url.indexOf("uploads")),type_link:'local',type_file:extension,'file_name':file_name,'is_image':is_image};
                    }else{
                        var value = {link:file_url,type_link:'external',type_file:extension,'file_name':file_name,'is_image':is_image};
                    }


                    
                }else{
                    $('.input-file:has(.chose-file-active)').find('.preview_file').attr('href',$('#filemanager_file_chose').val()).hide();

                    var value = '';
                }

                value = JSON.stringify(value);
                warpper = $('.input-file:has(.chose-file-active)').find('textarea').val(value).trigger('change');

                $('.input-file .chose-file-active').removeClass('chose-file-active');

                $('.modal-wapper-add-file').hide();

            });
            $('body').on('click', '#add-file-btn-cancel, .add-file-btn-close', function(event) {
                event.preventDefault();
                $('.modal-wapper-add-file').hide().removeClass('input-file-active');

            });

            window.filemanager_title_file = function(){
                return 'Insert/Edit File';
            }
            // End Asset File


            // Begin Image
            window.is_url  = function(str) {
               var regexp = /^(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
               return regexp.test(str);
            }
            
            

            window.show_form_image_multiable = function(){

                 $('.input-image-warpper.multi-able').each(function(index,el){
                    var json = JSON.parse($(el).find('textarea.image-result').val());
                    element = $(el).find('.image_preview ');
                    if( Array.isArray(json) ){
                        element.empty();
                        for (var j = 0; j < json.length; j++) {
                            // if( json.images[j].type_link == 'local' ){
                            //  link = "{!!url('/')!!}/"+json.images[j].link;
                            // }else{
                            //  link = json.images[j].link;
                            // }

                            if( !is_url(json[j].link) ){
                                link = $('meta[name="domain"]').attr('content') + "/"+json[j].link;
                            }else{
                                link = json[j].link;
                            }

                            element.append('<div class="item-image-resutl"><img data-width="'+json[j].width+'" data-height="'+json[j].height+'" src="'+link+'" class="type-image-'+json[j].type_link+'" alt=""><span class="stt">'+(j + 1)+'</span></div>')
                        };
                    }else{
                        if( json != null ){
                            element.empty();
                            if( !is_url(json.link) ){
                                link =  $('meta[name="domain"]').attr('content') + "/"+json.link;
                            }else{
                                link = json.link;
                            }
                            element.append('<div class="item-image-resutl"><img data-width="'+json.width+'" data-height="'+json.height+'" src="'+link+'" class="type-image-'+json.type_link+'" alt=""><span class="stt">1</span></div>')
                        }
                    }
                });

            }
            show_form_image_multiable();

           

            //End Multiple Image


            window.after_chose_image_filemanager = function(field_id){

                if( !window._data_validate_img.multi ){
                    var url=jQuery('#'+field_id).val();

                     validate_image( url , window._data_validate_img, function($result){

                        if( !$result ){

                            $('#'+field_id).val('');
                            $('#filemanager-wapper').fadeIn();  
                            
                        }else{
                            if( !window._data_validate_img.multi ){
                                $('#filemanager-wapper').fadeOut();
                            }else{
                                return url;
                            }
                        }

                     } );
                }
            };


            window._data_validate_img = false;

            $('body').on('click', '.button_add_img_tiny ', function(event) {

                window._data_validate_img = $(this).data();
                event.preventDefault();

                $('.modal-wapper-add-image').show();
                $(this).closest('.input-image-warpper').addClass('input-image-active');

                $('#image_link').val('');
                $('#image_link').focus();

            });

            function create_thumbnail_image(value, $el){

                show_loading('Create Thumbnail');

                $.ajax({
                    url: $('meta[name="url_create_thumbnail"]').attr('content'),
                    type:'POST',
                    dataType:'json',
                    data:{
                        _token:$('#laravel-token').val(),
                        value: value,
                        data: $el.data('thumbnail')
                    },
                    success:function(data){
                        if( data.value ){
                            value = JSON.stringify(data.value);
                            $el.css({'border-radius':'50%'});
                            $el.find('textarea').val(value).trigger('change');
                        }

                        hide_loading();
                    }
                })

            }

            $('body').on('click', '#add-image-btn-ok', function(event) {

                event.preventDefault();

                if( window._data_validate_img.multi ){

                    event.stopPropagation();
                    
                    var value = $('#image_link').val();

                    if( is_url(value) ){
                        value = [value];
                    }else{
                        if( value !== '' ){

                            value = JSON.parse(value);

                        }else{
                            value = [];
                        }
                    }
                    
                    validate_image_multi(value,function(){
                        upload_input_image_multi( $('.input-image-warpper.input-image-active:first') );
                        $('#add-image-btn-cancel').trigger('click');
                        window.__list_image_multi_checked = false;
                        window.__list_image_multi_checked_i = -1;
                        window._is_edit_image = false;
                    });
                    
                }else{
                    if( is_url($('#image_link').val())  ){

                        $('.modal-wapper-add-image').hide();

                        validate_image( $('#image_link').val() , window._data_validate_img, function($result, $src){

                            if( $result ){
                                var comp = new RegExp( $('meta[name="domain"]').attr('content') );
                                var value = $src;

                                let url = $('#image_link').val();
                                
                                if( comp.test( url ) || url.substr(0, 8) == '/uploads' ){
                                   value = {'link':value.substring(value.indexOf("uploads")),'type_link':'local', width: $result.width, height : $result.height };
                                }else{
                                   value = {'link':value,'type_link':'external', width: $result.width, height : $result.height };
                                }

                                if( $('.input-image-warpper.input-image-active:first').data('thumbnail') ){
                                    create_thumbnail_image(value,$('.input-image-warpper.input-image-active:first'));
                                }

                                value = JSON.stringify(value);

                                $('.input-image-warpper.input-image-active:first textarea').val(value).trigger('change');
                                $('.input-image-warpper.input-image-active:first .image_preview').html('<div class="item-image-resutl"><img data-width="'+$result.width+'" data-height="'+$result.height+'" src="'+$('#image_link').val()+'" alt=""></div>');

                                $('.input-image-warpper.input-image-active').removeClass('input-image-active');

                            }else{
                                $('#image_link').val('');
                                $('.modal-wapper-add-image').show();
                            }
                        });

                    }else{

                        $('#add-image-btn-cancel').trigger('click');

                    }
                    window._is_edit_image = false;
                }
                
            });


            responsive_filemanager_callback_multi  = function(field_id, callback){

                $('#filemanager-wapper').fadeOut();
                callback();

            };

            window.validate_image_multi = function(value, callback){

                if( !window.__list_image_multi_checked ){
                    window.__list_image_multi_checked = [];
                    window.__list_image_multi_checked_i = 0;
                }

                if( __list_image_multi_checked_i < value.length ){

                    validate_image(value[__list_image_multi_checked_i], window._data_validate_img, function(result, src){

                        if( result ){
                            __list_image_multi_checked.push({src : src, width: result.width, height: result.height});
                        }

                        window.__list_image_multi_checked_i ++;

                        validate_image_multi(value,callback);
                    });

                }else{
                    // console.log(__list_image_multi_checked_i);

                    for( var i = 0 ; i < __list_image_multi_checked.length ; i ++ ){

                        $('.input-image-warpper.input-image-active:first .image_preview .noImageSelected').remove();

                        if( !window._is_edit_image ){
                            $('.input-image-warpper.input-image-active:first .image_preview').append('<div class="item-image-resutl"><img data-width="'+__list_image_multi_checked[i].width+'" data-height="'+__list_image_multi_checked[i].height+'" src="'+__list_image_multi_checked[i].src+'" alt=""></div>');
                        }else{
                            window._is_edit_image = false;
                            $('.input-image-warpper.input-image-active:first .image_preview .item-image-resutl.active img:first').attr('data-width',__list_image_multi_checked[i].width).attr('data-height',__list_image_multi_checked[i].height).attr('src',__list_image_multi_checked[i].src).closest('.active').removeClass('active');
                        }           

                    }

                    callback();

                    
                }

            };

            $('body').on('click', '#add-image-btn-cancel, .add-image-btn-close', function(event) {
                event.preventDefault();
                $('.modal-wapper-add-image').hide();
                $('.input-image-warpper.input-image-active:first .image_preview .item-image-resutl.active').removeClass('active');
                $('.input-image-warpper.input-image-active').removeClass('input-image-active');

            });

            window.upload_input_image_multi  = function( element_warpper ){

                var listImage = element_warpper.find('.item-image-resutl');

                var listImageJson = [];

                var comp = new RegExp( $('meta[name="domain"]').attr('content') );

                listImage.each(function(index, el) {

                    $(el).find('.stt').remove();
                    $(el).append('<span class="stt" >'+(index + 1)+'</span>');

                    let Url = $(el).find('img').attr('src'),width = $(el).find('img').attr('data-width'), height = $(el).find('img').attr('data-height');

                    if( comp.test( Url ) || Url.substr(0, 8) == '/uploads' ){
                        $(el).addClass('local-link');
                       value = {'link':Url.substring(Url.indexOf("uploads")),'type_link':'local', width: width, height: height};
                    }else{
                        $(el).addClass('external-link');
                       value = {'link':Url,'type_link':'external', width: width, height: height};
                    }


                    listImageJson.push(value);
                });

                value = JSON.stringify(listImageJson);

                element_warpper.find('textarea').val(value).trigger('change');


            };

            

            function edit_img($this){
                $this.closest('.input-image-warpper').find('.button_add_img_tiny').trigger('click');

                $('#image_link').val($this.closest('.item-image-resutl').find('img').attr('src'));

                window._is_edit_image = true;

                $this.closest('.item-image-resutl').addClass('active');

                $('.modal-wapper-add-image').show();

                $this.closest('.input-image-warpper').addClass('input-image-active');
            }

            

            $(document).on("mouseenter", ".item-image-resutl:has(img)", function() {

                var data_size = $(this).closest('.input-image-warpper').data('size');

                var url = $(this).find('img').eq(0).attr('src');

                var $str = '<div class="action-image" style="text-align:right;"><a href="'+url+'" title="'+$('#text-download').val()+'" download><i class="fa fa-cloud-download download" aria-hidden="true"></i></a><i title="'+$('#text-edit').val()+'" class="fa fa-pencil edit-img load-filemanager" data-type="1" data-field-id="image_link" aria-hidden="true"></i><i title="'+$('#text-remove').val()+'" class="fa fa-times remove" aria-hidden="true"></i>';

                $str += '</div>';
                $(this).append($str);

            }).on("mouseleave", ".item-image-resutl:has(img)", function() {
                $(this).find('.action-image').remove();
            });

            $('body').on('click', '.noImageSelected', function(event) {
                event.preventDefault();
                $(this).closest('.input-image-warpper').find('.load-filemanager').trigger('mouseover');
                $(this).closest('.input-image-warpper').find('.button_add_img_tiny').trigger('click');
            });

            $('body').on('click','.action-image',function(){
                event.preventDefault();
                event.stopPropagation();
            });

            $('body').on("click", ".item-image-resutl .action-image .fa-cloud-download ", function(event) {
                event.stopPropagation();
            });
            $('body').on("click", ".item-image-resutl .action-image .remove", function(event) {

                event.stopPropagation();

                var warpper = $(this).closest('.input-image-warpper');

                var multi = warpper.find('.button_add_img_tiny').data('multi');

                $(this).closest('.item-image-resutl').remove();

                if( multi ){

                    if( warpper.find('.item-image-resutl').length < 1){
                        warpper.find('.image_preview').html('<div class="noImageSelected emptyButton" style="display:block;">No image selected<input type="file" class="filemanager_uploadfile_direct" ></div>');
                    }

                    upload_input_image_multi(warpper);
                }else{  
                    warpper.find('.image_preview').html('<div class="noImageSelected emptyButton" style="display:block;">No image selected<input type="file" class="filemanager_uploadfile_direct" ></div>');
                    warpper.find('textarea').val('').trigger('change');

                }

            });

            $('body').on('click', '.edit-img, .default_input_img_result .item-image-resutl', function(event) {

                event.preventDefault();

                edit_img($(this));

            });

            $(document).on('change','.filemanager_uploadfile_direct',function(){

                $this = $(this);
                $this.closest('.input-image-warpper').addClass('input-image-active');
                window._data_validate_img = $this.closest('.input-image-warpper').find('.button_add_img_tiny').data();

                if (this.files && this.files[0]) {

                    for (var i = this.files.length - 1; i >= 0; i--) {

                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $this.closest('.image_preview').append('<div class="image-preview-before-upload"><img data-width="'+e.width+'" data-height="'+e.height+'" src="' + e.target.result +'"><div class="processing"></div></div>');
                        };

                        reader.readAsDataURL(this.files[i]);

                    };
                    
                  }

                var formData = new FormData();

                for (var i = $(this)[0].files.length - 1; i >= 0; i--) {
                    formData.append('file['+i+']',$(this)[0].files[i]);
                };
                formData.append('_token', $('#laravel-token').val());
                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function(evt) {
                          if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);

                            $this.closest('.image_preview').find('.image-preview-before-upload .processing').css({'width':percentComplete+'%'});
                          }
                        }, false);

                        return xhr;
                      },
                    url: $('meta[name="url_filemanagerUploadFileDirect"]').attr('content'),
                    type:'POST',
                    dataType:'json',
                    data:formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        var percentVal = '0%';
                        console.log(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                       var percentVal = percentComplete + '%';
                        console.log(percentVal);
                    },
                    success:function(data){
                        $this.val('');
                        $this.closest('.input-image-warpper').find('.image-preview-before-upload').remove();

                        if( _data_validate_img.multi ){

                            validate_image_multi(data.files,function(){
                                upload_input_image_multi( $('.input-image-warpper.input-image-active:first') );
                                $('#add-image-btn-cancel').trigger('click');
                                window.__list_image_multi_checked = false;
                                window.__list_image_multi_checked_i = -1;
                                window._is_edit_image = false;
                            });

                        }else{
                            check_image_after_upload_direct(data.files,0);
                        }
                    }

                });


            });

            function check_image_after_upload_direct(files, index){
                if( index >= files.length ) return;

                validate_image( files[index] , window._data_validate_img, function($result, $src){

                    if( $result ){

                        var comp = new RegExp($('meta[name="domain"]').attr('content'));

                        var value = $src;

                        let url = $('#image_link').val();

                        if( comp.test( url ) || url.substr(0, 8) == '/uploads' ){
                           value = {'link':value.substring(value.indexOf("uploads")),'type_link':'local', width: $result.width, height: $result.height};
                        }else{
                           value = {'link':value,'type_link':'external', width: $result.width, height: $result.height};
                        }

                        value = JSON.stringify(value);

                        $('.input-image-warpper.input-image-active:first textarea').val(value).trigger('change');
                        $('.input-image-warpper.input-image-active:first .image_preview').html('<div class="item-image-resutl"><img data-width="'+$result.width+'" data-height="'+ $result.height+'" src="'+$src+'" alt=""></div>');

                        $('.input-image-warpper.input-image-active').removeClass('input-image-active');

                    }else{
                        check_image_after_upload_direct(files,index + 1);
                    }
                });
            }

            window.validate_image = function($src, $param, $callback){

                 var img = new Image;
                 img.src= $src ;

                 img.onload=function(){

                    var str = '';

                    if($param['ratio']){

                        $arryRatio = $param['ratio'].split('x');

                        $ratioResult = Math.round($arryRatio[0]/$arryRatio[1] * 1000) / 1000;                                          

                        if( this.width/this.height != $ratioResult ){
                            str = '     Tỉ lệ hình ảnh không đúng '+$param['ratio']+'\n' ;
                        }

                    }
                    if( $param['width'] && this.width != parseInt($param['width']) ){
                        str = str+'     image width != '+$param['width']+'\n';
                    }
                  

                    if( $param['maxWidth'] && this.width > parseInt($param['maxWidth']) ){
                        str = str + '     image max width < '+ $param['maxWidth'] +'\n';
                    }

                    if( $param['minWidth'] && this.width < parseInt($param['minWidth']) ){
                        str = str + '     image min width > '+$param['minWidth']+'\n';
                    }

                    if( $param['height'] && this.height != parseInt($param['height']) ){
                        str = str + '     image height != '+$param['height']+'\n';
                    }

                    if( $param['maxHeight'] && this.height > parseInt($param['maxHeight']) ){
                        str = str + '     image max height < '+$param['maxHeight']+'\n';
                    }

                    if( $param['minHeight'] && this.height < parseInt($param['minHeight']) ){
                        str = str + '     image min height > '+$param['minHeight']+'\n';
                    }   

                    if(str){
                        alert($src + '\nError Info: \n' + str);
                        $result = false;
                    }else{
                        $result = { width: this.width, height: this.height };
                    }

                    if( $callback ){
                        $callback($result, $src) ;
                    }

                    $result;
                };
            };
            // End Image


            var script = document.createElement('script');
            
            script.onload = function () {

                $( ".input-repeater .list-input" ).sortable({
                    handle:'.x_title',
                    stop:function(event, ui){
                        ui.item.attr('style','');
                    },
                    start:function(event,ui){
                        ui.placeholder.height(ui.item.height() - 4);
                    },
                    update: function(event, ui) {
                        udpateNumberPositionRepeater($(ui.item[0]).closest('.input-repeater'));
                    },
                });

                $( ".input-flexible .list-box" ).sortable({
                    handle:'.flexible-title',
                    stop:function(event, ui){
                        ui.item.attr('style','');
                    },
                    update: function(event, ui) {
                        udpateNumberPositionFlexible($(ui.item[0]).closest('.input-flexible'));
                    },
                });


               $( ".multi-able .image_preview" ).sortable({
                    stop:function(event, ui){
                        ui.item.attr('style','');
                    },
                    update: function(event, ui) {
                        upload_input_image_multi($(this).closest('.multi-able'));
                    },
                    create:function(event, ui){
                        // fortmatImageMulti();
                    }

                });
            };

            script.src = $('meta[name="domain"]').attr('content')+'/admin/js/jquery-ui.min.js';

            document.head.appendChild(script);



            //Input Link
            $(document).on('click','.open-popup-input-link',function(event){
                $('.input-link-parent').removeClass('active-moment');
                $(this).closest('.input-link-parent').addClass('active-moment');
            });
            //END Input Link
            setTimeout(function() {
                $('img[data-src]').each(function(index, el){
                    $(el).attr('src',$(el).data('src'));
                });
            }, 10);

            $(document).on('click','.session-message, .menu-left li,.menu-top a,.setting-item .item-warper,#sidebar-menu li a,.dropdown-toggle label,.vn4-btn,#newfeed div,.dropdown, .dropdown-toggle, .advance-feature li',function(e){

                let parentOffset = $(this).parent().offset(); 
                //or $(this).offset(); if you really just want the current element's offset
                alpha = 0.5;

                var color = $(this).css("color");
                var sub = color.slice(0,-1).replace("rgb","rgba");
                color = sub+ ", "+alpha+")";
                var offset = $(this).offset();
                x = event.pageX- offset.left;
                y = event.pageY- offset.top;

                $(this).css({'position':'relative','z-index':'1'});

                let element_parent = $('<div style="position:absolute;top:0;left:0;right:0;bottom:0;overflow:hidden;"></div>');
                let element = $('<span style="z-index:0;display:inline-block;position:absolute;transform: translate(-50%,-50%);width:0;opacity:0.7;height:0;top:'+y+'px;left:'+x+'px;background:'+color+';z-index:0;border-radius:50%;"></span>');
                element_parent.append(element);
                $(this).append(element_parent);

                element.animate({width: $(this).width()*4, height: $(this).width()*4,opacity:0},550,function(){
                    element_parent.remove();
                });
                
            });

            window.update_after_add = [];
        });
    }
