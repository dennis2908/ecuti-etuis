@push('css')
<link href="{{ asset('assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('assets/plugins/jquery-datatable/extensions/Buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('assets/plugins/datatables-responsive/css/datatables.responsive.css') }}" rel="stylesheet" type="text/css">

@endpush

@push('js')
<script src="{{ asset('assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js') }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/Buttons/js/buttons.bootstrap.min.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/Buttons/js/buttons.colVis.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/Buttons/js/buttons.flash.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/Buttons/js/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/Buttons/js/buttons.print.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/PDFMake/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/PDFMake/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-datatable/extensions/JSZip/jszip.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.js') }}" type="text/javascript"></script>
@endpush