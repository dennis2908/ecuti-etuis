@include('plugins.hover')

@push('css')
<style type="text/css">
.hvr-icon-forward::before {
	font-size: 15px;
}

.notification-panel {
    width: 100% !important;
}

.notification-body {
	max-height: unset !important;
}

.notification-panel .notification-body .notification-item {
    padding-right: 25px !important;
}

.notification-panel .notification-body .notification-item .more-entity .more-entity-inner::after {
	top: 8px !important;
}

.notification-panel .notification-body .notification-item .more-entity .more-entity-inner {
	padding-top: 0px !important;
}
</style>
@endpush

{{ $slot or '' }}