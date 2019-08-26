@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Daftar Sesi
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Daftar Sesi</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="modal fade" id="modal-detail" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Detil Guru</h4>
                </div>
                <div class="modal-body">
                    <img id="d-avatar" class="profile-user-img img-responsive img-circle" style="width: 250px;"
                         src="{{ backpack_avatar_url($user) }}">
                    <h3 id="d-name" class="profile-username text-center">{{ $user->name }}</h3>

                    <strong>
                        Deskripsi Diri
                    </strong>
                    <p class="text-muted" id="d-description">
                        {!! $user->description==null ? '<span style="color: #ccc">Description is Empty</span>' : $user->description !!}
                    </p>
                    <hr>

                    <strong>
                        Jenis Kelamin
                    </strong>
                    <p class="text-muted" id="d-gender">
                        {!! $user->gender? "<i class='fa fa-fw fa-mars'></i> Laki-laki" : "<i class='fa fa-fw fa-venus'></i> Perempuan" !!}
                    </p>
                    <hr>
                    <strong>
                        Umur
                    </strong>
                    <p class="text-muted" id="d-age">
                        {{ $user->age }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <form action="{{ route('backpack.page.new-student-session.add') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="student_id" id="selected-user">
                        <input type="hidden" name="teacher_id" id="selected-teacher">
                        <input type="hidden" name="subject_id" id="selected-subject">
                        <input type="hidden" name="gender_preference" id="selected-gender">
                        <input type="hidden" name="day" id="selected-day">
                        <input type="hidden" name="time" id="selected-time">
                        <button type="submit" class="btn btn-success" id="make-new-session">Ajukan Sesi</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
        <div class="col-lg-12 col-xs-12">
            <div class="box">
                <div class="box-body">
                    <form class="form" id="find-session">

                        {!! csrf_field() !!}

                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                @php
                                    $label = 'Mapel';
                                    $field = 'skill';
                                @endphp
                                <label for="select-subject" class="required">{{ $label }}</label>
                                <select form="find-session"
                                        class="form-control select2 select2-hidden-accessible select-skill"
                                        data-placeholder="Pilih Mapel" style="width: 100%;"
                                        tabindex="-1" aria-hidden="true" name="{{ $field }}" id="select-skill">
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                                data-color="{{ $subject->color }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                @php
                                    $label = 'Gender';
                                    $field = 'gender';
                                    $gender = old($field) ? old($field) : $user->$field;
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="{{ $field }}" name="{{ $field }}" value=1
                                               @if($gender == 1 || $gender == null) checked="" @endif>
                                        Male
                                    </label><br>
                                    <label>
                                        <input type="radio" id="{{ $field }}" name="{{ $field }}" value=0 @if($gender == 0) checked="" @endif>
                                        Female
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                @php
                                    $label = 'Hari Sesi';
                                    $field = 'day';
                                    $value = old($field) ? old($field) : $user->$field;
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <select form="find-session"
                                        class="form-control select2 select2-hidden-accessible select-days"
                                        data-placeholder="Pilih Hari Sesi" style="width: 100%;"
                                        tabindex="-1" aria-hidden="true" name="{{ $field }}" id="select-day">
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
                                    $field = 'time';
                                    $value = old($field) ? old($field) : $user->$field;
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <select form="find-session"
                                        class="form-control select2 select2-hidden-accessible select-times"
                                        data-placeholder="Pilih Waktu Sesi" style="width: 100%;"
                                        tabindex="-1" aria-hidden="true" name="{{ $field }}" id="select-time">
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

                        </div>
                        <button href="{{ route('backpack.page.new-student-session') }}" type="submit" class="btn btn-primary btn-block" style="margin-bottom: 20px"><i class="fa fa-search"></i>
                            Cari Sesi Baru
                        </button>
                    </form>
                </div>
            </div>
            <div class="box">
                <div class="box-body">

                    <table class="table" id="sessions-list-table">
                        <thead>
                        <tr>
                            <th class="text-center">Mata Pelajaran</th>
                            <th class="text-center">Tentor</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}\bower_components\select2\dist\css\select2.min.css">
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables') }}\datatables.min.css">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/adminlte') }}\bower_components\select2\dist\js\select2.full.min.js"></script>
    <script src="{{ asset('vendor/datatables') }}\datatables.min.js"></script>

    <script>
        $(document).on('click', '#show-detail', function (e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: '{{ route('backpack.page.new-student-session.get-teacher') }}',
                data: {
                    id: $(this).data('id')
                },
                success:function (user) {
                    $('#selected-subject').val($('#select-skill').val());
                    $('#selected-teacher').val(user.id);
                    $('#selected-day').val($('#select-day').val());
                    $('#selected-time').val($('#select-time').val());
                    $('#selected-gender').val($('#gender:checked').val());
                    $('#selected-user').val({{ $user->id }});
                    $('#d-name').text(user.name);
                    $('#d-description').text('');
                    $('#d-description').append(user.description == null ? $.parseHTML('<span style="color: #ccc">Description is Empty</span>') : user.description);
                    $('#d-gender').text('');
                    $('#d-gender').append(user.gender === 1? $.parseHTML('<i class=\'fa fa-fw fa-mars\'></i> Laki-laki') : $.parseHTML('<i class=\'fa fa-fw fa-venus\'></i> Perempuan'));
                    $('#d-age').text(user.age);
                    $('#d-avatar').attr('src', 'http://kindyeduca.fikry13.com/storage/avatar/'+user.id+'/'+user.avatar);
                    $('#modal-detail').modal().show();
                }
            });
        });
        $(document).ready(function () {
            var table = $('#sessions-list-table').DataTable({
                responsive: true
            });

            $('.select-skill').select2();
            $('.select-times').select2();
            $('.select-days').select2();

            $('#find-session').on('submit', function(e) {
                e.preventDefault();
                var skill = $('#select-skill').val();
                var gender = $('#gender:checked').val();
                var day = $('#select-day').val();
                var time = $('#select-time').val();
                var token = "{{ csrf_token() }}";
                var skillName = $('#select-skill option:selected').text();

                table.clear();
                table.destroy();
                table = $('#sessions-list-table').DataTable({
                    ajax: {
                        dataSrc: function (json) {
                            var return_data = new Array();
                            for(var i=0;i< json.length; i++){
                                return_data.push({
                                    'skill': skillName,
                                    'name': json[i].name,
                                    'gender'  : json[i].gender===0?'Perempuan':'Laki-laki',
                                    'action' : '<button type="button" class="btn btn-primary btn-xs" id="show-detail" data-id='+ json[i].id +'><i class="fa fa-eye"></i> Detil</button>'
                                })
                            }
                            return return_data;
                        },
                        type: "GET",
                        url: '{{ route('backpack.page.new-student-session.get') }}',
                        data: {
                            skill: skill,
                            gender: gender,
                            day: day,
                            time: time,
                            _token: token
                        }
                    },
                    responsive: true,
                    columns:
                        [
                            { data: 'skill' },
                            { data: 'name' },
                            { data: 'gender' },
                            { data: 'action' },
                        ]
                });

            });
        });
    </script>
@endSection
