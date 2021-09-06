<?php

if( !method_exists($list_data,'total') ){
    return;
}
if( !isset($post_filter) || $post_filter === null ){
     $post_filter = Request::get('post_filter','all');
     $post_filter = explode('.', $post_filter);
}

$list_data->setPath(Request::url());

    $total = $list_data->total();

    $itemForm = $list_data->perPage()*($list_data->currentPage()  - 1);

    $itemTo = $itemForm + $list_data->perPage();

    if($itemTo>$total ){
        $itemTo = $total;
    }

    if($total!= 0){
        $itemForm = $itemForm  + 1;
    }

     $showing = str_replace( ['##from##','##to##','##count##'], ['<span class="show_item_form">'.number_format($itemForm).'</span>','<span class="show_item_to">'.number_format($itemTo).'</span>','<span class="total_item">'.number_format($total).'</span>'], __('Showing ##from## to ##to## of ##count## Entries'));

    // maximum number of links (a little bit inaccurate, but will be ok for now)
    $link_limit = 4; 

    $str = '<div class="center-mid"><div class="dataTables_info" role="status" aria-live="polite">'.$showing.'</div><div class="dataTables_paginate paging_simple_numbers">';


    if ($list_data->lastPage() > 1){
        
        $str = $str.'<ul class="pagination" style="margin: 0;">';

        $param = get_param(['page'],false);

        if($param != ''){
            $param = '&'.$param;
        }

        $show_page_before = __('«');

        if($list_data->currentPage() == 1){
            $str = $str.'<li class="disabled paginate_button"><span>'.$show_page_before.'</span></li>';
         }else{
            $str = $str.'<li class="paginate_button">'
                .'<a href="'.$list_data->url($list_data->currentPage()  - 1).$param.'">'.$show_page_before.'</a>'
                .'</li>';
         }
            

        $result = '';

        for ($i = 1; $i <= $list_data->lastPage(); $i++){



            $half_total_links = floor($link_limit / 2);
            $from = $list_data->currentPage() - $half_total_links;
            $to = $list_data->currentPage() + $half_total_links;
            if ($list_data->currentPage() < $half_total_links) {
               $to += $half_total_links - $list_data->currentPage();
            }
            if ($list_data->lastPage() - $list_data->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($list_data->lastPage() - $list_data->currentPage()) - 1;
            }

            if ($from < $i && $i < $to){
                
                    $active = $list_data->currentPage() == $i ? ' active' : '';
                $result = $result. '<li class="paginate_button '.$active.'">'
                            .'<a href="'.$list_data->url($i). $param .'">'.$i.'</a>'
                        .'</li>' ;
                
            }

        }

        if($from > 2){
            $str = $str.'<li class="paginate_button">'
                       .'<a href="'.$list_data->url(1).$param.'">1</a>'
                       .'</li><li class="disabled"><span>...</span></li>';
        }else{
            for($i = 1; $i<= $from; $i++){
              $str = $str.'<li class="paginate_button">'
                         .'<a href="'.$list_data->url($i).$param.'">'.$i.'</a></li>';
            }
        }
        $str = $str.$result;

        if($list_data->lastPage() - $to > 1){
            $str = $str.'<li class="disabled paginate_button"><span>...</span></li>';
             $str = $str.'<li class="paginate_button"><a href="'.$list_data->url($list_data->lastPage()).$param.'">'.$list_data->lastPage().'</a></li>';
        }else{
            for($i = $to; $i<= $list_data->lastPage(); $i++){
             $str = $str.'<li class="paginate_button"><a href="'.$list_data->url($i).$param.'">'.$i.'</a></li>';
            }
        }
        
        $show_page_after = __('»');
        if($list_data->currentPage() == $list_data->lastPage()){

            $str = $str.'<li class="disabled paginate_button"><span>'.$show_page_after.'</span></li>';
        }else{
            $str = $str.'<li class="paginate_button"><a href="'.$list_data->url($list_data->currentPage() +1).$param.'">'.$show_page_after.'</a></li>';
        }
           
         $str = $str.'</ul></div></div>';
    }else{
        $str = $str.'</div></div>';
    }

echo $str;