@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Daftar Mata Pelajaran
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Daftar Mata Pelajaran</li>
        </ol>
    </section>
@endsection

@section('content')
    <a href="{{ route('backpack.page.owner.subjects.add') }}" type="button" class="btn btn-primary btn-block" style="margin-bottom: 20px"><i class="fa fa-plus"></i>
        Tambah Mata Pelajaran
    </a>
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table class="table" id="subjects-list-table">
                        <thead>
                        <tr>
                            <th class="text-center">Mata Pelajaran</th>
                            <th class="text-center">Warna</th>
                            <th class="text-center">Jumlah Sesi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                </td>
                                <td>
                                    <span class="label label-default" style="background-color: {{$subject->color}}; color: #fff;">{{ $subject->color }}</span>
                                </td>
                                <td>
                                    {{ $subject->sessions->count() }}
                                </td>
                                <td>
                                    <a href="{{ route('backpack.page.owner.subjects.edit', ['id' => $subject->id]) }}">
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
            $('#subjects-list-table').DataTable({
                responsive: true,
            });
        });
    </script>
@endSection
