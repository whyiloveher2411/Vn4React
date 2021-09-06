<div class="list-attribute-value" data-id="{!!$data['id']!!}">
    <div class="uk-text-small uk-margin-xsmall-bottom">{!!$data['title']!!}</div>
    <ul class="uk-subnav uk-subnav-pill tm-variations row"
        uk-switcher>
        @foreach($data['attribute_detail'] as $key => $value)
        <li value="{!!$key!!}" class="attribute-value"><a>{!!$value!!}</a></li>
        @endforeach
    </ul>
</div>