@extends('layouts.landingpage')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update User</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="update-user">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ $user->name }}" autofocus disabled>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input id="username" type="email" class="form-control" name="username"
                                        value="{{ $user->email }}" required>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="department" class="col-md-4 control-label">Department</label>
                                <div class="col-md-6">
                                    <select name="department" class="form-control" id="department"
                                        onchange="onSelectDepartment(this)">
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ $department->id == $userDepartmentId ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation" class="col-md-4 control-label">Designation</label>
                                <div class="col-md-6">
                                    <select name="designation" id='designation' class="form-control">

                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"
                                                {{ $designation->id == $user->designationId ? 'selected' : '' }}>
                                                {{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">User Type</label>
                                <div class="col-md-6">
                                    <select name="accessType" class="form-control">
                                        @if (auth()->user()->access_type == 1)
                                            <option value="1" {{ $user->access_type == 1 ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="0" {{ $user->access_type == 0 ? 'selected' : '' }}>HOD
                                            </option>
                                            <option value="-1" {{ $user->access_type == -1 ? 'selected' : '' }}>TL
                                            </option>
                                            <option value="-2" {{ $user->access_type == -2 ? 'selected' : '' }}>Team
                                                Member
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="teamLead" class="col-md-4 control-label">Select TL/HOD</label>
                                <div class="col-md-6">
                                    <select name="teamLead" class="form-control" placeholder="Select TL/HOD">
                                        <option value="0">Select TL/HOD</option>
                                        @foreach ($teamLeads as $teamLead)
                                            <option value="{{ $teamLead->id }}"
                                                {{ $teamLead->id == $user->tlId ? 'selected' : '' }}>
                                                {{ $teamLead->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
