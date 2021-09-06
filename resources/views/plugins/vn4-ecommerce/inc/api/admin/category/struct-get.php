<?php
$admin_object = get_admin_object('ecom_prod_cate');

$posts = DB::Table($admin_object['table'])
    ->select(DB::raw('ecom_prod_cate.*, (select count(*) from ecom_prod where ecom_prod_cate = ecom_prod_cate.id) as productCount'))
    ->where('type', 'ecom_prod_cate')
    ->groupBy('ecom_prod_cate.id')
    ->orderBy('order')
    ->get();


return [
    'posts'=>$posts,
];