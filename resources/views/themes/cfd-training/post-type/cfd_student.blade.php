@extends(theme_extends())

<?php 

	title_head('Profile');

    $account = check_login_frontend();

    $isMyProfile = $account && $account->id == $post->id;

    if( !$isMyProfile ){
        return vn4_redirect(route('index'));
    }

    $currentTab = Request::get('tab');

    $tabs = ['thong-tin'=>1,'khoa-hoc'=>1,'du-an'=>1,'lich-su-thanh-toan'=>1, 'quan-ly-coin'=>1];

    $list_trang_thai = ['cho-xet-duyet'=>['title'=>'Chờ xác nhận','color'=>'red'],'duoc-duyet'=>['title'=>'Đã xác nhận','color'=>'#00afab'],'khong-duoc-duyet'=>['title'=>'Không được duyệt','color'=>'black']];


    $messages = Session::get('messages');

    if( $messages ){
        $messages = $messages->messages();
    }
    else $messages = [];


    function getMessage($messages, $key){

        $str = '';
        if( isset($messages[$key]) ){
            foreach ($messages[$key] as $v) {
                $str .= '<p class="mess-error">'.$v.'</p>';
            }
        }

        return $str;

    }

    if( $isMyProfile ){

        $key = "cfdtraining_api_link_gioi_thieu";

        $time = time();

        $payload = $post->id;

        $token = \Firebase\JWT\JWT::encode($payload, $key);

        $registers = $post->related('cfd_course_register','cfd_student',['callback'=>function($q){
            $q->whereIn('trang_thai',['duoc-duyet','cho-xet-duyet']);
        }]);

        $da_gioi_thieu = $post->related('cfd_course_register','nguoi_gioi_thieu',['callback'=>function($q){
            $q->where('trang_thai','duoc-duyet');
        }]);


        $coin_history = $post->related('cfd_coin_history');

    }



 ?>


@section('content')

 <main class="profile" id="main">
    <section class="pd">
        <div class="top-info">
            <div class="avatar thumbnail">

                <?php $img = get_media($post->avatar);  ?>


                @if( $img )
                <img data-src="{!!$img!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt="">
                @else

                <?php 
                    $text = explode('-',str_slug($post->title));
                 ?>
                <span class="text">{!!strtoupper(substr(end($text), 0, 1))!!}</span>
                <img src="@theme_asset()img/thumb-member.jpg" alt="">
                @endif

                <input type="file" style="display: none;">
                <div class="camera"></div>
            </div>
            <div class="name">{!!$post->title!!}</div>

            @if($isMyProfile)
            <p class="des">{!!$post->email!!}</p>
            @else

            <?php 
                $a = strpos($post->email, '@');

                $before = substr($post->email, 0, $a);

                $after = substr($post->email, $a);

             ?>
            <p class="des">{!!substr($before, 0 , strlen($before) - 5 ),'...' ,$after!!}</p>
            @endif
        </div>
        <div class="container">
            <div class="tab">

                <div class="tab-title">

                    @if( $isMyProfile )
                    <a href="#" @if( !$currentTab ) class="active" @endif>Thông tin tài khoản</a>
                    <a href="#" @if( $currentTab == 'khoa-hoc' ) class="active" @endif>Khóa học của tôi</a>
                    <a href="#" @if( $currentTab == 'du-an' ) class="active" @endif>Dự án của tôi</a>
                    <a href="#" @if( $currentTab == 'lich-su-thanh-toan' ) class="active" @endif>Lịch sử thanh toán</a>
                    <a href="#" @if( $currentTab == 'quan-ly-coin' ) class="active" @endif>Quản lý COIN</a>
                    @else
                    <a href="#" class="active">dự án của bạn</a>
                    @endif

                    

                </div>

                <div class="tab-content">



                    @if( $isMyProfile )
                    <div class="tab1" @if( isset($tabs[$currentTab]) ) style="display: none;" @endif >
                        <form action="{!!route('post',['account','edit'])!!}" method="POST">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <label>
                                    <p>Họ và tên<span>*</span></p>

                                    <input type="text" name="title" value="{!!$post->title!!}">
                                    {!!getMessage($messages, 'title')!!}
                            </label>

                            <label>
                                    <p>Số điện thoại<span>*</span></p>

                                    <input type="text" name="phone" value="{!!$post->phone!!}">
                                    {!!getMessage($messages, 'phone')!!}
                            </label>

                            <label>

                                    <p>Email<span>*</span></p>
                                    <input value="{!!$post->email!!}"  disabled type="text">
                                    {!!getMessage($messages, 'email')!!}

                            </label>

                            <label>
                                    <p>Facebook<span>*</span></p>

                                    <input type="text" name="facebook" placeholder="Facebook url" value="{!!$post->facebook!!}">
                                    {!!getMessage($messages, 'facebook')!!}
                            </label>

                            <label>
                                    <p>Skype</p>

                                    <input type="text" name="skype" placeholder="Skype url"  value="{!!$post->skype!!}">
                                    {!!getMessage($messages, 'skype')!!}
                            </label>

                             <label class="flex-start">
                                    <p>Cảm nhận về CFD</p>
                                    <textarea name="review" placeholder="Cảm nhận về CFD">{{$post->review}}</textarea>
                                    {!!getMessage($messages, 'review')!!}
                            </label>

                            @if( $account->related('cfd_course_register','cfd_student',['count'=>true, 'callback'=>function($q) { $q->where('trang_thai','duoc-duyet'); }]))
                             <label class="flex-start">
                                    <p>Link giới thiệu</p>
                                    <div class="affiliate_token">
                                        <div class="inputtext">
                                            <input type="text" value="{!!route('post',['controller'=>'affiliate','method'=>'set','affiliate_token'=>$token])!!}" class="link" id="tokenlink">
                                            <div class="copy">Copy</div>
                                        </div>
                                        <p class="note">*Copy đường dẫn và gửi người khác đăng ký khóa học bất kỳ để bạn tích lũy COIN và CFD ưu đãi học phí cho người được bạn giới thiệu.</p>
                                    </div>
                            </label>
                            @endif


                            <div class="btn main rect btn-save">LƯU LẠI</div>
                        </form>
                    </div>

                    <div class="tab2" @if( $currentTab != 'khoa-hoc' ) style="display: none;" @endif >

                        <?php
                            // $courses = $post->relationship('cfd_course',['count'=>6,'paginate'=>'page','order'=>['opening_time','desc']]);


                            $status = ['da-ket-thuc'=>['title'=>'Đã kết thúc','color'=>'#797979'],'dang-dien-ra'=>['title'=>'Đang diễn ra','color'=>'#f4744b'],'sap-khai-gian'=>['title'=>'Sắp khai giảng','color'=>'#ec5c6c']];
                        ?>


                        @forelse($registers as $r)

                        <?php 
                            // if( $c->trang_thai !== 'duoc-duyet' ) continue;


                            $c = get_post('cfd_course',$r->cfd_course);
                            $now = time(); // or your date as well

                            $opening_time = strtotime($c->opening_time);
                            $close_time = strtotime($c->close_time);
                            $days = round(($close_time - $opening_time) / (60 * 60 * 24));

                            $datediff = $now - $opening_time;
                            // dd($datediff);

                            if( $datediff > 0 ){
                                $day = round($datediff / (60 * 60 * 24));
                            }else{
                                $day = 0;
                            }

                            $content = json_decode($c->content,true);

                            $precent = $day * 100 / $days;

                            if( $precent > 100 ) $precent = 100;

                         ?>
                        <div class="item">
                            <a href="{!!$link = get_permalinks($c)!!}">
                                <div class="cover">
                                    
                                    @if( $c->course_status )
                                    <span class="badge b1" style="background: {!!$status[$c->course_status]['color']!!}">{!!$status[$c->course_status]['title']!!}</span>
                                    @endif

                                    @if( $r->trang_thai == 'cho-xet-duyet' )
                                    <span class="badge b4">Đang chờ xét duyệt</span>
                                    @endif

                                    <img data-src="{!!get_media($c->thubnail)!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt="">
                                    
                                </div>
                            </a>

                            <div class="info">

                                <a href="{!!$link!!}" class="name">{!!$c->title!!}</a>

                                <div class="date">Khai giảng ngày {!!get_date($c->opening_time)!!}</div>

                                <div class="row">

                                    <div class="">

                                        <img src="@theme_asset()img/clock.svg" alt="" class="icon">{!!count($content)??8!!} buổi

                                    </div>


                                    <div class=""><img src="@theme_asset()img/user.svg" alt="" class="icon">{!!$c->related('cfd_course_register','cfd_course',['count'=>true])??5!!} học viên</div>
                                    <!-- <div class=""><img src="@theme_asset()img/user.svg" alt="" class="icon">Học phí {!!number_format($r->money)!!}VNĐ</div> -->

                                </div>

                                <div class="process">

                                    <div class="line">

                                        <div class="rate" style="width: {!!$precent!!}%"></div>

                                    </div>
                                    {!!intval($precent) !!}%

                                </div>

                    
                                @if( $c->course_status == 'da-ket-thuc' )
                                <a href="{!!$link!!}" class="btn overlay round btn-continue">Xem lại</a>
                                @elseif( $c->course_status == 'dang-dien-ra' )
                                <a href="{!!$link!!}" class="btn overlay round btn-continue">Tiếp tục học</a>
                                @else
                                <a href="{!!$link!!}" class="btn overlay round btn-continue">Chi tiết</a>
                                @endif

                            </div>

                        </div>
                        @empty
                            <p>Bạn chưa đăng ký khóa học.</p>
                        @endforelse

                    </div>

                    <div class="tab3" @if( $currentTab != 'du-an' ) style="display: none;" @endif >


                            <?php
                                $projects = $post->related('cfd_project','cfd_student',['count'=>6,'paginate'=>'page']);
                            ?>

                            @if( isset($projects[0]) )
                            <div class="row">
                                 @foreach($projects as $p)
                                {!!get_single_post($p)!!}
                                @endforeach
                            </div>
                            @else
                                <p>Bạn chưa đăng dự án đã làm.</p>
                            @endif
                    </div>

                    <div class="tab4" @if( $currentTab != 'lich-su-thanh-toan' ) style="display: none;" @endif>

                      
                        @forelse($registers as $p)

                        <?php
                            $course = $p->relationship('cfd_course');

                            $payments = json_decode($p->payment,true);

                        ?>

                        @if($course)

                        @forif($payments as $c)
                        <div class="itemhistory">

                            <div class="name">{!!$course->title!!}</div>

                            <div class="date">{!!get_date($c['date'])!!}</div>

                            <div class="money">{!!number_format($c['money'])!!} VND</div>

                        </div>
                        @endforif

                        @endif
                        
                         @empty
                         <p>Chưa thanh toán.</p>
                        @endforelse
                    </div>

                    <div class="tab5 cointab" @if( $currentTab != 'quan-ly-coin' ) style="display: none;" @endif style="display: block;">
                            <div class="coininfo">
                                <div class="coininfo__box">
                                    <h3><strong>Thông tin COIN</strong></h3>
                                    <div class="coininfo__box-ct">
                                        <div>
                                            <img src="@theme_asset()img/cfd-coin.png" alt="">
                                            <p>Bạn có <strong>{!!$post->total_coin_current??0!!}</strong> COIN</p>
                                        </div>
                                    </div>
                                </div>
                                @if($post->so_lan_duoc_doi_card_con_lai > 0 )
                                <div class="coininfo__box" id="doi_coin_form">
                                    <h3><strong>Đổi COIN</strong></h3>
                                    <div class="coininfo__box-ct  ">
                                        <?php 
                                            $gift_coin = theme_options('gift_coin','gift');
                                         ?>

                                         @foreach($gift_coin as $index => $g)
                                         @if(!$g['delete'])
                                        <label class="checkcontainer">
                                            {!!$g['label']!!}
                                            <input type="radio" value="{{json_encode(['index'=>$index, 'value'=>$g])}}" name="gif_type">
                                            <span class="checkmarkradio"></span>
                                        </label>
                                        @endif
                                        @endforeach

                                        <small><i>*Bạn có thể đổi COIN 1 lần</i></small>
                                        <p class="mess-error"></p>
                                    </div>
                                    <a href="javascript:void(0)" class="btn main btn_doi_coin">Đổi COIN</a>

                                </div>
                                @endif
                            </div>
                            <div class="coinhistory">
                                <h3><strong>Lịch sử COIN</strong></h3>
                                <!-- <p>Chưa sử dụng COIN</p> -->

                                <div class="itemhistory">
                                    <div class="td"><strong>COIN</strong></div>
                                    <div class="td"><strong>Thời gian</strong></div>
                                    <div class="td"><strong>Nội dung</strong></div>
                                    <div class="td"><strong>Trạng thái</strong></div>
                                </div>
                                 @foreach($coin_history as $history)
                                <div class="itemhistory">
                                    <div class="td"><span class="coin @if( $history->coin < 0 ) red @endif ">@if( $history->coin > 0 )+@endif{!!$history->coin!!}</span></div>
                                    <div class="td">{!!$history->date!!}</div>
                                    <div class="td">{!!$history->title!!}</div>
                                    <div class="td" style="color: {!!@$list_trang_thai[$history->trang_thai]['color']!!};">{!!@$list_trang_thai[$history->trang_thai]['title']!!}</div>
                                </div>
                                @endforeach

                            </div>
                        </div>

              

                    @else
                    <div class="tab3">
                        <div class="row">
                            <?php
                                $projects = $post->related('cfd_project','cfd_student',['count'=>6,'paginate'=>'page']);
                            ?>
                            @forelse($projects as $p)
                            {!!get_single_post($p)!!}
                             @empty
                             <p>Chưa cập nhật.</p>
                            @endforelse
                        </div>
                    </div>
                    @endif


                </div>

            </div>
        </div>
    </section>
</main>

@stop


@section('js')
      <script type="text/javascript">

      $('.btn-save').on('click',function(){
        $(this).closest('form').submit();
      });

       function readURL(input, callback) {
          if (input.files && input.files[0]) {

            var reader = new FileReader();
            
            reader.onload = callback
            
            reader.readAsDataURL(input.files[0]); // convert to base64 string
          }
        }


        document.addEventListener("DOMContentLoaded", function(event) { 
          $('.thumbnail img').on('click', function(){
                $('.thumbnail input').click();
          });

          $('.btn_doi_coin').on('click',function(){

            if( !$('input[name=gif_type]:checked', '#doi_coin_form').val() ){
                $('#doi_coin_form .mess-error').text('Vui lòng chọn phần quà bạn muốn đổi.');
            }else{
                $.ajax({
                    url: '{!!route('post',['controller'=>'account','method'=>'doi-coin'])!!}',
                    method: "POST",
                    type: "POST",
                    cache: false,
                    data: {
                        _token: '{!!csrf_token()!!}',
                        gif: $('input[name=gif_type]:checked', '#doi_coin_form').val()
                    },
                    success:function(result){
                        if( result.success ){
                            window.location.href = '{!!get_permalinks($post)!!}?tab=quan-ly-coin';
                        }

                        if( result.message ){
                            $('#doi_coin_form .mess-error').text(result.message);
                        }else{
                            $('#doi_coin_form .mess-error').text('');
                        }

                        if( result.error ){
                            alert(result.error);
                        }
                    }
                });
            }
          });

            $(".thumbnail input").change(function() {
                var file, img, input = this;
                let _URL = window.URL || window.webkitURL;

                if ((file = this.files[0])) {
                    img = new Image();
                    let objectUrl = _URL.createObjectURL(file);
                    img.onload = function () {

                        // if(this.width === this.height){
                            readURL(input, function(e){

                                var token = "{!!csrf_token()!!}";

                                $.ajax({
                                    url: '{!!route('post',['controller'=>'account','method'=>'upload-avatar'])!!}',
                                    method: "POST",
                                    type: "POST",
                                    cache: false,
                                    data: {
                                        _token: '{!!csrf_token()!!}',
                                        data: e.target.result
                                    },
                                    success:function(result){
                                        if( result.success ){
                                            window.location.reload();
                                            
                                            $('.thumbnail img').attr('src',result.url);
                                        }
                                        if( result.error ){
                                            alert(result.error);
                                        }
                                    }
                                });
                            });
                        // }else{
                        //     alert('Please upload image 150 x 150');
                        // }
                        _URL.revokeObjectURL(objectUrl);
                    };
                    img.src = objectUrl;

                    
                }
                
            }); 
        });


    </script>
@stop