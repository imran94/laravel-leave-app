@extends('layouts.landingpage')
@section('content')
    <div id="content" class="col-lg-10 col-sm-10">
        <!-- content starts -->

        <head>
            <style type="text/css">
                .scrollable-content {
                    overflow: auto;
                }
            </style>
        </head>

        <div class="row">
            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2><i class="glyphicon glyphicon-user"></i> Update Profile</h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="name" class="col-md-4 control-label">Name</label>
                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control" name="name"
                                                    value="{{ $user->name }}" required autofocus>

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                            <label for="username" class="col-md-4 control-label">Username</label>
                                            <div class="col-md-6">
                                                <input id="username" type="username" class="form-control"
                                                    name="username" value="{{ $user->username }}" disabled="">
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
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
@endsection
