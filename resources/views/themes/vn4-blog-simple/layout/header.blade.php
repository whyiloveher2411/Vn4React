<header>
    <div class="container display-between height-full">
        <div class="left display-between">
            <a href="{!!route('index')!!}" class="color-black"><span class="logo" style="font-weight: bold;font-size: 26px;display: inline-block;padding-right: 15px;border-right: 1px solid #eaeaea;"><span style="background: black;border-radius: 4px;color: white;padding: 4px 5px;margin-right: 3px;">Vn4</span>Blog</span></a>
            <a href="" class="color-black"><span class="title" style="padding-left: 15px;font-size: 20px;">{!!@theme_options('definition','title')!!}</span></a>
        </div>
        <div class="right">
            <a href="javascript:void(0);" class="mobile-memu-icon" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </a>
            <div class="nav" id="myTopnav">
                {!!vn4_nav_menu('header','header')!!}
            </div>
        </div>
    </div>
</header>