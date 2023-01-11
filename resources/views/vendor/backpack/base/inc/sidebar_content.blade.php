<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Авторизация</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('users') }}"><i class="nav-icon la la-user"></i> <span>Пользователи</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Роли</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Разрешения</span></a></li>
    </ul>
</li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('project') }}'><i class='nav-icon la la-question'></i> Проекты</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('task') }}'><i class='nav-icon la la-question'></i> Tasks</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('stage') }}'><i class='nav-icon la la-question'></i> Stages</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('priority') }}'><i class='nav-icon la la-question'></i> Приоритеты</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('status') }}'><i class='nav-icon la la-question'></i> Statuses</a></li>
<!--<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user-project') }}'><i class='nav-icon la la-question'></i> Project User</a></li>-->
