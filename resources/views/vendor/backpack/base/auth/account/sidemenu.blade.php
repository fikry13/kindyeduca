<div class="box">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle"
             src="{{ backpack_avatar_url(backpack_auth()->user()) }}">
        <h3 class="profile-username text-center">{{ backpack_auth()->user()->name }}</h3>
    </div>

    <ul class="nav nav-pills nav-stacked">

        <li role="presentation"
            @if (Request::route()->getName() == 'backpack.account.show')
            class="active"
                @endif
        ><a href="{{ route('backpack.account.show') }}">Profil</a></li>

        <li role="presentation"
            @if (Request::route()->getName() == 'backpack.account.info')
            class="active"
                @endif
        ><a href="{{ route('backpack.account.info') }}">Ubah Info Pribadi</a></li>

        <li role="presentation"
            @if (Request::route()->getName() == 'backpack.account.avatar')
            class="active"
                @endif
        ><a href="{{ route('backpack.account.avatar') }}">Ubah Foto Profil</a></li>

        <li role="presentation"
            @if (Request::route()->getName() == 'backpack.account.password')
            class="active"
                @endif
        ><a href="{{ route('backpack.account.password') }}">Ubah Password</a></li>

    </ul>
</div>
