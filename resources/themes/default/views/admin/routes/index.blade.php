@extends('layouts.master')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {!! Form::open( array('route' => 'admin.routes.save-perms', 'id' => 'frmRouteList') ) !!}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin/routes/general.page.index.table-title') }}</h3>
                        &nbsp;
                        <a class="btn btn-default btn-sm" href="{!! route('admin.routes.create') !!}" title="{{ trans('admin/routes/general.action.create') }}">
                            <i class="fa fa-plus-square"></i>
                        </a>
                        &nbsp;
                        <a class="btn btn-default btn-sm" href="{!! route('admin.routes.load') !!}" title="{{ trans('admin/routes/general.action.load-routes') }}">
                            <i class="fa fa-refresh"></i>
                        </a>
                        &nbsp;
                        <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmRouteList'].action = '{!! route('admin.routes.enable-selected') !!}';  document.forms['frmRouteList'].submit(); return false;" title="{{ trans('general.button.enable') }}">
                            <i class="fa fa-check-circle-o"></i>
                        </a>
                        &nbsp;
                        <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmRouteList'].action = '{!! route('admin.routes.disable-selected') !!}';  document.forms['frmRouteList'].submit(); return false;" title="{{ trans('general.button.disable') }}">
                            <i class="fa fa-ban"></i>
                        </a>
                        &nbsp;
                        <a class="btn btn-default btn-sm" href="#" onclick="document.forms['frmRouteList'].action = '{!! route('admin.routes.save-perms') !!}';  document.forms['frmRouteList'].submit(); return false;" title="{{ trans('admin/routes/general.action.save-perms-assignment') }}">
                            <i class="fa fa-floppy-o"></i>
                        </a>
                        &nbsp;
                        {!! Form::select( 'globalPerm', $perms, '', [ 'style' => 'max-width:150px;'] ) !!}

                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="table-responsive">
                            <table style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">
                                            <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                                <i class="fa fa-check-square-o"></i>
                                            </a>
                                        <th style="text-align: center">
                                        <th>{{ trans('admin/routes/general.columns.permission') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.method') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.path') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.name') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.action_name') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.actions') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center">
                                            <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                                <i class="fa fa-check-square-o"></i>
                                            </a>
                                        <th style="text-align: center">
                                        <th>{{ trans('admin/routes/general.columns.permission') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.method') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.path') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.name') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.action_name') }}</th>
                                        <th>{{ trans('admin/routes/general.columns.actions') }}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($routes as $route)
                                        <tr>
                                            <td align="center">{!! Form::checkbox('chkRoute[]', $route->id); !!}</td>
                                            <td>{!! Form::select( 'perms['. $route->id .']', $perms, (isset($route->permission)?$route->permission->id:''), [ 'style' => 'max-width:150px;'] ) !!}</td>
                                            <td>{!! link_to_route('admin.routes.show', $route->method, [$route->id], []) !!}</td>
                                            <td>{!! link_to_route('admin.routes.show', $route->path, [$route->id], []) !!}</td>
                                            @if ('' != $route->name)
                                                <td>{!! link_to_route('admin.routes.show', $route->name, [$route->id], []) !!}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>{!! link_to_route('admin.routes.show', $route->action_name, [$route->id], []) !!}</td>
                                            <td>
                                                <a href="{!! route('admin.routes.edit', $route->id) !!}" title="{{ trans('general.button.edit') }}"><i class="fa fa-pencil-square-o"></i></a>

                                                @if ( $route->enabled )
                                                    <a href="{!! route('admin.routes.disable', $route->id) !!}" title="{{ trans('general.button.disable') }}"><i class="fa fa-ban"></i></a>
                                                @else
                                                    <a href="{!! route('admin.routes.enable', $route->id) !!}" title="{{ trans('general.button.enable') }}"><i class="fa fa-check-circle-o"></i></a>
                                                @endif

                                                <a href="{!! route('admin.routes.confirm-delete', $route->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $routes->render() !!}
                        </div> <!-- table-responsive -->

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            {!! Form::close() !!}
        </div><!-- /.col -->

    </div><!-- /.row -->
@endsection


<!-- Optional bottom section for modals etc... -->
@section('body_bottom')
<script language="JavaScript">
    function toggleCheckbox() {
        checkboxes = document.getElementsByName('chkRoute[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = !checkboxes[i].checked;
        }
    }
</script>
@endsection

