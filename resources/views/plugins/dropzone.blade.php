@push('css')
<link href="{{ asset('assets/plugins/dropzone/css/dropzone.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js')
<script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	Dropzone.autoDiscover = false;
</script>
@endpush