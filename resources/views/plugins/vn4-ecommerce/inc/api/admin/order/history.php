<?php

$user = getUser();

$history = new \Vn4Ecom\Cart\Model\Cart\History( [
    'name'=>$user->first_name.' '.$user->last_name,
    'email'=>$user->email
] );

$history->setType($r->get('type'));

$history->addMessage( \Vn4Ecom\Cart\Model\Cart\History::ADD_NOTE,
    [
        'message'=>$r->get('message'),
    ]
);

return [
    'history'=>$history->toArray()
];
