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
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $sessions->count() }}</h3>

                    <p>Sesi Diajukan</p>
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
                    <h3>{{ $sessions->where('status', 3)->count() }}</h3>

                    <p>Sesi Menunggu Persetujuan Admin</p>
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
                    <h3>{{ $sessions->where('status', 1)->count() }}</h3>

                    <p>Sesi Berjalan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-checkmark-circle"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="box">
                <div class="box-body">

                    <table class="table" id="sessions-list-table">
                        <thead>
                        <tr>
                            <th class="text-center">Murid</th>
                            <th class="text-center">Pengajar</th>
                            <th class="text-center">Mata Pelajaran</th>
                            <th class="text-center">Hari</th>
                            <th class="text-center">Jam</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td>
                                    {!! $session->student->gender? "<span class=\"label label-default\" style=\"background-color:dodgerBlue; color:#fff\"><i class='fa fa-fw fa-mars'></i></span>" : "<span class=\"label label-default\" style=\"background-color:deepPink; color:#fff\"><i class='fa fa-fw fa-venus'></i></span>" !!} {{ $session->student->name }}
                                </td>
                                <td>
                                    {!! $session->teacher->gender? "<span class=\"label label-default\" style=\"background-color:dodgerBlue; color:#fff\"><i class='fa fa-fw fa-mars'></i></span>" : "<span class=\"label label-default\" style=\"background-color:deepPink; color:#fff\"><i class='fa fa-fw fa-venus'></i></span>" !!} {{ $session->teacher->name }}
                                </td>
                                <td><span class="label label-default"
                                          style="background-color: {{$session->subject->color}}; color: #fff;">{{ $session->subject->name }}</span>
                                </td>
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
                                <td>{{ $day }}</td>
                                <td>{{ $session->time }}</td>
                                @if($session->isPending())
                                    <td><span class="label label-warning">Menunggu Persetujuan Tentor</span></td>
                                @elseif($session->isPostponed())
                                    <td><span class="label label-primary">Menunggu Persetujuan Admin</span></td>
                                @elseif($session->isApproved())
                                    <td><span class="label label-success">Sedang Berjalan</span></td>
                                @elseif($session->isRejected())
                                    <td><span class="label label-danger">Selesai/Ditolak</span></td>
                                @endif
                                <td>
                                    <a href="{{ route('backpack.page.owner.session', ['id' => $session->id]) }}">
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
            $('#sessions-list-table').DataTable({
                responsive: true,
            });
        });
    </script>
@endSection
