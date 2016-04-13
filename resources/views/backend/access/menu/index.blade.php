@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.access.roles.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.access.menus.management') }}</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.access.menus.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('labels.backend.access.menus.table.id') }}</th>
                        <th>{{ trans('labels.backend.access.menus.table.menu_name') }}</th>
                        <th>{{ trans('labels.backend.access.menus.table.url') }}</th>
                        <th>{{ trans('labels.backend.access.menus.table.lang_key') }}</th>
                        <th>{{ trans('labels.backend.access.menus.table.created_at') }}</th>
                        <th>{{ trans('labels.backend.access.menus.table.updated_at') }}</th>
                        <th>{{ trans('labels.backend.access.menus.table.sort') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($menu as $row)
                            <tr>
                                <td>{!! $row->id !!}</td>
                                <td>
                                    {!! $row->menu_name !!}
                                    {{--@if ($row->all)--}}
                                        {{--<span class="label label-success">{{ trans('labels.general.all') }}</span>--}}
                                    {{--@else--}}
                                        {{--<span class="label label-danger">{{ trans('labels.general.none') }}</span>--}}
                                    {{--@endif--}}
                                </td>
                                <td>{!! $row->url !!}</td>
                                <td>{!! $row->lang_key !!}</td>
                                <td>{!! $row->created_at !!}</td>
                                <td>{!! $row->updated_at !!}</td>
                                <td>{!! $row->sort !!}</td>
                                <td>{!! $row->action_buttons !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-left">
                {{ $menu->total() }} {{ trans_choice('labels.backend.access.roles.table.total', $menu->total()) }}
            </div>

            <div class="pull-right">
                {{ $menu->render() }}
            </div>

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->
@stop
