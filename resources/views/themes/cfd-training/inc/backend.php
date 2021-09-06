<?php


add_sidebar_admin(function() {

    $filter['demo'] = [
        'title'=>'CFD',
        'icon'=>'fa-themeisle',
        'submenu'=>[
            ['title'=>'Course','url'=>route('admin.show_data','cfd_course')],
            ['title'=>'Teacher','url'=>route('admin.show_data','cfd_teacher')],
            ['title'=>'Student','url'=>route('admin.show_data','cfd_student')],
            ['title'=>'Project','url'=>route('admin.show_data','cfd_project')],
            // ['title'=>'Case Study','url'=>route('admin.show_data','cfd_case_study')],
            ['title'=>'Contact','url'=>route('admin.show_data','cfd_contact')],
            ['title'=>'Register','url'=>route('admin.show_data','cfd_register')],
            // ['title'=>'Register','url'=>route('admin.show_data','cfd_course_register')],
        ]
    ];

    return $filter;


});


add_action('saved_post_cfd_course_register',function($post, $r, $admin_object){

    if( $post->nguoi_gioi_thieu 
        && $post->status === 'publish' 
        && ($nguoi_gioi_thieu = get_post('cfd_student',$post->nguoi_gioi_thieu)) 
        && ($hocvien_dang_ky = get_post('cfd_student',$post->cfd_student))
        && ($khoahoc = get_post('cfd_course',$post->cfd_course))
    ){

        $cfd_course = get_post('cfd_course',$post->cfd_course);

        $post1 = Vn4ModeL::newOrEdit('cfd_coin_history', ['cfd_course_register'=>$post->id, 'cfd_student'=>$nguoi_gioi_thieu->id], [
            'trang_thai'=>$post->trang_thai,
            'title'=>'Giới thiệu khóa học cho học viên mới',
            'date'=>$post->created_at,
            'coin'=>$cfd_course->money_affiliate_2
        ]);
        if( $post->coin_use ){

            $post2 = Vn4ModeL::newOrEdit('cfd_coin_history', ['cfd_course_register'=>$post->id, 'cfd_student'=>$hocvien_dang_ky->id], [
                'trang_thai'=>$post->trang_thai,
                'title'=>'Dùng COIN để đăng ký khóa học '.$khoahoc->title,
                'date'=>$post->created_at,
                'coin'=>-$post->coin_use
            ]);

        }
        

    }
});

add_action('saved_post_cfd_coin_history',function($post, $r, $admin_object){
    include __DIR__.'/function-helper.php';

    $hocvien = get_post('cfd_student',$post->cfd_student);

    if( $hocvien && $post->status === 'publish' ){
        tinh_coin_hien_tai_cua_hoc_vien($hocvien);
    }
});




// register_nav_menus([
//     'header'=>'Nav Header',
// ]);

// register_sidebar([
// 	'sidebar-right'=>['title'=>'Sidebar Right','description'=>'Sidebar Right of Home page, category, post detail.']
// ]);