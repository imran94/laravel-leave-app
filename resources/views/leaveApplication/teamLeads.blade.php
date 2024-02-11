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
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong></strong> {{ session('status') }}
            </div>
        @endif


        <div class="row">
            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2><i class="glyphicon glyphicon-user"></i> Manager(s)</h2>
                        @if (auth()->user()->access_type == 1)
                            <div class="box-icon">
                                <button href="#" title="Add New" data-toggle="modal" data-target="#AddblockModal"
                                    class="btn btn-default btn-xs">+Add New</button>
                            </div>
                        @endif
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="well">
                                    <div class="table-responsive">
                                        <table id="overall" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Department</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($teamLeads as $teamLead)
                                                    <!--@if (auth()->user()->access_type == 1 || auth()->user()->access_type == 0)
    -->
                                                    <tr>
                                                        <td>{{ $teamLead->name }}</td>
                                                        <td>{{ $teamLead->department }}</td>

                                                        <td class="center">
                                                            @if (auth()->user()->access_type == 1)
                                                                <a class="btn btn-danger btn-sm"
                                                                    href="remove-manager?id={{ $teamLead->id }}"
                                                                    onclick="return confirm('Are you sure want to remove this TL?')"
                                                                    data-toggle="tooltip" title="Remove User">
                                                                    <i class="glyphicon glyphicon-trash icon-white"></i>
                                                                </a>
                                                                <!--                                                <a class="btn btn-danger btn-sm" href="update-manager?id={{ $teamLead->id }}" onclick="return confirm('Are you sure want to update this TL?')">
                                                                                    <i class="glyphicon glyphicon-repeat icon-white"></i>
                                                                                    Update
                                                                                </a>-->
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <!--
    @endif-->
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
        </div>
        <!--/span-->
    </div>
    <!--/row-->

    <!-- Begin Modal -->
    <div class="modal fade" id="AddblockModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Add New Manager</h3>
                </div>
                <div class="modal-body">
                    <div class="col-md-8 col-md-offset-2">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <form class="form-horizontal" role="form" method="post" action="addManager">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="teamLead" class="col-md-4 control-label">TL/HOD</label>
                            <div class="col-md-6">
                                <select name="teamLead" class="form-control">
                                    <option>Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}{{ $user->name }}">{{ $user->name }}</option>
                                    @endforeach
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


                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                            <button class="btn btn-primary"> Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

@endsection
