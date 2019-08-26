@extends('backpack::layout')

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection

@section('header')
    <section class="content-header">

        <h1>
            {{ $user->name }} Profil
        </h1>

        <ol class="breadcrumb">

            <li>
                <a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a>
            </li>
            <li class="active">
                {{ "Profil Pengguna"}}
            </li>

        </ol>

    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-4 col-xs-12">
            @hasrole('admin|owner')
            @if($user->verified == 0)
                <div class="box box-danger">
                    <div class="box-header">
                        <strong>Verifikasi</strong>
                    </div>
                    <div class="box-body">
                        <strong>Verifikasi Pengguna Ini?</strong>
                    </div>
                    <div class="box-footer">
                    <span class="pull-right">
                        <button class="btn btn-success" data-toggle="modal"
                                data-target="#modal-accept">Verifikasi</button>
                    </span>
                    </div>
                    <div class="modal fade" id="modal-accept" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Verifikasi</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin akan <strong>verifikasi</strong> pengguna ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="{{ route('backpack.page.verify-user', ["id" => $user->id]) }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-success">Verifikasi</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                aria-label="Close">Batal
                                        </button>
                                    </form>
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
                                    <a href="#">
                                        <button type="button" class="btn btn-danger">Tolak</button>
                                    </a>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            @endif
            @endhasrole
            <div class="box">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle"
                         src="{{ backpack_avatar_url($user) }}">
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    @php
                        $roleText = '';
                        if($user->hasRole('admin'))
                            $roleText = 'Admin';
                        else if($user->hasRole('owner'))
                            $roleText = 'Owner';
                        else if($user->hasRole('teacher'))
                            $roleText = 'Pengajar';
                        else if($user->hasRole('student'))
                            $roleText = 'Murid';
                    @endphp
                    <h5 class="profile-username text-center">{{ $roleText }}</h5>
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-md-8  col-xs-12">
            <div class="box padding-10">
                <div class="box-body backpack-profile-form">
                    <div style="font-size: 120%">
                        <strong>
                            Description
                        </strong>
                        <p class="text-muted">
                            {!! $user->description==null ? '<span style="color: #ccc">Description is Empty</span>' : $user->description !!}
                        </p>
                        <hr>

                        @hasanyrole('admin|owner')
                        <strong>
                            Email
                        </strong>
                        <p class="text-muted">
                            {{ $user->email }}
                        </p>
                        <hr>
                        @endhasanyrole

                        @if($user->hasRole('teacher'))
                            <strong>
                                Skills
                            </strong>
                            <p class="text-muted">
                                @foreach($user->skills as $skill)
                                    <span class="label label-default"
                                          style="background-color: {{$skill->color}}; color: #fff;">{{ $skill->name }}</span>
                                @endforeach
                            </p>
                            <hr>
                        @endif
                        <strong>
                            Gender
                        </strong>
                        <p class="text-muted">
                            {!! $user->gender? "<i class='fa fa-fw fa-mars'></i> Male" : "<i class='fa fa-fw fa-venus'></i> Female" !!}
                        </p>
                        <hr>
                        @if($user->hasRole('student'))
                            <strong>
                                Grade
                            </strong>
                            @if($user->grade != null)
                                <p class="text-muted">
                                    <span class="label label-default"
                                          style="background-color: {{ $user->grade->school->color }}; color: #fff;">{{ $user->grade->school->name . " " . $user->grade->grade }}</span>
                                </p>
                            @endif
                            <hr>
                        @endif
                        <strong>
                            Age
                        </strong>
                        <p class="text-muted">
                            {{ $user->age }}
                        </p>
                        <hr>
                        @hasanyrole('admin|owner')
                        <strong>
                            Phone
                        </strong>
                        <p class="text-muted">
                            {{ $user->phone }}
                        </p>
                        <hr>

                        <strong>
                            Address
                        </strong>
                        <p class="text-muted">
                            {!! nl2br($user->address) !!}
                        </p>
                        <hr>

                        <strong>
                            Location
                        </strong>
                        <p class="text-muted">
                        <div class="embed-responsive embed-responsive-16by9">
                            <div id="map_canvas" class="embed-responsive-item">
                                {!! Mapper::render () !!}
                            </div>
                        </div>
                        </p>
                        <hr>
                        @endhasanyrole
                    </div>
                </div>
            </div>
        </div>
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
            controlText.innerHTML = 'Direction';
            controlUI.appendChild(controlText);

            // Setup the click event listeners
            controlUI.addEventListener('click', function () {
                window.open('https://www.google.com/maps/dir/?api=1&destination=' + lat + ',' + lng, '_blank');
            });

        }

        google.maps.event.addDomListener(window, 'load', function () {

            var centerControlDiv = document.createElement('div');
            var centerControl = new CenterControl(centerControlDiv, maps[0], maps[0].markers[0].position.lat(), maps[0].markers[0].position.lng());

            centerControlDiv.index = 1;
            maps[0].map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);
        });


    </script>
@endsection