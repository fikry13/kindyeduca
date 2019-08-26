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

            <form class="form" action="{{ route('backpack.account.avatar') }}" method="post" id="update-avatar">

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
                                $label = 'Foto Profil';
                                $field = 'avatar';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <div id="upload-image"></div>
                        </div>

                        <div class="form-group">
                            <input type="file" id="upload" value="Pilih Foto" accept="image/*">
                        </div>

                        <div class="form-group m-b-0">
                            <input required class="form-control" type="hidden" id="avatar-upload" name="{{ $field }}"
                                   value="{{ old($field) ? old($field) : $user->$field }}">
                            <button type="button" type="submit" id="upload-result" class="btn btn-success form-control">
                                <i class="fa fa-save"></i> Upload Foto Baru
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection

@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/croppie/') }}\croppie.css"/>
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/croppie/') }}\croppie.min.js"></script>
    <!--Croppie-->
    <script type="text/javascript">
        var imageUrl = '{{ $user->avatar_url }}';

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                console.log("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#upload-image').croppie({
            viewport: {
                width: 300,
                height: 300,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            },
            enableExif: true
        });

        $('#upload').on('change', function () {
            readFile(this);
        });

        $('#upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                size: 'viewport',
                circle: false,
            }).then(function (resp) {
                console.log(resp);
                $("#avatar-upload").val(resp);
                $("#update-avatar").submit();
            });
        });

        $uploadCrop.croppie('bind', {
            url: imageUrl
        });

    </script>
@endsection
