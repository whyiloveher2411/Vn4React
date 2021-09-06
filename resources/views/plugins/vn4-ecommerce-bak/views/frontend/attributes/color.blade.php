<div class="list-attribute-value" data-id="{!!$data['id']!!}">
    <div class="uk-text-small uk-margin-xsmall-bottom">{!!$data['title']!!}</div>
    <ul class="uk-subnav uk-subnav-pill tm-variations row attribute-template-color"
        uk-switcher>
        @foreach($data['attribute_detail'] as $key => $value)
        <?php 
            $post = get_post('ecommerce_product_attribute_value',$key);
         ?>

         @if($post)
        <li value="{!!$post->id!!}" class="attribute-value"><a class="tm-variation-color"
                uk-tooltip="{!!$post->title!!}">
                <div style="background-color: {!!$post->content!!}">
                </div>
            </a></li>
        @endif
        @endforeach
    </ul>
</div>