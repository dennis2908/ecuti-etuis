@push('css')
<style>
.swal-footer {
	background-color: rgb(245, 248, 250);
	margin-top: 32px;
	border-top: 1px solid #E9EEF1;
	overflow: hidden;
}
.swal-text {
	text-align: center;
}
</style>
@endpush

@push('js')
<script src="{{ asset('assets/plugins/sweetalert.min.js') }}" type="text/javascript"></script>
@endpush