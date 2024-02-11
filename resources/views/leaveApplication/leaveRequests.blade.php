@extends('layouts.landingpage')
@section('content')

    <style>
        .section {
            width: 100%;
            height: 100%;

            display: flex;
            flex-flow: row wrap;
            justify-content: flex-start;
            align-items: flex-start;
        }

        .m-card {
            width: 32%;
            margin: 0em 0.5em 0.5em 0em;
            padding: 1em;
            box-shadow: 2px 2px 5px 2px rgba(0, 0, 0, .4);
            border-radius: 0.5em;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .line {
            font-size: 1.4em;
        }

        @media (max-width: 1250px) {
            .m-card {
                width: 100%;
            }
        }

        .button-group {
            width: 100%;

            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;

            padding: 0.3em 0em;
        }

        .button-group a {
            margin: 0em 0.3em;
            width: 50%;
            padding-top: 1em;
            padding-bottom: 1em;
        }
    </style>

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
        <!-- content starts -->
        <div class="section">
            @foreach ($leaves ?? '' as $leave)
                <div class="m-card">
                    <p><small>{{ $leave->created_at }}</small></p>
                    <div style="padding-bottom: 1em;">
                        @if ($leave->status == 0)
                            <span class="label-warning label label-default">Pending</span>
                        @elseif($leave->status == 1)
                            <span class="label-success label label-default">Approved by
                                Head</span>
                        @elseif($leave->status == 2)
                            <span class="label-success label label-default">Approved by
                                Admin</span>
                        @elseif($leave->status == 3)
                            <span class="label-success label label-default">Disapproved
                                by Head</span>
                        @elseif($leave->status == 4)
                            <span class="label-success label label-default">Disapproved
                                by Admin</span>
                        @elseif($leave->status == 5)
                            <span class="label-success label label-default">Cancelled</span>
                        @endif
                    </div>
                    <div><strong>{{ $leave->name }}</strong></div>
                    <div><strong>Period:</strong> {{ $leave->time_period }} </div>
                    <div><strong>Leave Date:</strong> {{ $leave->leaveDate }}</div>
                    <div><strong>Return Date:</strong> {{ $leave->return_date }}</div>
                    <div><strong>No. of Days:</strong> {{ $leave->leaves + 0 }}</div>
                    <div><strong>Type of Leave:</strong> {{ $leave->type }}</div>
                    @if ($leave->reason !== '')
                        <div class="line"><q><em>{!! $leave->reason !!}</em></q></div>
                    @endif
                    @isset($leave->comment)
                        <div class="line"><strong>Comment by Team Lead:</strong> <q><em>{!! $leave->comment !!}</em></q></div>
                    @endisset
                    @isset($leave->adminComment)
                        <div class="line"><strong>Comment by Admin:</strong> <q><em>{!! $leave->adminComment !!}</em></q></div>
                    @endisset

                    <div class="button-group">
                        @if (Auth::id() === $leave->empId && $leave->leaveDate > $today)
                            @if ($leave->status != 5)
                                <a class="btn btn-danger btn-sm" href="delete-leave-request?id={{ $leave->id }}"
                                    onclick="return confirm('Are you sure you want to delete?')">
                                    <i class="glyphicon glyphicon-trash icon-white"></i>
                                    Cancel
                                </a>
                            @endif
                            @if ($leave->status == 0)
                                <a class="btn btn-primary btn-sm" href="edit-leave-request?id={{ $leave->id }}"
                                    onclick="return confirm('Are you sure you want to edit?')">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    Edit
                                </a>
                            @endif
                            {{-- Not having the same team lead, not cancelled, if TL/HOD and pending, if admin and not approved/disapproved --}}
                        @elseif (Auth::user()->tlId != $leave->tlId &&
                                $leave->status != 5 &&
                                (((Auth::user()->access_type == -1 || Auth::user()->access_type == 0) && $leave->status == 0) ||
                                    (Auth::user()->access_type == 1 && !in_array($leave->status, [2, 4, 5]))))
                            <a class="btn btn-primary btn-sm" href="approve-request?id={{ $leave->id }}"
                                onclick="return confirm('Are you sure you want to approve?')">
                                <i class="glyphicon glyphicon-adjust icon-white"></i>
                                Approve
                            </a>
                            <a class="btn btn-danger btn-sm" href="disapprove-request?id={{ $leave->id }}"
                                onclick="return confirm('Are you sure you want to disapprove?')">
                                <i class="glyphicon glyphicon-alert icon-white"></i>
                                Disapprove
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection
