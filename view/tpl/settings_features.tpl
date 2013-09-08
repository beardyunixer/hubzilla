<div class="generic-content-wrapper">
<h1>{{$title}}</h1>


<form action="settings/features" method="post" autocomplete="off">
<input type='hidden' name='form_security_token' value='{{$form_security_token}}'>

{{foreach $features as $f}}
<h3 class="settings-heading">{{$f.0}}</h3>

{{foreach $f.1 as $fcat}}
    {{include file="{{$field_yesno}}" field=$fcat}}
{{/foreach}}
{{/foreach}}

<div class="settings-submit-wrapper" >
<input type="submit" name="submit" class="settings-features-submit" value="{{$submit}}" />
</div>

</form>

</div>
