@extends(theme_extends())
@section('content')
 <div class="slider-area ">
    <div class="single-slider hero-overly slider-height2 d-flex align-items-center" data-background="{!!get_media($post->background)!!}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap pt-100">
                        <h2>{!!$post->title!!}</h2>
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!!route('index')!!}">@__t('Home')</a></li>
                            <li class="breadcrumb-item"><a href="#">{!!$post->title!!}</a></li> 
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- slider Area End-->
<!-- ================ contact section start ================= -->
<section class="contact-section">
        <div class="container">
            <div class="d-none d-sm-block mb-5 pb-4" id="gmap">

            

            </div>

            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">@__t('Get in Touch')</h2>
                </div>
                <div class="col-lg-8">
                    <form class="form-contact contact_form" action="{!!route('post',['controller'=>'contact','method'=>'post'])!!}" method="post" id="contactForm" novalidate="novalidate">
                        <div class="row">
                           
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid input-title" name="title" id="title" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = '@__t('Enter your name')'" placeholder="@__t('Enter your name')">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid input-email" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = '@__t('Enter email address')'" placeholder="@__t('Email')">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control input-subject" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = '@__t('Enter Subject')'" placeholder="@__t('Enter Subject')">
                                </div>
                            </div>
                             <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100 input-message" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = '@__t('Enter Message')'" placeholder=" @__t('Enter Message')"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="message-success" style="opacity: 0;">@__t('Send contact successful')</p>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">@__t('Send')</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">

                    <?php 
                        $contact_method = $post->{'contact-method'};
                     ?>

                     @forif( $contact_method as $c)
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="{!!$c['icon']!!}"></i></span>
                        <div class="media-body">
                            <h3>{!!$c['title']!!}</h3>
                            <p>{!!$c['description']!!}</p>
                        </div>
                    </div>
                    @endforif

                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script type="text/javascript">
        $(window).load(function(){
            setTimeout(function() {
                $('#gmap').html('{!!$post->{'iframe-map'}!!}');
            }, 10);
        });

        jQuery.validator.addMethod('answercheck', function (value, element) {
            return this.optional(element) || /^\bcat\b$/.test(value)
        }, "type the correct answer -_-");

        // validate contactForm form
        $(function() {
            $('#contactForm').validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 8
                    },
                    subject: {
                        required: true,
                        minlength: 4
                    },
                    number: {
                        required: true,
                        minlength: 5
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    title: {
                        required: "@__t('come on, you have a name, don\'t you?')",
                        minlength: "@__t('your name must consist of at least 2 characters')"
                    },
                    subject: {
                        required: "@__t('come on, you have a subject, don\'t you?')",
                        minlength: "@__t('your subject must consist of at least 4 characters')"
                    },
                    number: {
                        required: "@__t('come on, you have a number, don\'t you?')",
                        minlength: "@__t('your Number must consist of at least 5 characters')"
                    },
                    email: {
                        required: "@__t('no email, no message')",
                        email: "@__t('Please enter a valid email address.')",
                    },
                    message: {
                        required: "@__t('um...yea, you have to write something to send this form.')",
                        minlength: "@__t('thats all? really?')"
                    }
                },
                submitHandler: function(form) {

                    $(form).ajaxSubmit({
                        type:"POST",
                        data: $(form).serialize(),
                        url:$(form).attr('action'),
                        success: function(result) {


                            if( result.message ){
                                alert(result.message);
                            }

                            if( result.error ){

                                for( var key in result.error ){
                                    $(form).find('.input-'+key).after('<label for="message" class="error">'+result.error[key].join('<br>')+'</label>');
                                }

                                return;
                            }else{

                                $('.message-success').css({opacity:1});

                                setTimeout(function() {
                                    $('.message-success').animate({opacity:0});
                                }, 3000);

                                $(form).find(':input').attr('disabled', 'disabled');
                                $(form).fadeTo( "slow", 1, function() {
                                    $(this).find(':input').attr('disabled', 'disabled');
                                    $(this).find('label').css('cursor','default');
                                    $('#success').fadeIn()
                                    $('.modal').modal('hide');
                                    $('#success').modal('show');
                                });
                            }

                            
                        },
                        error: function(xhr, status, error) {
                            

                            

                        }
                    })
                }
            })
        })

    </script>
@stop