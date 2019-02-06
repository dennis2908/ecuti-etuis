 <div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
            <div>
                <form id="form-forme" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

                    @component('components.bs.label', [
                        'label' => 'Nama Kesatuan Sekerja',
                    ])
                    {{ $forme->tenure->entity->name }}
                    @endcomponent

                    @component('components.bs.label', [
                        'label' => 'No. Pendaftaran',
                    ])
                    {{ $forme->tenure->entity->registration_no }}
                    @endcomponent

                    @component('components.bs.label', [
                        'label' => 'Alamat Ibu Pejabat',
                    ])
                    {!! $forme->address->address1.
                    ($forme->address->address2 ? ',<br>'.$forme->address->address2 : '').
                    ($forme->address->address3 ? ',<br>'.$forme->address->address3 : '').
                    ',<br>'.
                    $forme->address->postcode.' '.
                    ($forme->address->district ? $forme->address->district->name : '').', '.
                    ($forme->address->state ? $forme->address->state->name : '') !!}
                    @endcomponent

                    @include('components.bs.date', [
                        'name' => 'applied_at',
                        'label' => 'Tarikh Permohonan',
                        'mode' => 'required',
                        'value' =>  $forme->applied_at ? date('d/m/Y', strtotime($forme->applied_at)) : '',
                    ])

                    <div class="form-group row">
                        <label for="" class="col-md-3 control-label">
                            Melalui (Jenis Mesyuarat)<span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="radio radio-primary">
                                @foreach($meeting_types as $meeting_type)
                                    <input name="meeting_type_id" value="{{ $meeting_type->id }}" id="meeting_type_{{ $meeting_type->id }}" type="radio" class="hidden" onchange="meetingType({{ $meeting_type->id }})" required>
                                    <label for="meeting_type_{{ $meeting_type->id }}">{{ $meeting_type->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @include('components.bs.date', [
                        'name' => 'resolved_at',
                        'label' => 'Tarikh Mesyuarat',
                        'mode' => 'required',
                        'value' =>  $forme->resolved_at ? date('d/m/Y', strtotime($forme->resolved_at)) : '',
                    ])

                    @component('components.bs.label', [
                        'label' => 'Nama Setiausaha Penaja',
                    ])
                    {{ $forme->secretary->name }}
                    @endcomponent

                </form>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="pager wizard no-style">
                            <li class="next">
                                <button class="btn btn-success btn-cons btn-animated from-left pull-right fa fa-angle-right" type="button">
                                    <span>Seterusnya</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('dissolution.form', $dissolution->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END card -->
</div>

@push('js')
<script type="text/javascript">
$('#form-forme').validate();

</script>
@endpush
