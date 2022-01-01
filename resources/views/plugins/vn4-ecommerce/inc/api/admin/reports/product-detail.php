<?php
$productId = $r->get('id');

if( $productId ){

    $time = $r->get('time');

    $productReport = new \Vn4Ecom\Report\Product\Detail($productId, $time );

    $reports = $productReport->getAllReport();

    if( $reports !== false ){
        
        list($startDate, $endDate) = $productReport->getTimeReport();

        return $reports + [
                'time'=> [
                    'startDate'=>get_date($startDate),
                    'endDate'=>get_date($endDate),
                    'time_report'=>\Vn4Ecom\Report\Time::all()
                ]
            ];
    }
}

return [
    'message'=>apiMessage('Product not found','error')
];