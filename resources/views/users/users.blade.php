@extends('layouts.landingpage')
@section('content')
    <div id="content" class="col-lg-10 col-sm-10">
        <!-- content starts -->

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>{{ session('status') }}</strong>
            </div>
        @endif

        <div class="row">
            <div class="box col-md-12">
                <div class="box-inner">

                    <div class="box-header well" data-original-title="">
                        <h2><i class="glyphicon glyphicon-user"></i> User List</h2>
                        @if (auth()->user()->access_type == 1)
                            <div class="box-icon">
                                <a href="register" title="Add New" class="btn btn-default btn-xs">
                                    +Register New User
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="well">

                                    <table id="overall" class="display">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Date registered</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Password Changed</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($userList as $user)
                                                @if (auth()->user()->access_type == 1 || auth()->user()->access_type == 0)
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->username }}</td>
                                                        <td class="center">{{ $user->created_at }}</td>
                                                        <td class="center">
                                                            @if ($user->access_type == 1)
                                                                Admin
                                                            @elseif($user->access_type == 0)
                                                                HOD
                                                            @elseif($user->access_type == -1)
                                                                Team Lead
                                                            @else
                                                                Team Member
                                                            @endif
                                                        </td>
                                                        <td class="center">
                                                            @if ($user->status == 1)
                                                                <span
                                                                    class="label-success label label-default">Active</span>
                                                            @else
                                                                <span
                                                                    class="label-warning label label-default">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td class="center">
                                                            @if ($user->is_change_pass == 1)
                                                                <span class="label-success label label-default">Yes</span>
                                                            @else
                                                                <span class="label-warning label label-default">No</span>
                                                            @endif
                                                        </td>
                                                        <td class="center">
                                                            @if (Auth::user()->access_type == 1 || Auth::user()->access_type == 0)
                                                                @if (Auth::user()->id != $user->id)
                                                                    <a class="btn btn-danger btn-sm"
                                                                        href="deleteUser?id={{ $user->id }}"
                                                                        onclick="return confirm('Are you sure want to delete this user?')">
                                                                        <i class="glyphicon glyphicon-trash icon-white"></i>
                                                                        Delete
                                                                    </a>
                                                                @endif
                                                                <a class="btn btn-primary btn-sm"
                                                                    href="resetpasswordRequest?id={{ $user->id }}"
                                                                    onclick="return confirm('Are you sure want to reset this user password?')">
                                                                    <i class="glyphicon glyphicon-repeat icon-white"></i>
                                                                    Reset Password
                                                                </a>
                                                                <a class="btn btn-primary btn-sm"
                                                                    href="update-user?id={{ $user->id }}"
                                                                    onclick="return confirm('Are you sure want to update this user?')">
                                                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                                                    Edit
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/span-->

    </div>
    <!--/row-->
@endsection
