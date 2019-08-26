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
            {{ trans('backpack::base.my_account') }}
        </h1>

        <ol class="breadcrumb">

            <li>
                <a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a>
            </li>

            <li>
                <a href="{{ route('backpack.account.info') }}">{{ trans('backpack::base.my_account') }}</a>
            </li>

            <li class="active">
                {{ trans('backpack::base.update_account_info') }}
            </li>

        </ol>

    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-xs-12">
            @include('backpack::auth.account.sidemenu')
        </div>
        <div class="col-lg-6 col-md-8 col-xs-12">
            <div class="box padding-10">
                <div class="box-body backpack-profile-form">
                    <div style="font-size: 120%">
                        @hasanyrole('student|teacher')
                        <strong>
                            Deskripsi
                        </strong>
                        <p class="text-muted">
                            {!! $user->description==null ? '<span style="color: #ccc">Description is Empty</span>' : $user->description !!}
                        </p>
                        <hr>
                        @endhasrole

                        <strong>
                            Email
                        </strong>
                        <p class="text-muted">
                            {{ $user->email }}
                        </p>
                        <hr>

                        @hasanyrole('student|teacher')

                        @hasrole('teacher')
                        <strong>
                            Keahlian
                        </strong>
                        <p class="text-muted">
                            @foreach($user->skills as $skill)
                                <span class="label label-default" style="background-color: {{$skill->color}}; color: #fff;">{{ $skill->name }}</span>
                            @endforeach
                        </p>
                        <hr>
                        @endhasrole
                        <strong>
                            Jenis Kelamin
                        </strong>
                        <p class="text-muted">
                            {!! $user->gender? "<i class='fa fa-fw fa-mars'></i> Male" : "<i class='fa fa-fw fa-venus'></i> Female" !!}
                        </p>
                        <hr>
                        @hasrole('student')
                        <strong>
                            Kelas
                        </strong>
                        @if($user->grade != null)
                        <p class="text-muted">
                            <span class="label label-default" style="background-color: {{ $user->grade->school->color }}; color: #fff;">{{ $user->grade->school->name . " " . $user->grade->grade }}</span>
                        </p>
                        @endif
                        <hr>
                        @endhasrole
                        <strong>
                            Umur
                        </strong>
                        <p class="text-muted">
                            {{ $user->age }}
                        </p>
                        <hr>

                        <strong>
                            Nomor Telepon
                        </strong>
                        <p class="text-muted">
                            {{ $user->phone }}
                        </p>
                        <hr>

                        <strong>
                            Alamat
                        </strong>
                        <p class="text-muted">
                            {!! nl2br($user->address) !!}
                        </p>
                        <hr>

                        <strong>
                            Lokasi di Peta
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