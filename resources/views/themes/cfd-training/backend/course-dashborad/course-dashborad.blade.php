<?php

add_action('vn4_footer',function(){
    echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
});

add_action('vn4_head',function(){
    ?>
    <style>
        .card-list{
            display:flex;
            margin: 0px -10px;
            flex-wrap: wrap;
        }
        .card-list .card{
            margin: 10px;
            background-color: white;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            flex-wrap: wrap;
        }
        .card img{
            width: 60px;
            height: auto;
            box-shadow: none;
            margin-right: 20px;
        }        
        .card .content{
            width: calc(100% - 80px);
        }
        .card .number{
            font-size: 24px;
            font-weight: bold;
            margin:0;
        }
        .card .note{
            font-size: 14px;
            color: gray;
        }
        .process {
            display: flex;
            align-items: center;
            font-size: 16px;
            width: 100%;
        }
        .process .line {
            flex: 1;
            background: #e6eaea;
            height: 6px;
            border-radius: 100px;
            position: relative;
            margin-right: 15px;
        }
        .process .line .rate {
            border-radius: 100px;
            position: absolute;
            background: #00afab;
            height: 6px;
            left: 0;
            top: 0;
        }
        .table-bordered>thead>tr>td, .table-bordered>thead>tr>th:not(:first-child){
            padding: 5px !important;
            text-align: center;
            white-space: unset !important;
        }
        .table-bordered>thead>tr>th{
            text-align: center;
            vertical-align: inherit;
        }
        table>tbody>tr>td:not(:first-child){
            text-align: center;
        }
        .card .avatar{
            border-radius: 50%;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
            padding: 5px 8px;
            vertical-align: middle;
        }
  
        .table>tbody>tr>td p:last-child{
            margin-bottom: 0;
        }
    </style>
    <?php
});

$course = Request::get('courseId');

if( !$course || !($coursePost = get_post('cfd_course',$course)) ){
    return vn4_redirect(route('admin.show_data','cfd_course'));
}

$list_status_course = ['da-ket-thuc'=>['title'=>'Đã kết thúc','color'=>'#797979'],'dang-dien-ra'=>['title'=>'Đang diễn ra','color'=>'#f4744b'],'sap-khai-gian'=>['title'=>'Sắp khai giảng','color'=>'#ec5c6c']];

title_head($coursePost->title.' ['.$coursePost->course_type.']&nbsp;&nbsp;<a href="'.route('admin.show_data','cfd_course').'" class="vn4-btn vn4-btn-img"><i class="fa fa-list-ul" aria-hidden="true"></i> Back to List</a>&nbsp;&nbsp;<a href="'.route('admin.create_data',['type'=>'cfd_course','post'=>$course,'action_post'=>'edit']).'" class="vn4-btn vn4-btn-img"><i class="fa fa-pencil" aria-hidden="true"></i> Detail</a>');

$hocVien = $coursePost->related('cfd_course_register','cfd_course',['count'=>10000, 'callback'=>function($q){
    $q->whereIn('trang_thai',['duoc-duyet','cho-xet-duyet']);
}]);

$totalMoney = 0;
$totalMoneyDaThu = 0;

$hocVienDuocDuyet = $hocVien->where('trang_thai','duoc-duyet');

foreach ( $hocVienDuocDuyet as $value) {
    $totalMoney += $value->money;

    $moneyDaThu = json_decode($value->payment,true);

    if( isset($moneyDaThu[0]) ){
        foreach ($moneyDaThu as $value2) {
            if( !$value2['delete'] ){
                $totalMoneyDaThu += $value2['money'];
            }
        }
    }
}


// Progress

$now = time(); // or your date as well

$opening_time = strtotime($coursePost->opening_time);
$close_time = strtotime($coursePost->close_time);
$days = round(($close_time - $opening_time) / (60 * 60 * 24));

$datediff = $now - $opening_time;
// dd($datediff);

if( $datediff > 0 ){
    $day = round($datediff / (60 * 60 * 24));
}else{
    $day = 0;
}

$content = json_decode($coursePost->content,true);

$precent = $day * 100 / $days;

if( $precent > 100 ) $precent = 100;

?>

<div class="card-list">


     <div class="card" style="max-width: 100%; width: 500px;">
        <img src="https://cdn1.iconfinder.com/data/icons/literary-genres-glyph/64/engineering-processing-automation-machine-gears-512.png">
        <div class="content">
            <p class="number"> <span style="margin-bottom:5px;display: inline-block;padding: 5px 10px;border-radius: 4px;font-weight: bold;text-shadow: 1px 1px 3px black;color: white;white-space: nowrap;background: {!!@$list_status_course[$coursePost->course_status]['color']!!};">{!!@$list_status_course[$coursePost->course_status]['title']!!}</span></p>
             <div class="process">
                <div class="line">
                    <div class="rate" style="width: {!!$precent!!}%"></div>
                </div>
                {!!intval($precent) !!}%
            </div>
            <p class="note">{!!get_date($coursePost->opening_time),' - ', get_date($coursePost->close_time)!!}</p>
        </div>
       
    </div>

    <div class="card">
        <img src="https://image.flaticon.com/icons/png/512/201/201818.png">
        <div class="content">
            <p class="number">{!!number_format( $totalHocVien = $hocVien->count() )!!} Học viên</p>
            <?php 
                $totalHocVienDuocDuyet = $hocVien->where('trang_thai','duoc-duyet')->count();
            ?>
            <p class="note">
                @if( $totalHocVien > $totalHocVienDuocDuyet)
                <span style="color:green;">{!!number_format($totalHocVienDuocDuyet)!!} Được duyệt</span> <br> 
                <span style="color:red;">{!!number_format($totalHocVien - $totalHocVienDuocDuyet)!!} Chờ xét duyệt</span>
                @endif
            </p>
        </div>
    </div>

   

    <div class="card">
        <img src="https://toppng.com/uploads/preview/money-bag-icon-euros-11563611108asiwijaguc.png">
        <div class="content">
            <p class="number">{!!number_format($totalMoney)!!} VNĐ</p>
            <p class="note">
              
                @if( $totalMoney > $totalMoneyDaThu)
                <div style="display: flex;justify-content: space-between;align-items: center;">
                	<div>
                		<span style="color:green;">{!!number_format($totalMoneyDaThu)!!} VNĐ</span> <br> 
                		<span style="color:red;">{!!number_format($totalMoney - $totalMoneyDaThu)!!} VNĐ</span>
                	</div>
                	<div style="font-weight: bold;font-size: 26px;">
                		{!!number_format($totalMoneyDaThu/$totalMoney*100)!!}%
                	</div>
                </div>
                @else
                <span style="color:green;">Đã thu đủ</span> <br> 
                @endif
            </p>
        </div>
    </div>

    <div class="card">
        <img src="https://icon-library.com/images/attendance-icon/attendance-icon-7.jpg">
        <div class="content">
            <p class="number">Điểm danh</p>
            
        </div>
        <table style="width: 100%;margin-top: 15px;" class="table table-bordered table-hover">
            <thead>
                <?php 
                    $courseContent = json_decode($coursePost->content,true);
                    $soBuoi = count($courseContent);
                 ?>
                <tr>
                    <th rowspan="2">Họ và Tên</th>
                    <th colspan="{!!$soBuoi!!}">Ngày</th>
                    <th rowspan="2">Tỉ lệ</th>
                </tr>
                <tr>
                    @for( $i = 0 ; $i < $soBuoi; $i ++)
                    <th>
                        {!!$i+1!!}
                    </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                <?php 
                    $index = 0;
                 ?>
                @foreach($hocVienDuocDuyet as $h)
                <?php 
                    $students = $h->relationship('cfd_student');

                    $img =  get_media($students->avatar, null, 'thumbnail-1');

                 ?>
                 @if($students)
                <tr>
                    <td>{!!++$index,'. ',$students->title!!}</td>
                    @for( $i = 0 ; $i < $soBuoi; $i ++)
                    @if( $i % 2 == 0)
                    <td style="width: 30px; height: 30px; background: #dc4004;"></td>
                    @else
                    <td style="width: 30px; height: 30px;background: #218F1C;"></td>
                    @endif
                    @endfor
                    <td>50%</td>
                </tr>
                @endif
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="card">
        <img src="https://i.pinimg.com/originals/2c/fc/93/2cfc93d7665f5d7728782700e50596e3.png">
        <div class="content">
            <p class="number">Bài tập</p>
            
        </div>
        <table style="width: 100%;margin-top: 15px;" class="table table-bordered table-hover">
            <thead>
                <?php 
                    $courseContent = json_decode($coursePost->content,true);
                    $soBuoi = count($courseContent);
                 ?>
                <tr>
                    <th rowspan="2">Họ và Tên</th>
                    <th colspan="{!!$soBuoi!!}">Ngày</th>
                    <th rowspan="2">Tỉ lệ</th>
                </tr>
                <tr>
                    @for( $i = 0 ; $i < $soBuoi; $i ++)
                    <th>
                        {!!$i+1!!}
                    </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                <?php 
                    $index = 0;
                 ?>
                @foreach($hocVienDuocDuyet as $h)
                <?php 
                    $students = $h->relationship('cfd_student');
                 ?>
                 @if($students)
                <tr>
                    <td>{!!++$index,'. ',$students->title!!}</td>
                    @for( $i = 0 ; $i < $soBuoi; $i ++)
                    @if( $i % 2 == 0)
                    <td style="width: 30px; height: 30px; background: #dc4004;"></td>
                    @else
                    <td style="width: 30px; height: 30px;background: #218F1C;"></td>
                    @endif
                    @endfor
                    <td>50%</td>
                </tr>
                @endif
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="card">
        <img src="https://toppng.com/uploads/preview/money-bag-icon-euros-11563611108asiwijaguc.png">
        <div class="content">
            <p class="number">Thông tin thanh toán (VNĐ)</p>
            
        </div>
        <table style="width: 100%;margin-top: 15px;" class="table table-bordered table-hover">
            <thead>
                <?php 
                    $courseContent = json_decode($coursePost->content,true);
                    $soBuoi = count($courseContent);
                 ?>
                <tr>
                    <th>Họ và Tên</th>
                    <th>Học phí</th>
                    <th>Thanh toán</th>
                    <th>Tỉ lệ thanh toán</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $index = 0;
                    $totalMoney = 0;
                    $totalMoneyPayment = 0;
                 ?>
                @foreach($hocVienDuocDuyet as $h)
                <?php 
                    $students = $h->relationship('cfd_student');
                    $payments = json_decode($h->payment,true);
                 ?>
                 @if($students)
                 <?php 
                    $totalPayment = 0;
                    $totalMoney += $h->money;
                  ?>
                <tr>
                    <td>{!!++$index,'. ',$students->title!!}</td>
                    <td>{!!number_format($h->money)!!}</td>
                    <td>
                    @forif($payments as $p)
                    <p>{!!number_format($p['money']),' - ',get_date($p['date'])!!}</p>
                    <?php 
                        $totalPayment += $p['money'];
                     ?>
                    @endforif 

                    <?php 
                        $totalMoneyPayment += $totalPayment;
                     ?>
                    </td>
                    <td @if( $totalPayment < $h->money ) style="color:red;" @endif>{!!number_format($totalPayment/$h->money*100)!!}%</td>
                </tr>
                @endif
                @endforeach

                <tr style="text-align: center;font-weight: bold;font-size: 16px;">
                    <td>Total</td>
                    <td>{!!number_format($totalMoney)!!}</td>
                    <td style="color: green;">{!!number_format($totalMoneyPayment)!!}</td>
                    <td>{!!number_format($totalMoneyPayment/$totalMoney*100)!!}%</td>
                </tr>

            </tbody>
        </table>
    </div>



    
</div>
