<?php if( $paginator): ?>
<?php
// config
$link_limit = 4; // maximum number of links (a little bit inaccurate, but will be ok for now)
$request = request();

$paginator->setPath(Request::url());

$page = 'page';

if( isset($paginator->pageName_custom) ){
    $page = $paginator->pageName_custom;
}

$half_total_links = floor($link_limit / 2);

?>

<?php if($paginator->lastPage() > 1): ?>

    <ul class="uk-pagination uk-flex-center">
        
        <?php 

            $currentPage = $paginator->currentPage();

            $input = $request->except($page);

            $param = http_build_query($input);

            if( $param ) $param = '&'.$param;
            // foreach ($input as $key => $value) {
            //     if( is_string($value) ){
            //         $param .= '&'.$key.'='.$value;
            //     }
            // }

         ?>

        <?php if($currentPage == 1): ?>
            <li class="dis uk-disabled">
                <a href="javascript:void(0)"><?php echo __('«'); ?></a>
             </li>
        <?php else: ?>
            <li class="">
                <a rel="prev" href="<?php echo $paginator->url($currentPage - 1).$param; ?>"><?php echo __('«'); ?></a>
            </li>
        <?php endif; ?>

         <?php $result = ''; ?>
        <?php for($i = 1; $i <= $paginator->lastPage(); $i++): ?>
            <?php
            $from = $currentPage - $half_total_links;
            $to = $currentPage + $half_total_links;
            if ($currentPage < $half_total_links) {
               $to += $half_total_links - $currentPage;
            }
            if ($paginator->lastPage() - $currentPage < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $currentPage) - 1;
            }

            ?>
            <?php if($from < $i && $i < $to): ?>
                
                <?php 

                    if($currentPage == $i){
                        $result = $result. '<li class="uk-active">'
                            .'<a href="javascript:void(0)">'.$i.'</a>'
                        .'</li>' ;
                    }else{

                        if($currentPage > $i){
                            $rel = 'rel="prev"';
                        }else{
                            $rel = 'rel="next"';
                        }
                        $result = $result. '<li>'
                            .'<a '.$rel.' href="'.$paginator->url($i).$param.'">'.$i.'</a>'
                        .'</li>' ;
                    }
               ?>
                
            <?php endif; ?>
        <?php endfor; ?>
        <?php if($from > 2): ?>
            <li class="">
                <a rel="prev" href="<?php echo $paginator->url(1).$param; ?>">1</a>
            </li>
        
            <li class="">
                <a href="javascript:void(0)">...</a>
            </li>
        <?php else: ?>
            <?php for($i = 1; $i<= $from; $i++): ?>
             <li class="">
                <a rel="prev" href="<?php echo $paginator->url($i).$param; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
        <?php endif; ?>
        <?php echo $result; ?>

        <?php if($paginator->lastPage() - $to > 1): ?>
            <li class="">
                <a href="javascript:void(0)">...</a>
            </li>
            <li class="">
                <a rel="next" href="<?php echo $paginator->url($paginator->lastPage()).$param; ?>"><?php echo $paginator->lastPage(); ?></a>
            </li>
        <?php else: ?>
            <?php for($i = $to; $i<= $paginator->lastPage(); $i++): ?>
             <li class="">
                <a rel="next" href="<?php echo $paginator->url($i).$param; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
        <?php endif; ?>
        
        <?php if($currentPage == $paginator->lastPage()): ?>
            <li class="dis uk-disabled">
                <a href="javascript:void(0)"><?php echo __('»'); ?></a>
            </li>
        <?php else: ?>

            <li class="">
                <a rel="next" href="<?php echo $paginator->url($currentPage +1).$param; ?>"> <?php echo __('»'); ?></a>
            </li>
        <?php endif; ?>
       
    </ul>
<?php endif; ?>
<?php endif; ?>
