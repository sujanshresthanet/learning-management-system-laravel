@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <h4>@lang('roles.roles')</h4>
                            </div>
                            <div class="col-md-7 text-right">
                                @can('add_roles')
                                    <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus"></i> @lang('general.new')</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse ($roles as $role)
                            {!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role->id ], 'class' => 'm-b']) !!}
                                @if($role->name === 'Admin')
                                    @include('includes._permissions', [
                                                  'title' => trans('roles.'.Str::lower($role->name)) . ' '.trans('roles.permissions'),
                                                  'options' => ['disabled'] ])
                                @else
                                    @include('includes._permissions', [
                                                  'title' => trans('roles.'.Str::lower($role->name)) . ' '. trans('roles.permissions'),
                                                  'model' => $role,
                                                  ])
                                @endif
                            {!! Form::close() !!}

                            @empty
                                <p>@lang('roles.not_have')</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'post']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- name Form Input -->
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', trans('general.name')) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('general.name')]) !!}
                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>

                    <!-- Submit Form Button -->
                    {!! Form::submit(trans('general.save'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
