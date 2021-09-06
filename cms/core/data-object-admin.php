<?php
$object = [];

$object['admin_notification'] = [
    'table'=>vn4_tbpf().'admin_notification',
    'title'=>__('Admin Notification'),
	'public_view'=>false,
    'object_admin'=>true,
    'fields'=>[
        'title'=>[
            'title'=>__('Title'),
            'view'=>'text',
            'required'=>true,
        ],
        'severity' => [
            'title'=>__('Severity'),
            'view' =>'select',
			'list_option'=>[
				'critical'=>['title'=>'Critical','color'=>'#f9d4d4', 'textColor'=>'#e22626'],
				'major'=>['title'=>'Major','color'=>'#f9d4d4', 'textColor'=>'#e22626'],
				'minor'=>['title'=>'Minor','color'=>'#feeee1', 'textColor'=>'#ed4f2e'],
				'notice'=>['title'=>'Notice','color'=>'#d0e5a9', 'textColor'=>'#3f51b5'],
			]
        ],
        'message' => [
            'title'=>__('Message'),
            'view' =>'textarea',
        ],
        'is_read' => [
            'title'=>__('Is Read'),
            'view' =>'true_false',
            'inlineEdit'=>true,
        ],
    ],
];

return $object;
