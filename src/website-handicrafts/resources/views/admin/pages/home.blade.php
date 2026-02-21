@extends('admin.layouts.app')

@section('title', __('admin/messages.title_meta_home'))
@section('bodyDataPage', $page ?? 'panel')


@section('content')
    <x-admin.panel-card title="{{ __('admin/messages.users_logins_table_title') }}"
        subtitle="{{ __('admin/messages.users_logins_table_subtitle') }}" icon="fa-solid fa-user-shield">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-hover align-middle mb-0" data-datatable="data">
                <thead>
                    <tr>
                        <th scope="col">{{ __('admin/messages.users_logins_table_columns.id') }}</th>
                        <th scope="col">{{ __('admin/messages.users_logins_table_columns.name') }}</th>
                        <th scope="col">{{ __('admin/messages.users_logins_table_columns.email') }}</th>
                        <th scope="col" type="datetime">
                            {{ __('admin/messages.users_logins_table_columns.email_verified_at') }}</th>
                        <th scope="col" type="datetime">
                            {{ __('admin/messages.users_logins_table_columns.last_login_at') }}</th>
                        <th scope="col">{{ __('admin/messages.users_logins_table_columns.login_count') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->email_verified_at ? $user->email_verified_at->timezone('Europe/Warsaw')->format('Y-m-d H:i') : '' }}
                            </td>
                            <td>{{ $user->last_login_at ? $user->last_login_at->timezone('Europe/Warsaw')->format('Y-m-d H:i') : '' }}
                            </td>
                            <td>{{ $user->login_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-admin.panel-card>
@endsection
