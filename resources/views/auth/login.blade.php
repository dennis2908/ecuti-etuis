@extends('layouts.auth')

@section('content')
<?php
setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
?>
<div class="row">
    <div class="col-md-6">
        <h4 class="bold">Log Masuk</h4>
        <p>Sila log masuk dengan menggunakan akaun anda yang telah didaftarkan.</p>
        <form method="POST" action="{{ route('login') }}" class="p-t-15" id="form-login" name="form-login" role="form">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    @include('components.input', [
                        'label' => 'ID Pengguna',
                        'info' => 'No. Kad Pengenalan (Setiausaha Penaja)',
                        'mode' => 'required',
                        'name' => 'username'
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('components.input', [
                        'label' => 'Kata Laluan',
                        'info' => 'Minimum 8 Aksara',
                        'mode' => 'required',
                        'name' => 'password',
                        'type' => 'password',
                        'options' => 'minlength=8',                    
                        'placeholder' => 'Minimum 8 Aksara',
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <p><a class="text-info" href="{{ route('password.request') }}">Lupa Kata Laluan ?</a></p>
                </div>
            </div>
            <button class="btn btn-info m-t-10 pull-right" type="submit"><i class="fa fa-check m-r-5"></i> Log Masuk</button>
            <a class="btn btn-complete m-t-10" style="background-color: #5ec0cb !important;" href="{{ route('register') }}">Daftar Akaun</a>
        </form>
    </div>

    <div id="div-announcement" class="col-md-6">
        <h4 class="bold">Pengumuman</h4>
        
        <div class="split-list" style="width: 100%; max-height: 300px; overflow: auto;">
            <div class="boreded no-top-border list-view">
                <div>
                    @forelse($list_announcements as $announcements)
                    <div class="list-view-group-container">
                        <div class="list-view-group-header"><span>{{ strftime('%A %e %B %Y', strtotime($announcements->first()->date_start)) }} </span></div>
                        <ul class="no-padding">
                            @foreach($announcements as $announcement)
                            <li class="item padding-15 clickme" onclick="openAnnouncement({{ $announcement->id }})">
                                <div class="inline m-l-15">
                                    <p class="recipients no-margin hint-text small">{{ $announcement->title }}</p>
                                    <p class="subject no-margin">{{ substr($announcement->description,0,150) }}...</p>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @empty
                    <div class="list-view-group-container padding-20 bg-master-lightest">
                        <span>Tiada Sebarang Pengumuman</span>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
    $(function() {
        $('#form-login').validate()
    })

    @if(request()->has('registered'))
        swal({
            icon: "success",
            title: "Pendaftaran Selesai",
            content: "{!! App\OtherModel\Notification::where('code', 'PB_KS_1.1_A')->first()->message !!}",
        });

        window.history.pushState({}, null, "{{ route('login') }}");
    @endif
    
    function openAnnouncement(id) {
        console.log("{{ route('login') }}/announcement/"+id)
        $("#modal-div").load("{{ route('login') }}/announcement/"+id);
    }
</script>
@endpush