@extends('backpack::layout')

@section('header')
    <section class="content-header">
        @php
            $title = 'Pengguna';
            if($role=='teacher')
                $title = 'Pengajar';
            else if($role=='student')
                $title = 'Siswa';
        @endphp
        <h1>
            Daftar {{ $title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Daftar {{ $title }}</li>
        </ol>
    </section>
@endsection

@section('content')
    @if($role=='teacher' || $role== 'student')
        <div class="row">
            <div class="col-lg-4 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $users->count() }}</h3>

                        <p>Pengguna Terdaftar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-book"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $users->where('verified', 1)->count() }}</h3>

                        <p>Pengguna Terverifikasi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clock"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3>{{ $usersInSessions->count() }}</h3>

                        <p>Pengguna Dalam Sesi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-checkmark-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table class="table" id="users-list-table">
                        <thead>
                        <tr>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Umur</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    {!! $user->gender? "<span class=\"label label-default\" style=\"background-color:dodgerBlue; color:#fff\"><i class='fa fa-fw fa-mars'></i></span>" : "<span class=\"label label-default\" style=\"background-color:deepPink; color:#fff\"><i class='fa fa-fw fa-venus'></i></span>" !!} {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->age }}
                                </td>
                                @if($user->verified == 1)
                                    <td><span class="label label-success">Sudah Diverifikasi</span></td>
                                @else
                                    <td><span class="label label-danger">Belum Diverifikasi</span></td>
                                @endif
                                <td>
                                    <a href="{{ route('backpack.page.user', ['id' => $user->id]) }}">
                                        <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i>
                                            Detil
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables') }}\datatables.min.css">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/datatables') }}\datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#users-list-table').DataTable({
                responsive: true,
            });
        });
    </script>
@endSection
