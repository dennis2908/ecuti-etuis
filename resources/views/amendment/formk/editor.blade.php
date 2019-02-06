<?php

function getChildren($constitution, $id) {
	$result = '';

	if($id === null)
		$children = (clone $constitution)->items()->whereNull('parent_constitution_item_id')->get();
	else
		$children = (clone $constitution)->items()->where('parent_constitution_item_id', $id)->get();

	foreach($children as $index => $child)
		$result .= '<div class="sortable-item" item_id="'.$child->id.'">
						<div class="flex-div">
							<div class="handle"></div>
							<div contenteditable="true" class="contenteditable">'.$child->content.'</div>
							<div class="delete"><i class="fa fa-trash"></i></div>
						</div>
						<div class="sortable">
							'.getChildren($constitution, $child->id).'
						</div>
					</div>';
	
	return $result;
}

?>

@extends('layouts.app')

@push('css')
<style type="text/css">

	.flex-div {
		display:flex;
	}

	.flex-div div[contenteditable=true] {
		background-color:#ffffff;
		flex-grow:1;
		margin-bottom:5px;
		margin-top:5px;
		padding:10px;
	}

	.root > .sortable-item > .flex-div > .contenteditable {
		font-weight:700;
	}

	.rule {
		padding: 0 15px;
	}

	.rule-block {
		display:table;
		margin-top: 5px;
		padding: 0px;
	}

	.rule-title {
		display:table-cell;
		background-color: #ffffff;
		padding: 10px;
	}

	.sortable {
		list-style-type:none;
		padding:0;
	}

	.sortable .sortable {
		padding-left:20px;
	}

	.sortable-item {
		margin-bottom:2px;
	}

	.sortable-item .delete {
		background-color:#e64942;
		color:#FFF;
		cursor:pointer;
		font-weight:700;
		margin-bottom:5px;
		margin-top:5px;
		padding:10px;
	}

	.sortable-item .handle {
		background-color:#e7e7e7;
		cursor:move;
		margin-bottom:5px;
		margin-top:5px;
		padding:10px;
	}
</style>
@endpush

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('formk.editor') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Buku Peraturan</h3>
							<p class="small hint-text m-t-5">
								Sila kemaskini buku peraturan pada ruangan di bawah.
							</p>
						</div>
					</div>
					<!-- END card -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END BREADCRUMB -->

@include('components.msg-connecting')

<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg">

	<div class="root sortable">
		{!! getChildren($constitution, null) !!}
	</div>

	<div class="row rule" onclick="newItem()">
		<div class="rule-block col-md-12">
			<div id="add-rule" class="rule-title bold text-white bg-success clickable">
				<i class="fa fa-plus-circle m-r-5"></i> Tambah Peraturan
			</div>
		</div>
	</div>

    <br/>

    <div class="form-group">
        <button type="button" class="btn btn-default mr-1" onclick="back()"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
        <button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">

	temp = '';

	function newItem() {
		$.ajax({
            url: '{{ route('formk.add', $constitution->id) }}',
            method: 'POST',
            dataType: 'json',
            async: true,
            contentType: false,
            processData: false,
            success: function(data) {
            	if(data.status == 'success') {
					$(".root").append('\
					<div class="sortable-item" item_id="'+data.constitution_item_id+'">\
						<div class="flex-div">\
							<div class="handle"></div>\
							<div contenteditable="true" class="contenteditable"></div>\
							<div class="delete"><i class="fa fa-trash"></i></div>\
						</div>\
						<div class="sortable"></div>\
					</div>');

					initSort();
            	}
            }
        });
	}

	initSort();

	function save() {
        swal({
            title: "Berjaya!",
            text: "Data yang telah disimpan.",
            icon: "success",
            button: "OK",
        })
        .then((confirm) => {
            if (confirm) {
                back();
            }
        });
    }

    
    var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

    socket.on('connect', function() {
        $(".msg-disconnected").slideUp();
        $(".msg-connecting").slideUp();
    });

    socket.on('disconnect', function() {
        $(".msg-disconnected").slideDown();
        $("html, body").animate({ scrollTop: 0 }, 500);
    });

	function initSort() {
		$( ".sortable" ).sortable({
			cancel: ':input,button,.contenteditable',
			cursor: 'move',
			handle: ".handle",
			connectWith: ".sortable"
		}).on('sortstop', function(event, ui) {
			$(".sortable").css('background-color', 'unset');
			$(".sortable").css('min-height', 'unset');

			var item = $(ui)[0].item;
			// console.log( '-------------------------------------' );
			// console.log( 'Changed Item: ' + item.attr('item_id') );
			// console.log( 'Above Item: ' + item.prev().attr('item_id') );
			// console.log( 'Below Item: ' + item.next().attr('item_id') );
			// console.log( 'Parent Item: ' + item.parents('.sortable-item').attr('item_id') );

			socket.emit('constitution_move', {
	            id: item.attr('item_id'),
	            above: item.prev().attr('item_id'),
	            below: item.next().attr('item_id'),
	            parent: item.parents('.sortable-item').attr('item_id'),
	            constitution: {{ $constitution->id }},
            	user_id: {{ auth()->id() }},
	            user: '{{ Cookie::get('api_token') }}'
	        });

		}).on('sortstart', function(event, ui) {
			$(".sortable").css('background-color', 'rgba(44,151,215,0.1)');
			$(".sortable.ui-sortable").css('min-height', '5px');
		});

		$(".delete").on('click', function() {
			swal({
		        title: "Padam Data",
		        text: "Data yang telah dipadam tidak boleh dikembalikan. Teruskan?",
		        icon: "warning",
		        buttons: ["Batal", { text: "Padam", closeModal: true }],
		        dangerMode: true,
		    })
		    .then((confirm) => {
		        if (confirm) {
		        	socket.emit('constitution_delete', {
			            id: $(this).parents('.sortable-item').attr('item_id'),
	            		constitution: {{ $constitution->id }},
	            		user_id: {{ auth()->id() }},
	            		user: '{{ Cookie::get('api_token') }}'
			        });

					// console.log( '-------------------------------------' );
					// console.log( 'Deleted Item: ' + $(this).parents('.sortable-item').attr('item_id') );
					$(this).parents('.sortable-item').remove();
		        }
		    });
		});

	    $('div[contenteditable=true]').on('focus', function() {
	    	temp = $(this).html();
    	});

    	$('div[contenteditable=true]').on('blur', function() {
	    	if( $(this).html() != temp ) {
	    		socket.emit('constitution_edit', {
		            id: $(this).parents('.sortable-item').attr('item_id'),
		            value: $(this).html(),
	            	constitution: {{ $constitution->id }},
	            	user_id: {{ auth()->id() }},
		            user: '{{ Cookie::get('api_token') }}'
		        });
		        console.log('changed');
	    	}
    	});
	}
</script>
@endpush
