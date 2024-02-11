@extends('layouts.landingpage')
@section('content')
    <div id="content" class="col-lg-10 col-sm-10">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Leaves Record for {{ $employeeName }}</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="update-leaves-record">
                                @method('PUT')
                                {{ csrf_field() }}

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <input type="hidden" name="year" value="{{ $leave->year }}" />
                                <input type="hidden" name="empId" value="{{ $leave->empId }}" />

                                <div class="form-group">
                                    <label for="annualLeft" class="col-md-4 control-label">Annual Leaves Available</label>

                                    <div class="col-md-6">
                                        <input id="annualLeft" type="number" max="99" class="form-control"
                                            name="annualLeft" value="{{ $leave->annualLeft }}" step=".5" required
                                            autofocus>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="sickLeft" class="col-md-4 control-label">Sick Leaves Available</label>

                                    <div class="col-md-6">
                                        <input id="sickLeft" type="number" max="99" class="form-control"
                                            name="sickLeft" value="{{ $leave->sickLeft }}" step=".5" required
                                            autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="otherLeft" class="col-md-4 control-label">Other Leaves Available</label>

                                    <div class="col-md-6">
                                        <input id="otherLeft" type="number" max="99" class="form-control"
                                            name="otherLeft" value="{{ $leave->otherLeft }}" step=".5" required
                                            autofocus>
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
    </div>

@endsection
