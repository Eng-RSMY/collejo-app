@extends('dashboard::layouts.tab_view')

@section('title', $user->name)

@section('tools')

    @can('edit_user_account_info')

        <a href="{{ route('user.details.edit', $user->id) }}" class="btn btn-primary"><i
                    class="fa fa-fw fa-edit"></i> {{ trans('base::common.edit') }}</a>

    @endcan

@endsection

@section('tabs')

    @include('acl::partials.view_user_tabs')

@endsection

@section('tab')

    <div class="col-sm-6">
        <dl class="row">
            <dt class="col-sm-4">{{ trans('acl::user.name') }}</dt>
            <dd class="col-sm-8">{{ $user->name }}</dd>

            <dt class="col-sm-4">{{ trans('acl::user.email') }}</dt>
            <dd class="col-sm-8">{{ $user->email }}</dd>

            <dt class="col-sm-4">{{ trans('acl::user.date_of_birth') }}</dt>
            <dd class="col-sm-8">{{ $user->date_of_birth }}</dd>
        </dl>
    </div>

@endsection