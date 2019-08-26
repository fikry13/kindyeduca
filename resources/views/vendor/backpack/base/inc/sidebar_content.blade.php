<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@hasrole('admin')
    <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
            <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
            <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
        </ul>
    </li>
    <li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
    <li><a href='{{ url(config('backpack.base.route_prefix') . '/setting') }}'><i class='fa fa-cog'></i> <span>Settings</span></a></li>
    <li><a href='{{ url(config('backpack.base.route_prefix').'/log') }}'><i class='fa fa-terminal'></i> <span>Logs</span></a></li>
@endhasrole
@hasanyrole('owner')
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard Admin</span></a></li>
<li><a href="{{ route('backpack.page.owner.subjects.index') }}"><i class="fa fa-dashboard"></i> <span>Mata Pelajaran</span></a></li>
<li><a href="{{ route('backpack.page.owner.users', ['role' => 'student']) }}"><i class="fa fa-dashboard"></i> <span>Siswa</span></a></li>
<li><a href="{{ route('backpack.page.owner.users', ['role' => 'teacher']) }}"><i class="fa fa-dashboard"></i> <span>Pengajar</span></a></li>
<li><a href="{{ route('backpack.page.owner.sessions') }}"><i class="fa fa-dashboard"></i> <span>Sesi Bimbingan</span></a></li>
@endhasanyrole
@hasrole('teacher')
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard Guru</span></a></li>
<li><a href="{{ route('backpack.page.sessions') }}"><i class="fa fa-book"></i> <span>Sesi Bimbingan</span></a></li>
<li><a href="{{ route('backpack.page.teacher_preference') }}"><i class="fa fa-gear"></i> <span>Pengaturan Bimbingan</span></a></li>
@endhasrole
@hasrole('student')
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard Murid</span></a></li>
<li><a href="{{ route('backpack.page.student-sessions') }}"><i class="fa fa-book"></i> <span>Sesi Bimbingan</span></a></li>
@endhasrole