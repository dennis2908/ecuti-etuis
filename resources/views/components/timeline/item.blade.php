@php
	$type = isset($type) ? $type : 'complete' ;
	$open = isset($open) ? $open : true ;
@endphp
<div class="notification-item unread clearfix">
	<div class="heading @if(!empty(trim($slot)) && $open) open @endif">
		<a class="text-{{ $type }} pull-left" href="#" style="width: 80%; line-height: 20px; padding-top: 10px;">
			<i class="fa fa-{{ $type == 'danger' ? 'exclamation-triangle' : ($type == 'success' ? 'check' : ($type == 'warning' ? 'comment' : 'file')) }} fs-16 m-r-10"></i>
			<span class="bold">{{ $title or '' }}</span>
			<span class="fs-12 m-l-10 pull-right">{{ $subtitle or '' }}</span>
		</a>
		<div class="pull-right">
			@if(!empty(trim($slot)))
			<div class="thumbnail-wrapper d16 circular inline m-t-15 m-r-10 toggle-more-entity">
				<div>
					<i class="fa fa-angle-left"></i>
				</div>
			</div>
			@endif
			<span class=" time">{{ $date or '' }}</span>
		</div>
		@if(!empty(trim($slot)))
		<div class="more-entity">
			{{ $slot or '' }}
		</div>
		@endif
	</div>
</div>