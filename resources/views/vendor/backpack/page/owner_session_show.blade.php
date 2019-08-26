@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Detil Sesi Bimbingan
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li><a href="{{ route('backpack.page.sessions') }}">Daftar Sesi</a></li>
        <li class="active">Detil Sesi Bimbingan</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            @if($session->isPostponed())
                <div class="box box-danger">
                    <div class="box-header">
                        <strong>Konfirmasi</strong>
                    </div>
                    <div class="box-body">
                        <strong>Apakah anda menyetujui permintaan sesi bimbingan ini?</strong>
                    </div>
                    <div class="box-footer">
                    <span class="pull-right">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-accept">Terima</button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#modal-reject">Tolak</button>
                    </span>
                    </div>
                    <div class="modal fade" id="modal-accept" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Konfirmasi</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin akan <strong>menerima</strong> permintaan bimbingan ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('backpack.page.owner.session_status', ['id' => $session->id, 'status' => 1]) }}"><button type="button" class="btn btn-success">Terima</button></a>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div class="modal fade" id="modal-reject" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Konfirmasi</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin akan <strong>menolak</strong> permintaan bimbingan ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('backpack.page.owner.session_status', ['id' => $session->id, 'status' => 2]) }}"><button type="button" class="btn btn-danger">Tolak</button></a>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <div class="box">
                <div class="box-body">

                    <strong>
                        Status Sesi
                    </strong>
                    <p class="text-muted">
                    @if($session->isPending())
                        <td><span class="label label-warning">Menunggu Persetujuan Tentor</span></td>
                    @elseif($session->isPostponed())
                        <td><span class="label label-primary">Menunggu Persetujuan Admin</span></td>
                    @elseif($session->isApproved())
                        <td><span class="label label-success">Sedang Berjalan</span></td>
                    @elseif($session->isRejected())
                        <td><span class="label label-danger">Selesai/Ditolak</span></td>
                        @endif
                        </p>
                        <hr>

                        <strong>
                            Mata Pelajaran
                        </strong>
                        <p class="text-muted">
                            <span class="label label-default" style="background-color: {{$session->subject->color}}; color: #fff;">{{ $session->subject->name }}</span>
                        </p>
                        <hr>

                        <strong>
                            Waktu Sesi
                        </strong>
                        <p class="text-muted">
                            @php
                                $day = '';
                                    if($session->day == 0)
                                        $day = 'Senin';
                                    elseif($session->day == 1)
                                        $day = 'Selasa';
                                    elseif($session->day == 2)
                                        $day = 'Rabu';
                                    elseif($session->day == 3)
                                        $day = 'Kamis';
                                    elseif($session->day == 4)
                                        $day = 'Jum\'at';
                                    elseif($session->day == 5)
                                        $day = 'Sabtu';
                                    elseif($session->day == 6)
                                        $day = 'Minggu';
                            @endphp
                            Hari {{ $day }} Jam {{ $session->time }}
                        </p>
                        <hr>

                        <strong>
                            Alamat
                        </strong>
                        <p class="text-muted">
                            {!! nl2br($session->student->address) !!}
                        </p>
                        <hr>

                        <strong>
                            Lokasi di Google Map
                        </strong>
                        <p class="text-muted">
                        <div class="embed-responsive embed-responsive-16by9">
                            <div id="map_canvas" class="embed-responsive-item">
                                {!! Mapper::render () !!}
                            </div>
                        </div>
                        </p>
                        <hr>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-12">
            <div class="box">
                <div class="box-header">
                    <strong class="text-center">Murid</strong>
                </div>
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" style="width: 250px;"
                         src="{{ backpack_avatar_url($session->student) }}">
                    <h3 class="profile-username text-center">{{ $session->student->name }}</h3>

                    <strong>
                        Deskripsi Diri
                    </strong>
                    <p class="text-muted">
                        {!! $session->student->description==null ? '<span style="color: #ccc">Description is Empty</span>' : $session->student->description !!}
                    </p>
                    <hr>

                    <strong>
                        Jenis Kelamin
                    </strong>
                    <p class="text-muted">
                        {!! $session->student->gender? "<i class='fa fa-fw fa-mars'></i> Laki-laki" : "<i class='fa fa-fw fa-venus'></i> Perempuan" !!}
                    </p>
                    <hr>
                    <strong>
                        Kelas
                    </strong>
                    @if($session->student->grade != null)
                        <p class="text-muted">
                            <span class="label label-default" style="background-color: {{ $session->student->grade->school->color }}; color: #fff;">{{ $session->student->grade->school->name . " " . $session->student->grade->grade }}</span>
                        </p>
                    @endif
                    <hr>

                    <strong>
                        Umur
                    </strong>
                    <p class="text-muted">
                        {{ $session->student->age }}
                    </p>
                    <hr>
                    <strong>
                        Nomor Telepon
                    </strong>
                    <p class="text-muted">
                        {{ $session->student->phone }}
                    </p>
                    <hr>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-12">
            <div class="box">
                <div class="box-header">
                    <strong class="text-center">Pengajar</strong>
                </div>
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" style="width: 250px;"
                         src="{{ backpack_avatar_url($session->teacher) }}">
                    <h3 class="profile-username text-center">{{ $session->teacher->name }}</h3>

                    <strong>
                        Deskripsi Diri
                    </strong>
                    <p class="text-muted">
                        {!! $session->teacher->description==null ? '<span style="color: #ccc">Description is Empty</span>' : $session->teacher->description !!}
                    </p>
                    <hr>

                    <strong>
                        Jenis Kelamin
                    </strong>
                    <p class="text-muted">
                        {!! $session->teacher->gender? "<i class='fa fa-fw fa-mars'></i> Laki-laki" : "<i class='fa fa-fw fa-venus'></i> Perempuan" !!}
                    </p>
                    <hr>

                    <strong>
                        Mata Pelajaran Ahli
                    </strong>
                    <p class="text-muted">
                        @foreach($session->teacher->skills as $skill)
                            <span class="label label-default" style="background-color: {{$skill->color}}; color: #fff;">{{ $skill->name }}</span>
                        @endforeach
                    </p>
                    <hr>
                    <strong>
                        Umur
                    </strong>
                    <p class="text-muted">
                        {{ $session->teacher->age }}
                    </p>
                    <hr>
                    <strong>
                        Nomor Telepon
                    </strong>
                    <p class="text-muted">
                        {{ $session->teacher->phone }}
                    </p>
                    <hr>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
@endsection


@section('after_scripts')
    <!--GooglMapper-->
    <script type="text/javascript">
        function CenterControl(controlDiv, map, lat, lng) {

            // Set CSS for the control border.
            var controlUI = document.createElement('div');
            controlUI.style.backgroundColor = '#0af';
            controlUI.style.border = '2px solid #0af';
            controlUI.style.borderRadius = '3px';
            controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
            controlUI.style.cursor = 'pointer';
            controlUI.style.marginBottom = '20px';
            controlUI.style.textAlign = 'center';
            controlUI.title = 'Click to recenter the map';
            controlDiv.appendChild(controlUI);

            // Set CSS for the control interior.
            var controlText = document.createElement('div');
            controlText.style.color = '#fff';
            controlText.style.fontFamily = 'Roboto,Arial,sans-serif,bold';
            controlText.style.fontSize = '16px';
            controlText.style.lineHeight = '38px';
            controlText.style.paddingLeft = '10px';
            controlText.style.paddingRight = '10px';
            controlText.innerHTML = 'Petunjuk Arah';
            controlUI.appendChild(controlText);

            // Setup the click event listeners
            controlUI.addEventListener('click', function() {
                window.open('https://www.google.com/maps/dir/?api=1&destination=' + lat + ',' + lng, '_blank');
            });

        }

        google.maps.event.addDomListener(window, 'load', function() {

            var centerControlDiv = document.createElement('div');
            var centerControl = new CenterControl(centerControlDiv, maps[0], maps[0].markers[0].position.lat(), maps[0].markers[0].position.lng());

            centerControlDiv.index = 1;
            maps[0].map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);
        });

    </script>
@endsection