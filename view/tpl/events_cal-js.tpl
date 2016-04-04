{{$tabs}}
<div class="generic-content-wrapper">
	<div class="section-title-wrapper">
		<div class="pull-right">
			<button id="fullscreen-btn" type="button" class="btn btn-default btn-xs" onclick="makeFullScreen();"><i class="icon-resize-full"></i></button>
			<button id="inline-btn" type="button" class="btn btn-default btn-xs" onclick="makeFullScreen(false);"><i class="icon-resize-small"></i></button>
			<div class="btn-group">
				<button class="btn btn-default btn-xs" onclick="changeView('prev', false);" title="{{$prev}}"><i class="icon-backward"></i></button>
				<button id="events-spinner" class="btn btn-default btn-xs" onclick="changeView('today', false);" title="{{$today}}"><i class="icon-bullseye"></i></button>
				<button class="btn btn-default btn-xs" onclick="changeView('next', false);" title="{{$next}}"><i class="icon-forward"></i></button>
			</div>
		</div>
		<h2 id="title"></h2>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="section-content-wrapper-np">
		<div id="events-calendar"></div>
	</div>
</div>
