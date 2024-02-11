@extends('layouts.landingpage')
@section('content')
    <div id="content" class="col-lg-10 col-sm-10">
        <!-- content starts -->
        <div class="row">
            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2><i class="glyphicon glyphicon-list"></i> Leave Requests History</h2>
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
                                @isset($status)
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>{{ $status }}</strong>
                                    </div>
                                @endisset
                                @if ($errorMessage ?? '')
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong> {{ $errorMessage }}</strong>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="well">
                                    <div class="table-responsive">
                                        <table id="overall" class="table table-bordered display" id="callReportHourlyTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Time period</th>
                                                    <th scope="col">Leave Date</th>
                                                    <th scope="col">Return Date</th>
                                                    <th scope="col">#of Leaves</th>
                                                    <th scope="col">Reason</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">TL/HOD Comment</th>
                                                    <th scope="col">Admin Comment</th>
                                                    <th scope="col">Attachment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($leaves ?? '' as $leave)
                                                    <tr>
                                                        <td>{{ $leave->created_at }}</th>
                                                        <td>{{ $leave->name }}</td>
                                                        <td>{{ $leave->time_period }}
                                                        <td>{{ $leave->leaveDate }}</td>
                                                        <td>{{ $leave->return_date }}</td>
                                                        <td>{{ $leave->leaves + 0 }}</td>
                                                        <td>{{ $leave->reason }}</td>
                                                        <td>{{ $leave->type }}</td>
                                                        <td>{{ $leave->comment }}</td>
                                                        <td>{{ $leave->adminComment }}</td>
                                                        <td>
                                                            @if ($leave->attachment)
                                                                <a id="filedownload"
                                                                    href="download-file?filename={{ $leave->attachment }}"
                                                                    target="_blank">attachment</a>
                                                            @endif
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
    </div>
    <script src="{{ asset('js/pagination.js') }}"></script>
    <script>
        $.function() {
            $('#filedownload').click(function() {
                let uri = 'download-file?filename=' + $('#filedownload').html();
                console.log(uri);
                $.ajax({
                    type: 'get',
                    url: uri,
                    headers: {
                        'AccessCode': '1234',
                        'X-CSRF-TOKEN': 'xxxxxxxxxxxxxxxxxxxx',
                    },
                    success: function(data) {}
                });
            });
        }
    </script>
@endsection
