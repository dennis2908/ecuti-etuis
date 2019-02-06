<script type="text/javascript">
$(".address .postcode").on('change', function() {
	parent = $(this).parents('.address');
	$.ajax({
		url: "{{ url('general/postcode-state') }}/"+$(this).val(),
		type: 'GET',
		datatype: 'json',
		success: function(data){
			parent.find('.state').val(data.state.id).trigger('change');
			setTimeout(function() {
				parent.find('.district').val(data.id).trigger('change');
			}, 1000);
			
		},
		error: function(xhr, ajaxOptions, thrownError){
	        console.log(thrownError);
		}
	});
});

$(".address .state").on('change', function() {
	list = $(this).parents('.address').find('.district');
	list.empty();
	list.append("<option disabled selected hidden>Pilih Daerah...</option>");

	$.ajax({
		url: "{{ url('general/state-district') }}/"+$(this).val(),
		type: 'GET',
		datatype: 'json',
		success: function(data){
			$.each(data, function(key, district) {
				list.append("<option value='" + district.id +"'>" + district.name + "</option>");
			});
		},
		error: function(xhr, ajaxOptions, thrownError){
	        console.log(thrownError);
	    }
	});
});
</script>