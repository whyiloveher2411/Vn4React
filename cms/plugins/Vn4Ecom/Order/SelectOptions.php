<?php
namespace Vn4Ecom\Order;

class SelectOptions{

    public static function status(){
        return [
            'pending'=>['title'=>'Pending payment','color'=>'#404040'],
            'processing'=>['title'=>'Processing','color'=>'#3f51b5'],
            'on-hold'=>['title'=>'On hold','color'=>'#ffaa00'],
            'completed'=>['title'=>'Completed','color'=>'#43a047'],
            'cancelled'=>['title'=>'Cancelled','color'=>'#a00'],
            'refunded'=>['title'=>'Refunded','color'=>'#7903da'],
            'failed'=>['title'=>'Failed','color'=>'#ff5900'],
        ];
    }

    public static function saleChannel(){
        return [
            'website'=>['title'=>'Website','color'=>'#43a047'],
            'facebook'=>['title'=>'Facebook','color'=>'#3f51b5'],
            'pos'=>['title'=>'POS','color'=>'#a00'],
            'marketplace'=>['title'=>'Marketplace','color'=>'#ffaa00'],
        ];
    }

}