@extends('layouts.landingpage')
@section('content')
<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-password"></i> Change Password</h2>

                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('status'))
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong></strong> {{session('status')}}
                            </div>
                            @endif
                            <div class="well">
                                <form class="form-horizontal" method="POST" action="updatepasswordRequest">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">Old Password</label>

                                        <div class="col-md-6">
                                            <input id="name" type="password" class="form-control" name="oldpassword" >

                                            @if ($errors->has('oldpassword') || session('error'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('oldpassword') }}</strong>
                                                <strong>{{ session('error') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
                                        <label for="username" class="col-md-4 control-label">New Password</label>

                                        <div class="col-md-6">
                                            <input id="" type="password" class="form-control" name="newpassword" >
                                            @if ($errors->has('newpassword'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('newpassword') }}</strong>

                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('confirmpassword') ? ' has-error' : '' }}">
                                        <label for="username" class="col-md-4 control-label">Confirm Password</label>

                                        <div class="col-md-6">
                                            <input id="" type="password" class="form-control" name="confirmpassword" >
                                            @if ($errors->has('confirmpassword'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('confirmpassword') }}</strong>

                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Change Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--/span-->

    </div><!--/row-->

</div>

@endsection