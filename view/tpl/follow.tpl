<div id="follow-sidebar" class="widget">
	<h3>{{$connect}}</h3>
	<div id="connect-desc">{{$desc}}</div>
	<form action="follow" method="post" />
		<input id="side-follow-url" type="text" name="url" title="{{$hint}}" />
		<input id="side-follow-submit" type="submit" name="submit" class="btn btn-default" value="{{$follow}}" />
	</form>
	{{if $abook_usage_message}}
	<div class="usage-message" id="abook-usage-message">{{$abook_usage_message}}</div>
	{{/if}}
</div>

