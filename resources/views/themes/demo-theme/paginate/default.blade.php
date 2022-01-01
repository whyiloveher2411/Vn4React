@if( $paginator)
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

@if ($paginator->lastPage() > 1)

    <ul class="pagination">
        
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

        @if($currentPage == 1)
            <li class="dis">
                <a href="javascript:void(0)">@__('«')</a>
             </li>
        @else
            <li class="">
                <a rel="prev" href="{!!$paginator->url($currentPage - 1).$param!!}">@__('«')</a>
            </li>
        @endif

         <?php $result = ''; ?>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
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
            @if ($from < $i && $i < $to)
                
                <?php 

                    if($currentPage == $i){
                        $result = $result. '<li class="active">'
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
                
            @endif
        @endfor
        @if($from > 2)
            <li class="">
                <a rel="prev" href="{!!$paginator->url(1).$param!!}">1</a>
            </li>
        
            <li class="dot">
                <a href="javascript:void(0)">...</a>
            </li>
        @else
            @for($i = 1; $i<= $from; $i++)
             <li class="">
                <a rel="prev" href="{!!$paginator->url($i).$param!!}">{!!$i!!}</a>
            </li>
            @endfor
        @endif
        {!!$result!!}
        @if($paginator->lastPage() - $to > 1)
            <li class="dot">
                <a href="javascript:void(0)">...</a>
            </li>
            <li class="">
                <a rel="next" href="{!! $paginator->url($paginator->lastPage()).$param !!}">{!!$paginator->lastPage()!!}</a>
            </li>
        @else
            @for($i = $to; $i<= $paginator->lastPage(); $i++)
             <li class="">
                <a rel="next" href="{!!$paginator->url($i).$param!!}">{!!$i!!}</a>
            </li>
            @endfor
        @endif
        
        @if($currentPage == $paginator->lastPage())
            <li class="dis">
                <a href="javascript:void(0)">@__('»')</a>
            </li>
        @else

            <li class="">
                <a rel="next" href="{!!$paginator->url($currentPage +1).$param!!}"> @__('»')</a>
            </li>
        @endif
       
    </ul>
@endif
@endif