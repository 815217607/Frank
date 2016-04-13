@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.access.menus.management') . ' | ' . trans('labels.backend.access.menus.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.menus.management') }}
        <small>{{ trans('labels.backend.access.menus.create') }}</small>
    </h1>
@endsection

@section('content')
    {!! Form::open(['route' => 'admin.access.menus.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.access.menus.create') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="form-group">
                {!! Form::label('menu_name', trans('validation.attributes.backend.access.menus.menu_name'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('menu_name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.menus.menu_name')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('lang_key', trans('validation.attributes.backend.access.menus.lang_key'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('lang_key', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.menus.lang_key')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('url', trans('validation.attributes.backend.access.menus.url'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('url',null, ['class' => 'form-control','placeholder' => trans('validation.attributes.backend.access.menus.url')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('sort', trans('validation.attributes.backend.access.menus.sort'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::number('sort',null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.menus.sort')]) !!}
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('active', trans('validation.attributes.backend.access.menus.active'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('active',null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.menus.active')]) !!}
                </div>
            </div><!--form control-->
            <div class="form-group">
                {!! Form::label('pid_menu', trans('validation.attributes.backend.access.menus.pid_menu'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">



                    <select name="pid" class="form-control">
                        <option value="0">{{ trans('labels.general.none') }}</option>

                        @foreach ($pidmenus as $pidmenu)
                            <option value="{!! $pidmenu->id !!}" >{!! $pidmenu->menu_name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('pid_name', trans('validation.attributes.backend.access.menus.associated_permissions'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    <select name="permission_id" class="form-control">
                        <option value="">{{ trans('labels.general.none') }}</option>

                        @foreach ($permissions as $permission)
                            <option value="{!! $permission->id !!}">{!! $permission->display_name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div><!--form control-->

            <div class="form-group">
                {!! Form::label('url_falg', trans('validation.attributes.backend.access.menus.url_falg'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    <label>
                        {!! Form::radio('url_falg', '0',true) !!}路由名</label>
                    <label>
                        {!! Form::radio('url_falg', '1') !!}路由uri</label>
                </div>
            </div><!--form control-->
            <div class="form-group">
                {!! Form::label('lang_falg', trans('validation.attributes.backend.access.menus.lang_falg'), ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">


                    <label> {!! Form::radio('lang_falg', '0') !!}是</label>
                    <label> {!! Form::radio('lang_falg', '1',true) !!}否</label>

                </div>
            </div><!--form control-->
            {{--<div class="form-group">--}}
                {{--<label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.menus.confirmed') }}</label>--}}
                {{--<div class="col-lg-1">--}}
                    {{--<input type="checkbox" value="1" name="confirmed" checked="checked" />--}}
                {{--</div>--}}
            {{--</div><!--form control-->--}}

            {{--<div class="form-group">--}}
                {{--<label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.menus.send_confirmation_email') }}<br/>--}}
                    {{--<small>{{ trans('strings.backend.access.menus.if_confirmed_off') }}</small>--}}
                {{--</label>--}}
                {{--<div class="col-lg-1">--}}
                    {{--<input type="checkbox" value="1" name="confirmation_email" />--}}
                {{--</div>--}}
            {{--</div><!--form control-->--}}


        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-body">
            <div class="pull-left">
                <a href="{{route('admin.access.menus.index')}}" class="btn btn-danger btn-xs">{{ trans('buttons.general.cancel') }}</a>
            </div>

            <div class="pull-right">
                <input type="submit" class="btn btn-success btn-xs" value="{{ trans('buttons.general.crud.create') }}" />
            </div>
            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->

    {!! Form::close() !!}
@stop

@section('after-scripts-end')
    {!! Html::script('js/backend/access/permissions/script.js') !!}
    {!! Html::script('js/backend/access/menus/script.js') !!}
@stop
