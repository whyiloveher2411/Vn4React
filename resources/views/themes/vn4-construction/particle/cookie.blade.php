<div class="top-message-cookie" style="position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9999999;
    background-color: #226DA0;
    color: #C1DAEB;
    font-size: 14px;
    text-align: left;
    padding: 20px;
    align-items: center;
    font-family: "Roboto", sans-serif;
    -webkit-font-smoothing: antialiased;">
    <div class="gdrp-banner-content">
        {!!theme_options('general','cookie-accept')!!}
    </div>
    <a href="#" data-vcv-close-top-message="" class="vcv-header-side-nav-close">
<span class="vcv-navbar-icon vcv-navbar-icon-active vcv-clone-banner-icon">
  <span class="fa fa-times" onClick=" document.cookie = 'accept-cookies=1;expires={!!date('Y-m-d H:i:s', strtotime('+1 day', time()))!!}';console.log(document.cookie); document.querySelectorAll('.top-message-cookie')[0].remove();return false;" style="    position: absolute;
    right: 20px;
    top: 45%;
    font-size: 16px;
    color: white;"></span>
</span>
    </a>
</div>