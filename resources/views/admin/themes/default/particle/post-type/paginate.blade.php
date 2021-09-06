<?php

if( !method_exists($list_data,'total') ){
    return;
}
if( !isset($post_filter) || $post_filter === null ){
     $post_filter = Request::get('post_filter','all');
     $post_filter = explode('.', $post_filter);
}

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
    
    $option_action_post = '<option value="trash" >'.__('Move to Trash').'</option>';

    if ( $post_filter[0] === 'trash' ){
         $option_action_post = '<option value="restore" >'.__('Restore').'</option><option value="delete" >'.__('Delete forever').'</option>';
    }

    // maximum number of links (a little bit inaccurate, but will be ok for now)
    $link_limit = 4; 
    $str = '<div class=" action-multi-post vn4-wat"><select class="form-control pull-left vn4-wat" ><option value="">'.__('Action').'</option>'.$option_action_post.'</select><button type="submit" class="btn-apply-action-multi-post vn4-btn-white pull-left" name="status" value="draft">'.__('Apply').'</button>  </div> <div class="dataTables_info" role="status" aria-live="polite">'.$showing.'</div><div class="dataTables_paginate paging_simple_numbers">';


    if ($list_data->lastPage() > 1){
        
        $showing_go_to_page = str_replace( '##page##', '<input  data-old="'.$list_data->currentPage().'" class="number_page form-control input-sm go_page" type="number" name="" value="'.$list_data->currentPage().'">' , __('Go to page ##page## OR'));

        $str = $str.'<div class="go_to_page">'.$showing_go_to_page.'</div>';
        
        $str = $str.'<ul class="pagination">';

        $param = get_param(['edit_id']);

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
           
         $str = $str.'</ul></div>';
    }else{
        $str = $str.'<div class="clearfix"></div></div>';
    }

echo $str;