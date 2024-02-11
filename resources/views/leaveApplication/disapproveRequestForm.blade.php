@extends('layouts.landingpage')
@section('content')
    <div id="content" class="col-lg-10 col-sm-10">
        <!-- content starts -->
        <div class="row">
            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2><i class="glyphicon glyphicon-list"></i> Disapprove Request Form</h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-12">
                                <!--<div class="well">-->
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
                                @if ($errorMessage ?? '')
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong> {{ $errorMessage }}</strong>
                                    </div>
                                @endif
                                <form class="form-horizontal" role="form" action="disapprove" method="POST">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}


                                    <div class="well centered">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!--<label>id</label>-->
                                                <input id="id" class="form-control" type="hidden" name="id"
                                                    value="{{ $id }}">
                                                <!--<span style="color: red;" id="name"></span>-->
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!--<label>Comment</label>-->
                                                <textarea rows="6" cols="60" name="comment" placeholder="Enter your comment"></textarea>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <button class="btn btn-primary float-left m-1" id="btnSubmit"
                                                    name="btnSubmit" value="1">Disapprove</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection
