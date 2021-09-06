<?php

$arg['order'] = [
    'table'=>'order',
    'fields'=>[
        'name'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Họ tên là bắt buộc.',
        ],
        'phone'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Số điện thoại là bắt buộc.',
        ],
        'address'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Địa chỉ là bắt buộc.',
        ],
        'time'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Thoiwg gian là bắt buộc.',
        ],
        'count'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'số lượng là bắt buộc.',
        ],
        'day_of_week_shipper'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'ngày giao hàng là bắt buộc.',
        ],
        'time_shipper'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Giờ giao hàng là bắt buộc.',
        ],
    ],
];
$arg['contact'] = [
    'table'=>'contact',
    'fields'=>[
        'name'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Họ tên là bắt buộc.',
        ],
        'email'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Email là bắt buộc.',
        ],
        'phone'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Số điện thoại là bắt buộc.',
        ],
        'subject'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Chủ đề là bắt buộc.',
        ],
        'content'=>[
            'type'=>'string',
            'required'=>true,
            'message_required' =>'Nội dung là bắt buộc.',
        ],
    ],
];



return $arg;