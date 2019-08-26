@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Pengaturan Sesi
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Pengaturan Sesi</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="box">
                <div class="box-header">
                    <strong>Atur Preferensi</strong>
                </div>
                <form class="form" action="{{ route('backpack.page.teacher_preference') }}" method="post"
                      id="update-preference">

                    {!! csrf_field() !!}

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
                                $label = 'Jenis Kelamin';
                                $field = 'gender';
                                $gender = old($field) ? old($field) : $preference->$field;
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="{{ $field }}" value=1
                                           @if($gender == 1 || $gender == null) checked="" @endif>
                                    Laki-laki
                                </label><br>
                                <label>
                                    <input type="radio" name="{{ $field }}" value=0 @if($gender == 0) checked="" @endif>
                                    Perempuan
                                </label><br>
                                <label>
                                    <input type="radio" name="{{ $field }}" value=2 @if($gender == 2) checked="" @endif>
                                    Semuanya
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Kelas';
                                $field = 'grade_id[]';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <select form="update-preference"
                                    class="form-control select2 select2-hidden-accessible select-grades"
                                    multiple="multiple" data-placeholder="Pilih Kelas" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="{{ $field }}">
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}"
                                            data-color="{{ $grade->school->color }}">{{ $grade->school->name . " " . $grade->grade }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Radius Jarak';
                                $field = 'radius';
                                $value = old($field) ? old($field) : $preference->$field;
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input required class="form-control" type="number" name="{{ $field }}"
                                   value="{{ $value!=null ? $value : 5 }}">
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Hari Sesi';
                                $field = 'days[]';
                                $value = old($field) ? old($field) : $user->$field;
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <select form="update-preference"
                                    class="form-control select2 select2-hidden-accessible select-days"
                                    multiple="multiple" data-placeholder="Pilih Hari Sesi" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="{{ $field }}">
                                //0 : 7-9 | 1: 9-11 | 2: 11-13 | 3: 13-15 | 4: 15-17 | 5: 17-19 | 6: 19-21 | 7:
                                Lain-lain
                                <option value=0>Senin</option>
                                <option value=1>Selasa</option>
                                <option value=2>Rabu</option>
                                <option value=3>Kamis</option>
                                <option value=4>Jumat</option>
                                <option value=5>Sabtu</option>
                                <option value=6>Minggu</option>
                                <option value=7>Insidental</option>
                            </select>
                        </div>

                        <div class="form-group">
                            @php
                                $label = 'Waktu Luang';
                                $field = 'times[]';
                                $value = old($field) ? old($field) : $user->$field;
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <select form="update-preference"
                                    class="form-control select2 select2-hidden-accessible select-times"
                                    multiple="multiple" data-placeholder="Pilih Waktu Luang" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="{{ $field }}">
                                //0 : 7-9 | 1: 9-11 | 2: 11-13 | 3: 13-15 | 4: 15-17 | 5: 17-19 | 6: 19-21 | 7:
                                Lain-lain
                                <option value=0>07:00 - 09:00</option>
                                <option value=1>09:00 - 11:00</option>
                                <option value=2>11:00 - 13:00</option>
                                <option value=3>13:00 - 15:00</option>
                                <option value=4>15:00 - 17:00</option>
                                <option value=5>17:00 - 19:00</option>
                                <option value=6>19:00 - 21:00</option>
                                <option value=7>Insidental</option>
                            </select>
                        </div>

                        <div class="form-group m-b-0">
                            <button type="submit" class="btn btn-success"><span class="ladda-label"><i
                                            class="fa fa-save"></i> {{ trans('backpack::base.save') }}</span></button>
                            <a href="{{ backpack_url() }}" class="btn btn-default"><span
                                        class="ladda-label">{{ trans('backpack::base.cancel') }}</span></a>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}\bower_components\select2\dist\css\select2.min.css">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/adminlte') }}\bower_components\select2\dist\js\select2.full.min.js"></script>
    <!--Select2-->
    <script type="text/javascript">
        var times = {{ json_encode($preference->times) }};
        var days = {{ json_encode($preference->days) }};
        var grades = {{ $preference->grades->pluck('id')->toJson() }};

        $(document).ready(function () {
            console.log(grades);
            $('.select-times').select2({
                allowClear: true,
                templateSelection: function (data, container) {
                    $(container).css("background-color", '#08d');
                    $(container).css("border-color", '#fff');
                    return data.text;
                }
            }).val(times).trigger('change');
            $('.select-days').select2({
                allowClear: true,
                templateSelection: function (data, container) {
                    $(container).css("background-color", '#08d');
                    $(container).css("border-color", '#fff');
                    return data.text;
                }
            }).val(days).trigger('change');
            $('.select-grades').select2({
                allowClear: true,
                templateSelection: function (data, container) {
                    $(container).css("background-color", data.element.dataset.color);
                    $(container).css("border-color", '#fff');
                    return data.text;
                }
            }).val(grades).trigger('change');
        });
    </script>
@endSection
