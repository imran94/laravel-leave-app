@extends('layouts.landingpage')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="PUT" action="editAnnual">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">email</label>

                                <div class="col-md-6">
                                    <input id="username" type="email" class="form-control" name="username"
                                        value="{{ old('username') }}" required>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password"
                                        value="{{ old('password') }}" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Country</label>
                                <div class="col-md-6">
                                    <select name="country" class="form-control">


                                        @if (auth()->user()->access_type == 1)
                                            <option value="92">Pakistan</option>
                                            <option value="60">Malaysia</option>
                                            <!--<option value="-1">TL</option>-->
                                            <!--<option value="-2">Team Member</option>-->
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="department" class="col-md-4 control-label">Department</label>
                                <div class="col-md-6">
                                    <select name="department" class="form-control" id='department'>
                                        <option>Select dept</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation" class="col-md-4 control-label">Designation</label>
                                <div class="col-md-6">
                                    <select name="designation" id='designation' class="form-control">
                                        <option>Select designation</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->designation }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">User Type</label>
                                <div class="col-md-6">
                                    <select name="accessType" class="form-control">


                                        @if (auth()->user()->access_type == 1)
                                            <option value="1">Admin</option>
                                            <option value="0">HOD</option>
                                            <option value="-1">TL</option>
                                            <option value="-2">Team Member</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="teamLead" class="col-md-4 control-label">TL/HOD</label>
                                <div class="col-md-6">
                                    <select name="teamLead" class="form-control">
                                        <option value="0">Select TL/HOD</option>
                                        @foreach ($teamLeads as $teamLead)
                                            <option value="{{ $teamLead->id }}">{{ $teamLead->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="prefix" class="col-md-4 control-label">Prefix Type</label>
                                <div class="col-md-6">
                                    <select name="prefix" class="form-control">
                                        @foreach ($prefixes as $prefix)
                                            <option value="{{ $prefix->prefix_id }}">{{ $prefix->prefix }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
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
