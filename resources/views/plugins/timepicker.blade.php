@push('css')
<link href="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js')
<script src="{{ asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
/* Time picker
 * https://github.com/m3wolf/bootstrap3-timepicker
 */
$('#timepicker, .timepicker').timepicker().on('show.timepicker', function(e) {
    var widget = $('.bootstrap-timepicker-widget');
    widget.find('.glyphicon-chevron-up').removeClass().addClass('pg-arrow_maximize');
    widget.find('.glyphicon-chevron-down').removeClass().addClass('pg-arrow_minimize');
});
</script>
@endpush