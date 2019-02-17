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
        <div class="col-md-3">
            @include('backpack::auth.account.sidemenu')
        </div>
        <div class="col-md-6">

            <form class="form" action="{{ route('backpack.account.info') }}" method="post" id="update-info">

                {!! csrf_field() !!}

                <div class="box padding-10">

                    <div class="box-body backpack-profile-form">

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->count())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                            <div class="form-group">
                                @php
                                    $label = 'Avatar';
                                    $field = 'avatar';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <button type="submit" class="btn btn-success form-control"><span class="ladda-label"><i
                                                class="fa fa-save"></i>Upload New Avatar</span></button>
                            </div>

                            <div class="form-group">
                                @php
                                    $label = trans('backpack::base.name');
                                    $field = 'name';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input required class="form-control" type="text" name="{{ $field }}"
                                       value="{{ old($field) ? old($field) : $user->$field }}">
                            </div>

                        <div class="form-group">
                            @php
                                $label = config('backpack.base.authentication_column_name');
                                $field = backpack_authentication_column();
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input required class="form-control"
                                   type="{{ backpack_authentication_column()=='email'?'email':'text' }}"
                                   name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                        </div>
                        @hasanyrole('student|teacher')
                        <div class="form-group">
                            @php
                                $label = 'Gender';
                                $field = 'gender';
                                $gender = old($field) ? old($field) : $user->$field;
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="{{ $field }}" value=1
                                           @if($gender == 1 || $gender == null) checked="" @endif>
                                    Male
                                </label><br>
                                <label>
                                    <input type="radio" name="{{ $field }}" value=0 @if($gender == 0) checked="" @endif>
                                    Female
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            @php
                                $label = 'Address';
                                $field = 'address';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <textarea required class="form-control" rows="3" placeholder="Alamat tempat tinggal"
                                      name="{{ $field }}"
                                      style="resize: none;">{{ old($field) ? old($field) : $user->$field }}</textarea>
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Age';
                                $field = 'age';
                                $value = old($field) ? old($field) : $user->$field;
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input required class="form-control" type="number" name="{{ $field }}"
                                   value="{{ $value!=null ? $value : 5 }}">
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Phone Number';
                                $field = 'phone';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input required class="form-control" type="text"
                                   name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Description';
                                $field = 'description';
                            @endphp
                            <label>{{ $label }}</label>
                            <textarea class="form-control" rows="3" placeholder="Deskripsi diri" name="{{ $field }}"
                                      style="resize: none;">{{ old($field) ? old($field) : $user->$field }}</textarea>
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Skill';
                                $field = 'skill_id[]';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <select form="update-info"
                                    class="form-control select2 select2-hidden-accessible select-skill"
                                    multiple="multiple" data-placeholder="Select Skill" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="{{ $field }}">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                            data-color="{{ $subject->color }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Grade';
                                $field = 'grade_id';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <select form="update-info"
                                    class="form-control select2 select2-hidden-accessible select-grade"
                                    data-placeholder="Select Grade" style="width: 100%;" tabindex="-1"
                                    aria-hidden="true" name="{{ $field }}">
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}"
                                            @if($user->grade_id == $grade->id) selected="selected" @endif>{{ $grade->school->name . " " . $grade->grade }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Distance';
                                $field = 'distance';
                                $value = old($field) ? old($field) : $user->$field;
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input required class="form-control" type="number" name="{{ $field }}"
                                   value="{{ $value!=null ? $value : 5 }}">
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Location';
                                $field = 'location';
                            @endphp
                            <label class="required">{{ $label }}</label>

                            <form id="form-location" action="{{ route('get-location') }}"
                                  method="post">
                                <div class="form-group">
                                    <input class="form-control" id="location" type="text"
                                           name="{{ $field }}"
                                           value="{{ old($field) ? old($field) : $user->$field }}">
                                </div>
                            </form>

                            <div style="width: 500px; height: 500px;">
                                {!! Mapper::render() !!}
                            </div>
                            <input hidden required id="location-latitude" type="text"
                                   name="latitude"
                                   value="{{ old('latitude') ? old('latitude') : $user->latitude }}">
                            <input hidden required id="location-longitude" type="text"
                                   name="longitude"
                                   value="{{ old('longitude') ? old('longitude') : $user->longitude }}">
                        </div>

                        @endhasanyrole

                        <div class="form-group m-b-0">
                            <button type="submit" class="btn btn-success"><span class="ladda-label"><i
                                            class="fa fa-save"></i> {{ trans('backpack::base.save') }}</span></button>
                            <a href="{{ backpack_url() }}" class="btn btn-default"><span
                                        class="ladda-label">{{ trans('backpack::base.cancel') }}</span></a>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection

@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}\bower_components\select2\dist\css\select2.min.css">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/adminlte') }}\bower_components\select2\dist\js\select2.full.min.js"></script>
    <!--Select2-->
    <script type="text/javascript">
        var skill = {{ $user->skills->pluck('id')->toJson() }};

        $(document).ready(function () {
            $('.select-skill').select2({
                allowClear: true,
                templateSelection: function (data, container) {
                    $(container).css("background-color", data.element.dataset.color);
                    $(container).css("border-color", '#fff');
                    return data.text;
                }
            }).val(skill).trigger('change');

            $('.select-grade').select2();
        });
    </script>
    <!--GooglMapper-->
    <script type="text/javascript">
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('location'));
        var form_location = $('#form-location');
        var input_lat = document.getElementById('location-latitude');
        var input_long = document.getElementById('location-longitude');

        console.log('Out:' + maps[0]);

        form_location.on('submit', function (e) {
            e.preventDefault();
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            console.log('in:' + maps[0]);
            if (!place.geometry) {
                o9090909090
                $.ajax({
                    type: "POST",
                    url: form_location.attr('action'),
                    data: form_location.serialize(),
                    success: function (location) {
                        var latLng = new google.maps.LatLng(location.latitude, location.longitude);
                        maps[0].map.setCenter(latLng);
                        new google.maps.Marker({
                            position: latLng,
                            map: maps[0].map,
                            draggable: true,
                            title: 'Your Location'
                        });
                    }
                });
            }
            else {
                maps[0].map.setCenter(place.geometry.location);
                maps[0].markers[0].setPosition(place.geometry.location);
            }
            input_lat.value = maps[0].markers[0].position.lat();
            input_long.value = maps[0].markers[0].position.lng();
            console.log('Change Place: ' + maps[0].markers[0].position.lat() + ', ' + maps[0].markers[0].position.lng());
        });

        function markerDragEnd(event) {
            console.log('Marker Drag: ' + event.latLng.lat() + ', ' + event.latLng.lng());
            input_lat.value = event.latLng.lat();
            input_long.value = event.latLng.lng();
        };

        function mapBeforeLoad(event) {
            //console.log(maps);
        }
    </script>
@endsection
