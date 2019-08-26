@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Tambah Mata Pelajaran Baru
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li>Daftar Mata Pelajaran</li>
            <li class="active">Tambah Mata Pelajaran Baru</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <form class="form" action="{{ route('backpack.page.owner.subjects.create') }}" method="post" id="add-subject">

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
                                $label = 'Nama Mata Pelajaran';
                                $field = 'name';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input required class="form-control" type="text" name="{{ $field }}"
                                   value="{{ old($field) ? old($field) : '' }}">
                        </div>
                        <div class="form-group">
                            <label>Warna Mata Pelajaran</label>

                            <div class="input-group subject-color">
                                <input type="text" name="color" class="form-control" value="{{ old($field) ? old($field) : '#FF0000' }}">

                                <div class="input-group-addon">
                                    <i style="background-color: red;"></i>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group m-b-0">
                            <button type="submit" class="btn btn-success"><span class="ladda-label"><i
                                            class="fa fa-plus"></i> Tambah</span></button>
                            <a href="{{ route('backpack.page.owner.subjects.index') }}" class="btn btn-default"><span
                                        class="ladda-label">{{ trans('backpack::base.cancel') }}</span></a>
                        </div>

                    </div>
                </div>

            </form>
        </div>
        <!-- /.col -->
    </div>
@endsection


@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}\bower_components\bootstrap-colorpicker\dist\css\bootstrap-colorpicker.min.css">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/adminlte') }}\bower_components\bootstrap-colorpicker\dist\js\bootstrap-colorpicker.min.js"></script>
    <script>
        $('.subject-color').colorpicker();
    </script>
@endsection
