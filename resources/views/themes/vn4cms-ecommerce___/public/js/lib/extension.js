function getLocation(callback) {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position){
      callback({lat: position.coords.latitud, lng: position.coords.longitude})
    });
  } else { 
    callback()
  }
}
let selectTemplate = '<div class="select"><div class="head"></div><div class="sub"></div></div>';

(function($) {

    $.fn.fileReview = function(options) {

        // Default options
        var settings = $.extend({
            reviewElement: '.review-file',
            trigger: '.btn-file',
            file: 'input[type="file"]'
        }, options);

        let $inputFile = this.find(settings.file),
            $reviewElement = this.find(settings.reviewElement),
            $trigger = this.find(settings.trigger);


        $inputFile.change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $reviewElement.attr('src', e.target.result);
                };

                reader.readAsDataURL(this.files[0]);
            } else {
                $reviewElement.attr('src', '');
            }

        })

        $trigger.click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $inputFile.click();
        })




        // Apply options
        // return this.append('Hello ' + settings.name + '!');
        return this;

    };



    $.fn.formAjax = function(options) {

        var settings = $.extend({
            trigger: '.btn-send',
            before_send: function(){ return true},
            after_send: function(){ return true},
            validate: function(){ return true},
            error: function(){ return true},
        }, options);

        this.addClass('formAjax');


        let $btnSend = this.find(settings.trigger),
            $require = this.find('.require'),
            self = this;

        $btnSend.click(function(e) {
            // e.stopPropagation();
            e.preventDefault();

            $form = $(this).closest('.formAjax');

            $form.find('.require').map(function(i, e) {
                if (!$(e).val().trim())
                    $(e).attr('placeholder', 'Không được để trống').closest('.input-group').addClass('status-error')
            })

            if ($form.find('.status-error').length === 0 && settings.validate()) {

                // let data = {};

                let data = new FormData();
                $form.find('.data').map(function(i, e){
                    let type = $(e).attr('type');
                    if (type === 'file' && e.files[0]) {
                        data.append($(e).attr('name'), e.files[0]);
                    } else {
                        data.append($(e).attr('name'), $(e).val());
                    }
                })

                data = $.extend(data, settings.data);
                for (let i in settings.data) {
                    data.append(i, settings.data[i]);
                }
                settings.before_send(data);
                return;
                $.ajax({
                    url: $form.attr('action'),
                    data: data,
                    processData: false,
                    contentType: false,
                    method: $form.attr('method') || 'GET',
                    success: settings.success,
                    error: settings.error
                })
                settings.after_send();
            }
        });


        $require.keyup(function() {
            $(this).attr('placeholder', '').closest('.input-group').removeClass('status-error')
        });


        return this;
    }



    $.fn.getData = function(options) {
        let data = {};

        this.map(function(i, e){
            let $form = $(this);
            $form.find('.data').map(function(i, e){
                let type = $(e).attr('type');
                data[$(e).attr('name')] = $(e).val();
            })
        });

        return data;
    }

    $.fn.inputError = function(options) {
        let $error = '<p class="error">' + options + '</p>';
        let $inputGroup = this.hasClass('input-group') ? this : this.closest('.input-group');

        $inputGroup.find('.error').remove();
        $inputGroup.append($error).addClass('status-error');
    }


    $.fn.inputChange = function() {
        let $inputGroup, $input;
        if (this.hasClass('form')) {
            $inputGroup = this.find('.input-group');
        } else {
            $inputGroup = this.hasClass('input-group') ? this : this.closest('.input-group');
        }


        $input = $inputGroup.find('input,select,textarea');

        $input.change(function(e) {
            let $inputGroup = $(this).closest('.input-group');
            if ($inputGroup.hasClass('error')) {
                $inputGroup.removeClass('error').find('p.error').remove();
            }
        })
    }
    
    let deviceSizeDetect = window.innerWidth < 768 ? 'mobile': 'desktop';
    $.resizeChangeDevice = function(mobile,desktop){
        mobile = mobile || false;
        desktop = desktop || false;

        if(mobile && desktop){
            $(window).resize(function(){
                if(window.innerWidth < 768){
                    if(deviceSizeDetect != 'mobile'){
                        mobile();
                        deviceSizeDetect = 'mobile'
                    }
                }else{
                    if(deviceSizeDetect != 'desktop'){
                        desktop();
                        deviceSizeDetect = 'desktop'
                    }
                }
            })
        }
        
    }

    $.fn.hasScrollBar = function() {
        return this.get(0).scrollHeight > this.height();
      }
      $.fn.fakeScrollBar = function(){
        this.removeClass('fake-scrollbar').removeAttr('style')
        this.scrollTop(0)
        
        let scrollHeight = this.get(0).scrollHeight;
        let height = this.height();
        
        if(scrollHeight > height){
          let rate = scrollHeight - height;
          let scrollBarHeight = height / scrollHeight * height;
          let offset = height - scrollBarHeight;

          let scrollTop = this.scrollTop() + (this.scrollTop()/rate)*offset;
          this.addClass('fake-scrollbar').attr('style','--scrollHeight:'+scrollHeight+'px;--scrollbar-height:' + scrollBarHeight + 'px;--scrollbar-top:'+ scrollTop  +'px');
          this.scroll(function(){
            let scrollTop = this.scrollTop() + (this.scrollTop()/rate)*offset;
            if(scrollTop <= scrollHeight - scrollBarHeight){
              this.addClass('fake-scrollbar').attr('style','--scrollHeight:'+scrollHeight+'px;--scrollbar-height:' + scrollBarHeight + 'px;--scrollbar-top:' + scrollTop  + 'px');
            }

          })
        }else{
            this.removeClass('fake-scrollbar').removeAttr('style')
        }
      }

    $.fn.validate = function(options ) {
        options = options || {}
        // let { fields, error, message, before } = options;
        let fields = options.fields || null,
            error = options.error || null,
            message = options.message || null,
            before = options.before || null;


        let _self = this;

        if (!error) {
            error = function(note, $input){
                $input.closest('.form-group').addClass('error').append('<div class="error-note">' + note + '</div>')
            }
        }

        fields = fields || {};
        message = message || {};
        before = before || {};

        let $value = this.find('[name]');

        let response = {};


        this.find('.form-group.error, .form-group .error').removeClass('error').find('.error-note').remove();
        $value.each(function(i, el){
            let $el = $(el),
                val = $el.val().trim(),
                name = $el.attr('name'),
                tagName = $el.prop('tagName'),
                type = $el.attr('type');




            !fields[name] && (fields[name] = {});
            !message[name] && (message[name] = {});

            if (!message[name].required) {
                message[name].required = 'Trường này không được để trống';
            }





            $el.hasClass('required') && (fields[name].required = true);


            if (fields[name].required && !val) {
                error(message[name].required, $el);
                return;
            }

            if (before[name]) {
                val = before[name](val);
            }

            if (pattern = fields[name].pattern) {
                message[name].pattern = message[name].pattern || 'Không đúng pattern';
                let test = pattern.test(val);
                if (!test) {
                    error(message[name].pattern, $el);
                    return;
                }
            }


            if (type === 'radio' || type === 'checkbox') {
                if ($el.is(':checked')) {
                    response[name] = val;
                }
            } else {
                response[name] = val;
            }

        })
        return response;
    }


    $.fn.event = function(options) {
        for (let i in options) {
            // var result = i.match(/(?<={+).*?(?=})/gs);
            var result = i.match(/{.*?}/gi);
            if (result) {
                result = result[0].replace(/{|}/gi, '').trim().split(' ');
                let t = i.replace(/{.*?}/gi, '');
                for (let j in result) {
                    if(t){
                        this.find(t).on(result[j], options[i])
                    }else{
                        this.on(result[j], options[i])
                    }
                    
                }
            } else {
                this.find(i).on('click', options[i])
            }

        }
    }

    let ajaxTemp = $.ajax;
    var ajax = true;

    $.ajax = function(options) {
        let success = options.success;
        // if(typeof options.beforeSend != 'undefined'){
        //     options.beforeSend
        // }


        options = $.extend(options,{
                url: options.url || null,
                method: options.method || 'GET',
                data: options.data || null,
                type: options.type || 'json',
                error: options.error || null,
                success: function(res) {
                    success(res);
                    ajax = true;
                }
            });
        if (ajax) {
            ajax = false;
            ajaxTemp(options)
        }else{
            if(options.soFast){
                options.soFast();
            }
        }
    }

    $.fn.collapse = function(options) {

        // var settings = $.extend({
        //     toggleChecked: false,
        //     checked: false,
        // }, options);

        // this.click(function(e) {
        //     e.preventDefault();
        //     e.stopPropagation();
        //     let $this = $(this);
        //     let toggle = $this.hasClass('toggle') || settings.toggle;

        //     let collChecked = $this.hasClass('coll-checked') || settings.checked;
        //     if (collChecked) {
        //         $this.find('input[type="radio"],input[type="checkbox"]').prop('checked', (_, checked) => { return !checked });
        //     }
        //     if (toggle) {

        //         if ($this.hasClass('active')) {

        //             $this.removeClass('active').next().stop().slideUp();
        //             return;
        //         }
        //     }


        //     if (!$this.hasClass('active')) {
        //         $this.parent().find('.collapse.active').removeClass('active').next().stop().slideUp();
        //         $this.addClass('active').next().stop().slideDown();
        //     }

        // })


        var settings = $.extend({
        }, options);


        this.on('click',function(e){
            e.preventDefault();
            let $this = $(this),
                $sub = $this.next(),
                $parent = settings.$parent || $this.parent();
            
            if($sub.hasClass('slide-show')){
                $parent.find('.active').removeClass('active');
                $parent.find('.slide-show').slideUp(300).removeClass('slide-show');

                
            }else{
               
                $parent.find('.active').removeClass('active');
                $parent.find('.slide-show').slideUp(300).removeClass('slide-show');
                $sub.addClass('slide-show');
                $this.addClass('active');
                $sub.slideDown(300);
            }
        })


        

    }

    $.fn.selectComponent = function(options) {
        var settings = $.extend({
            multi: false,
            placeholder: ''
        }, options);
        this.css({ display: 'none' });

        function renderSelected(obj) {
            let value = obj.value || '', text = obj.text || '';
            return '<span class="i" data-value="' + value + '">' + text + '</span>';
        }

        this.each(function(i, e) {

            let $e = $(e);
            let $wrap = $('<div class="multi-select-wrap">'+
                            '<div class="input-wrap">'+
                                '<div class="selected"></div>'+
                                '<input type="text" placeholder="'+settings.placeholder+'"/>'+
                            '</div>'+
                            '<div class="sub" style="display:none"></div>'+
                        '</div>');


            let $list = $wrap.find('.sub');

            $e.find('option').each(function(_, e2) {
                if (($e2 = $(e2)).val()) {
                    $list.append('<div class="i" data-value="' + $e2.val() + '">' + $e2.text() + '</div>');
                }
            })


            let $selected = $wrap.find('.selected');
            let $sub = $wrap.find('.sub');

            if (($se = $e.find('option:selected')).length > 0) {
                $selected.append(renderSelected({
                    value: $se.val(),
                    text: $se.text()
                }));
                $sub.find('> .i[data-value="' + $se.val() + '"]').css({ display: 'none' });

            }


            $e.after($wrap);

            $wrap.find('input').focus(function() {
                $wrap.find('.sub').css({ display: 'block' });
            }).blur(function() {
                $wrap.find('.sub').fadeOut();
            }).keyup(function(e) {
                let val = this.value.trim();
                if (e.which == 13 && val) {
                    $selected.append(renderSelected({ value: val, text: val }));
                    this.value = '';
                }
            })

            $sub.find('> .i').click(function() {
                $this = $(this);
                console.log('click');
                $this.css({ display: 'none' });
                $selected.append(renderSelected({ value: $this.attr('data-value'), text: $this.text() }));
            })

            $selected.on('click', '.i', function() {
                let $this = $(this).remove();
                $sub.find('> .i[data-value="' + $this.attr('data-value') + '"]').css({ display: 'block' });
            })
        })

    }

     $.fn.select = function(options) {
        var settings = $.extend({
            default: 0,
        }, options);
        
        let _self = this;

        this.each(function(i,e){
            let $this = $(e),
                $item = $this.find('> *'),
                $template = $( selectTemplate );

            $item.addClass('select-item');
            
            $this.addClass('select-extension')
            let $first = $($item[0]);

            $template.find('.head').append($first.clone());
            // $template.find('.head').after("<input class='input' type='text' style='opacity: 0;position:absolute;;height:0;width:0;'/>")
            $template.find('.sub').append($item);
            
            $this.append($template)
            let $sub  = $this.find('.sub');

            $this.event({
                '.head{click}': function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    
                    

                    

                    if($this.hasClass('active')){
                        $this.removeClass('active')
                        $sub.stop().fadeOut(200);
                        // $this.find('.input').blur()
                    }else{
                        $this.addClass('active')
                        $sub.stop().fadeIn(200);
                        // $this.find('.input').focus()
                    }
                    
                    
                },
                // '.input{blur}': function(e){
                //     e.stopPropagation();
                    
                //     $this.removeClass('active');
                //     $sub.stop().fadeOut(200);
                // },
                '.select-item{click}': function(e){
                    let $this = $(this).closest('.select-extension'),
                        $head  = $this.find('.head');

                    $head.html($(this).clone());
                }

            })

            let d = $this.data('default');
            if(d){
                $this.find('.head > *').html(d);
            }


            if(settings.callback){
                settings.callback($this);
            }

            $('body').on('click',function(){
                $this.removeClass('active');
                $sub.stop().fadeOut(200);
            })
            
        })

        

    }


    $.fn.popup = function(options) {
        var settings = $.extend({
            $close: this.find('.close'),
            $open: null,
            open: null,
        }, options);
        let _self = this;

        function close() {
            $('body').removeClass('popup-open')
            _self.removeClass('open').fadeOut(100);
        }


        function open(callback) {

            _self.addClass('open').fadeIn(100);
            $('body').addClass('popup-open');

            if (settings.open) settings.open(settings);
            if (callback) callback();
        }

        settings.$close.on('click', close)


        if (settings.$open && settings.$open.length > 0) {
            settings.$open.on('click', function(e){
                e.stopPropagation();
                e.preventDefault();
                open();
            })
        }

        return {
            close: close,
            open: open
        }

    }


    $.fn.tab = function(options) {

        let _self = this;

        var settings = $.extend({
            $next: null,
            current: 0,
            change: null,
        }, options);

        function next(num, callback) {
            let $list = _self.find('> *');
            if (typeof num === 'undefined') {
                num = settings.current + 1;
            }
            if (num < $list.length) {
                settings.current = num;
            }

            $list.removeClass('active').fadeOut(0).eq(num).fadeIn(100).addClass('active');


            if (settings.change) {
                settings.change(settings)
            }

            if (callback) {
                callback(settings)
            }
        }

        if (settings.$next) {
            settings.$next.on('click', next)
        }


        return { next: next };
    }

}(jQuery));


function readURL(input, callback) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = callback;

        reader.readAsDataURL(input.files[0]);
    } else {

    }
}