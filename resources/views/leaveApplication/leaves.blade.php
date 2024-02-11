@extends('layouts.landingpage')
@section('content')
    <div id="content" class="col-lg-10 col-sm-10">

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
                        <h2><i class="glyphicon glyphicon-user"></i> Leaves Record(s)</h2>
                        {{-- <div class="box-icon">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#editLeavesModal">
                                Edit Leave Record
                            </button>
                        </div> --}}
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-12">

                                <div style="padding: 10px;">
                                    <form method="get" action="/leave-record">
                                        <select class="form-select form-select-sm" aria-label="year-select" name="year">
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}"
                                                    {{ $year == $selectedYear ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-secondary btn-sm" type="submit">Go</button>
                                    </form>
                                </div>
                                <div class="well">

                                    <div class="table-responsive">
                                        <table id="overall" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center" rowspan="2">Name</th>
                                                    <!--<th rowspan="2">Department</th>-->
                                                    <th style="text-align: center" colspan="4">Leaves Availed</th>
                                                    <th style="text-align: center" colspan="3">Leaves Available</th>
                                                    <th style="text-align: center" rowspan="2">Actions</th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center">Total</th>
                                                    <th style="text-align: center">Sick</th>
                                                    <th style="text-align: center">Annual</th>
                                                    <th style="text-align: center">Others</th>
                                                    <th style="text-align: center">Sick</th>
                                                    <th style="text-align: center">Annual</th>
                                                    <th style="text-align: center">Others</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($leaves as $leave)
                                                    <tr>
                                                        <td>{{ $leave->name }}</td>
                                                        <td style="text-align: center">
                                                            {{ $leave->annualAvailed + $leave->sickAvailed + $leave->otherAvailed + 0 }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $leave->sickAvailed + 0 }}
                                                        </td>
                                                        <td style="text-align: center" class="center">
                                                            {{ $leave->annualAvailed + 0 }}
                                                        </td>
                                                        <td style="text-align: center" class="center">
                                                            {{ $leave->otherAvailed + 0 }}
                                                        </td>
                                                        <td style="text-align: center" class="center">
                                                            {{ $leave->sickLeft + 0 }}
                                                        </td>
                                                        <td style="text-align: center" class="center">
                                                            {{ $leave->annualLeft + 0 }}
                                                        </td>
                                                        <td style="text-align: center" class="center">
                                                            {{ $leave->otherLeft + 0 }}
                                                        </td>
                                                        <td style="text-align: center" class="center">

                                                            @if (Auth::user()->access_type == 1)
                                                                <a href="{{ '/edit-leaves-record?year=' . $selectedYear . '&empId=' . $leave->empId }}"
                                                                    data-toggle="tooltip" title="Edit Leaves Record">
                                                                    <i class="glyphicon glyphicon-pencil icon-white"></i>
                                                                </a>
                                                            @endif

                                                            <a href="{{ '/leave-history?id=' . $leave->empId . '&year=' . $selectedYear }}"
                                                                data-toggle="tooltip" title="View Leave History">
                                                                <i class="glyphicon glyphicon-eye-open icon-white"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
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

        <!-- Edit Leaves Modal -->
        <div class="modal fade" id="editLeavesModal" tabindex="-1" role="dialog" aria-labelledby="editLeavesLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLeavesLabel">Edit Leaves</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="selectedUser">User</label>
                            <div class="col-sm-5">
                                <select id="selectedUser" name="selectedUser" class="form-control"
                                    onchange="onSelectLeave(this.value)" required>
                                    <option value="">Select a User</option>
                                    @foreach ($leaves as $user)
                                        <option value="{{ $user->empId }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="availableSickLeaves">Available Sick Leaves</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" id="availableSickLeaves"
                                    name="availableSickLeaves" step="0.5" disabled required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="availableAnnualLeaves">Available Annual
                                Leaves</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" id="availableAnnualLeaves"
                                    name="availableAnnualLeaves" step="0.5" disabled required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label" for="availableOtherLeaves">Available Other
                                Leaves</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" id="availableOtherLeaves"
                                    name="availableOtherLeaves" step="0.5" disabled required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
