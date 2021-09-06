<div>
    <input name="{!!isset($name)?$name:$key!!}" @if( isset($character_limit) && $character_limit) maxlength="{!!$character_limit!!}" @endif {!!isset($required) && $required?'required':''!!} value="{{$value}}" placeholder="{!!isset($placeholder)?$placeholder:''!!}" type="{!!isset($type)?$type:'text'!!}" id="{!!$key!!}" class="form-control">
</div>



