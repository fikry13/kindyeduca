@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection

@section('content')
    @verifiedUser
    @else
        <div class="alert alert-warning">
            <h4><i class="icon fa fa-ban"></i> PERINGATAN!</h4>
            Profil anda belum diverifikasi oleh Admin!
        </div>
        @endverifiedUser
        <div class="row">
            <div class="col-md-12">
                @hasAvatar
                @else
                    <div class="alert alert-danger">
                        <h4><i class="icon fa fa-ban"></i> PERHATIAN!</h4>
                        Anda belum memasang foto profil. <a href="{{ route('backpack.account.avatar') }}">Pasang foto
                            Anda di sini!</a>
                    </div>
                    @endhasAvatar
                    @completeProfile
                    @else
                        @hasanyrole('student|teacher')
                        <div class="alert alert-danger">
                            <h4><i class="icon fa fa-ban"></i> PERHATIAN!</h4>
                            Profil anda belum lengkap! <a href="{{ route('backpack.account.info') }}">Lengkapi Profil
                                Anda di sini!</a>
                        </div>
                        @endhasrole
                        @endcompleteProfile
                        <div class="box">
                            <div class="box-header with-border">
                                <div class="box-title">{{ trans('backpack::base.login_status') }}</div>
                            </div>

                            <div class="box-body">{{ trans('backpack::base.logged_in') }}</div>
                        </div>
                        @role('admin')
                        ADMIN
                        @elserole('owner')
                        @elserole('teacher')
                        @include('backpack::dashboard-teacher')
                        @elserole('student')
                        STUDENT
                        @include('backpack::dashboard-student')
                        @endrole

            </div>
        </div>
@endsection
