<?php
    $active_menu = $GLOBALS['menu-main']??'';
?>

<header id="header">
    <div class="wrap">
        <div class="menu-hambeger">
            <div class="button">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span class="text">menu</span>
        </div>
        <a href="{!!route('index')!!}" class="logo">
            <img src="@theme_asset()img/logo.svg" alt="">
        </a>
        
        <div class="right">

            <?php 
                $account = check_login_frontend();
            ?>

            @if( $account )
            <div class="have-login">
                <div class="account">
                    <a href="#" class="info">
                        <div class="name">{!!$account->title!!}</div>
                        <div class="avatar">


                         <?php $img = get_media($account->avatar,null,'thumbnail-1');  ?>

                            @if( $img )
                            <img data-src="{!!$img!!}" src="@theme_asset()img/thumb-load.jpg" class="lazyload" alt="">
                            @else

                            <?php 
                                $text = explode('-',str_slug($account->title));
                             ?>
                            <span class="text">{!!strtoupper(substr(end($text), 0, 1))!!}</span>
                            <img src="@theme_asset()img/thumb-member.jpg" alt="">
                            @endif



                        </div>
                    </a>
                </div>
                <div class="hamberger">
                </div>

                <div class="sub">
                    <a href="{!!get_permalinks($account)!!}">Thông tin tài khoản</a>
                    <a href="{!!get_permalinks($account)!!}?tab=khoa-hoc">Khóa học của tôi</a>
                    <a href="{!!route('post',['account','logout'])!!}">Đăng xuất</a>
                </div>
            </div>
            @else
            <!-- <div class="not-login @if($active_menu !== 'trang-chu') bg-none @endif"> -->
            <div class="not-login bg-none">
                <a href="javascript:void(0)" class="btn-register btn-open-popup" data-id="login" >Đăng nhập</a>
                <a href="javascript:void(0)" class="btn main btn-open-popup" data-id="register">Đăng ký</a>
            </div>
            @endif
        </div>
    </div>
</header>
<nav class="nav">
    <ul>
       @if( !$account ) 
       <li class="li_login">
            <a href="javascript:void(0)" class="btn-open-popup" data-id="login">Đăng nhập</a>
            <a href="javascript:void(0)" class="btn-open-popup" data-id="register">Đăng ký</a>
        </li>
        @endif

        <li @if( $active_menu == 'trang-chu' ) class="active" @endif> 
            <a href="{!!route('index')!!}">Trang chủ</a>
        </li>
            <li @if( $active_menu == 'khoa-hoc' ) class="active" @endif>
            <a href="{!!route('page','khoa-hoc')!!}">Khóa học</a>
        </li>
        <li @if( $active_menu == 'team' ) class="active" @endif>
            <a href="{!!route('page','cfd-team')!!}">CFD Team</a>
        </li>
        <!-- <li @if( $active_menu == 'du-an' ) class="active" @endif>
            <a href="{!!route('page','du-an')!!}">Dự án</a>
        </li> -->
        <li @if( $active_menu == 'hoi-dap' ) class="active" @endif>
            <a href="{!!route('page','hoi-dap')!!}">Hỏi đáp</a>
        </li>

        <li @if( $active_menu == 'hop-tac' ) class="active" @endif>
            <a href="{!!route('page','hop-tac')!!}">Hợp tác</a>
        </li>
    </ul>
</nav>
<div class="overlay_nav"></div>