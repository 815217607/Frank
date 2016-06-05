<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                {{--<img src="{!! access()->user()->picture !!}" class="img-circle" alt="User Image" />--}}
                <img src="{{asset('/img/64e1b8d34f425d19e1ee2ea7236d3028.png')}}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{!! access()->user()->name !!}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('strings.backend.general.status.online') }}</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('strings.backend.general.search_placeholder') }}"/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @permission('view-access-management')
            <li class="header">{{ trans('menus.backend.sidebar.general') }}</li>

            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Active::pattern('admin/dashboard') }}">
                <a href="{!! route('admin.dashboard') !!}"><span>{{ trans('menus.backend.sidebar.dashboard') }}</span></a>
            </li>
            @endauth
            {{--<!--系统自带菜单-->--}}
            {{--<li class="{{ Active::pattern('admin/access/*') }} treeview">--}}
                {{--<a href="#">--}}
                    {{--<span>{{ trans('menus.backend.access.title') }}</span>--}}
                    {{--<i class="fa fa-angle-left pull-right"></i>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu {{ Active::pattern('admin/access/*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/access/*', 'display: block;') }}">--}}

                    {{--@permission('user-view-management')--}}
                    {{--<li class="{{ Active::pattern('admin/access/users/*') }}">--}}
                        {{--<a href="{!!url('admin/access/users')!!}"><span>{{ trans('menus.backend.access.title') }}</span></a>--}}
                    {{--</li>--}}
                    {{--@endauth--}}
                    {{--@permission('roles-view-management')--}}
                    {{--<li class="{{ Active::pattern('admin/access/roles/*') }}">--}}
                        {{--<a href="{!!url('admin/access/roles')!!}"><span>{{ trans('menus.backend.access.roles.management') }}</span></a>--}}
                    {{--</li>--}}
                    {{--@endauth--}}
                    {{--@permission('permissions-view-management')--}}
                    {{--<li class="{{ Active::pattern('admin/access/permissions*') }}">--}}
                        {{--<a href="{{ route('admin.access.permissions.index') }}#all-permissions"><span>{{ trans('menus.backend.access.permissions.management') }}</span></a>--}}
                    {{--</li>--}}
                    {{--@endauth--}}
                    {{--@permission('group-view-management')--}}
                    {{--<li class="{{ Active::pattern('admin/access/groups*') }}">--}}
                        {{--<a href="{{ route('admin.access.groups.permission-group.index')}}"><span>{{ trans('menus.backend.access.permissions.groups.management') }}</span></a>--}}
                        {{--<a href="{!! route('admin.access.groups.permission-group.index') !!}#groups"><span>{{ trans('menus.backend.access.permissions.groups.management') }}</span></a>--}}
                    {{--</li>--}}
                    {{--@endauth--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--@permission('menu-view-management')--}}
            {{--<!-- Optionally, you can add icons to the links -->--}}
            {{--<li class="{{ Active::pattern('admin/access/menus*') }}">--}}
                {{--<a href="{!! route('admin.access.menus.index') !!}"><span>{{ trans('menus.backend.access.menus.management') }}</span></a>--}}
            {{--</li>--}}
            {{--@endauth--}}
            <!-- your setting permission menu -->
            @if($menu_info)
            @foreach($menu_info as $key=>$val)
            @permission($val['permission_name'])
                @if(isset($val['children']))
                    <!-- Optionally, you can add icons to the links -->
                    <li class="Hehe {{ Active::pattern($val['active']) }} treeview">
                        <a href="#"><span>{{ $val['lang_falg']?trans($val['lang_key']):$val['menu_name'] }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu menu-open" style="display: none; {{ Active::pattern($val['active'], 'display: block;') }}">
                            @foreach($val['children'] as $v)
                            <li class="{{Active::pattern($v['active'])}}">
                                <a href="{!! $v['url_falg']?url($v['url']):route($v['url']) !!}">
                                    <span>{{ $v['lang_falg']?trans($v['lang_key']):$v['menu_name'] }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <!-- Optionally, you can add icons to the links -->
                    <li class="{{ Active::pattern($val['active']) }}">
                        <a href="{!! $val['url_falg']?url($val['url']):route($val['url']) !!}"><span>{{ $val['lang_falg']?trans($val['lang_key']):$val['menu_name'] }}</span></a>
                    </li>
                @endif
            @endauth
            @endforeach
            @endif

            @permission('login-view-management')
           <li class="{{ Active::pattern('admin/log-viewer*') }} treeview">
                <a href="#">
                    <span>{{ trans('menus.backend.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ Active::pattern('admin/log-viewer*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/log-viewer*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/log-viewer') }}">
                        <a href="{!! url('admin/log-viewer') !!}">{{ trans('menus.backend.log-viewer.dashboard') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/log-viewer/logs') }}">
                        <a href="{!! url('admin/log-viewer/logs') !!}">{{ trans('menus.backend.log-viewer.logs') }}</a>
                    </li>
                </ul>
            </li>
         @endauth
        </ul><!-- /.sidebar-menu -->


    </section>
    <!-- /.sidebar -->
</aside>

<script src="{{asset('/js/vendor/jquery/jquery-2.1.4.min.js')}}"></script>
<script type="application/javascript">




</script>