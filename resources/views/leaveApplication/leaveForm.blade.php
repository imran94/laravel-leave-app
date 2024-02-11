@extends('layouts.landingpage')
@section('content')
    <div id="content" class="col-lg-10 col-sm-10">
        <!-- content starts -->
        <div class="row">
            <div class="box col-md-12">
                <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                        <h2><i class="glyphicon glyphicon-list"></i> Leave Application form</h2>
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
                                        <strong> {{ $errorMessage ?? '' }}</strong>
                                    </div>
                                @endif
                                <!--</div>-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!--<div class="well">-->

                                {{-- @if (Route::currentRouteName() !== 'edit-leave-request') --}}
                                <form class="form-horizontal" action="storeLeaveRequest" method="POST"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $leave->id ?? null }}" />
                                    <div class="well centered">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>AM / PM / Full Day *</label>
                                                <br>
                                                <div class="radio">
                                                    <label><input type="radio" id="am" name="time_period"
                                                            value="AM"
                                                            {{ $leave !== null && $leave->time_period === 'AM' ? 'checked' : '' }}>
                                                        AM</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" id="pm" name="time_period"
                                                            value="PM"
                                                            {{ $leave !== null && $leave->time_period === 'PM' ? 'checked' : '' }}>
                                                        PM</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" id="full_day" name="time_period"
                                                            value="Full Day"
                                                            {{ $leave == null || $leave->time_period === 'Full Day' ? 'checked' : '' }}>
                                                        Full
                                                        Day</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="well centered">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="inputKey">Leave Date</label>
                                                <input type="text" name="start_date"
                                                    value="{{ $leave !== null ? $leave->leaveDate : Request::get('start_date') }}"
                                                    class="form-control" id="startDateInput" required>
                                                <script type="text/javascript">
                                                    $(function() {
                                                        var dateNow = new Date();
                                                        var previousDate = new Date();
                                                        //                                                    previousDate.setDate(previousDate.getDate() - 30);
                                                        $('#startDateInput').datetimepicker({
                                                            useCurrent: true,
                                                            //                                                        maxDate: dateNow,
                                                            minDate: dateNow,
                                                            defaultDate: dateNow,
                                                            format: 'YYYY-MM-DD',
                                                        });
                                                    });
                                                </script>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputValue">Return Date</label>
                                                <input type="text" name="end_date"
                                                    value="{{ $leave !== null ? $leave->return_date : Request::get('end_date') }}"
                                                    class="form-control" id="endDateInput" required>
                                                <script type="text/javascript">
                                                    $(function() {
                                                        var dateNow = new Date();
                                                        var previousDate = new Date();
                                                        //                                                    previousDate.setDate(previousDate.getDate() - 30);
                                                        $('#endDateInput').datetimepicker({
                                                            useCurrent: true,
                                                            //                                                        maxDate: dateNow,
                                                            minDate: dateNow,
                                                            defaultDate: dateNow,
                                                            format: 'YYYY-MM-DD',
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="well">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Type of leave *</label>
                                                <div class="radio">
                                                    <label><input id="radioAnnualLeave" type="radio" name="type"
                                                            value="Annual leave"
                                                            {{ $leave !== null && $leave->type === 'Annual leave' ? 'checked' : '' }}>
                                                        Annual leave
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="type"
                                                            value="Leave on Compassionate Grounds (Nuclear family)"
                                                            {{ $leave !== null && $leave->type === 'Leave on Compassionate Grounds (Nuclear family)' ? 'checked' : '' }}>
                                                        Leave on Compassionate Grounds (Nuclear family)
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" id="sick_leave" name="type"
                                                            value="Sick leave (Illness or Injury)"
                                                            {{ $leave !== null && $leave->type === 'Sick leave (Illness or Injury)' ? 'checked' : '' }}>
                                                        Sick leave (Illness or Injury)
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="type"
                                                            value="Jury duty or legal leave"
                                                            {{ $leave !== null && $leave->type === 'Jury duty or legal leave' ? 'checked' : '' }}>
                                                        Jury duty or legal leave
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="type" value="Leave without pay"
                                                            {{ $leave !== null && $leave->type === 'Leave without pay' ? 'checked' : '' }}>
                                                        Leave without pay
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="type" value="Other"
                                                            {{ $leave !== null && $leave->type === 'Other' ? 'checked' : '' }}>
                                                        Other
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="well centered">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="reason">Reason</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <textarea rows="6" cols="70" id="reason" name="reason">{{ $leave !== null ? $leave->reason : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="well centered">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label id="attachmentlabel">Attachment (jpg,jpeg,png,docx,doc)</label>
                                                <input type="file" name="attachment">
                                                <!--<span style="color: green;" id="attch" hidden="hidden"></span>-->
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button class="btn btn-primary float-left m-1" id="btnSubmit"
                                                name="btnSubmit" value="1">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                {{-- @endif --}}
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/pagination.js') }}"></script>
    <script>
        function changeValue(values) {
            document.getElementById("type").value = values;
            document.getElementById("other").checked = true;
        }

        $(document).ready(function() {

            if (document.getElementById("am").checked || document.getElementById("pm").checked) {
                $("#endDateInput").attr('disabled', true);
                $("#endDateInput").attr('required', false);
            } else if (document.getElementById("full_day").checked) {
                $("#endDateInput").attr('disabled', false);
                $("#endDateInput").attr('required', true);
            }

            $('input[type="radio"]').click(function() {

                let inputValue = $(this).attr("value");
                let endDateInput = $("#endDateInput");

                if (inputValue === "AM" || inputValue === "PM") {
                    endDateInput.attr('disabled', true);
                    endDateInput.attr('required', false);
                } else if (inputValue === "Full Day") {
                    endDateInput.attr('disabled', false);
                    endDateInput.attr('required', true);
                }

                if (inputValue === "Sick leave (Illness or Injury)") {
                    $("#attachmentlabel").html('Attachment (jpg,jpeg,png,docx,doc)*');
                    $("#attachment").attr('required', true);
                }

                if (document.getElementById('sick_leave').checked === false) {
                    console.log("sick leave uncheckded");
                    $("#attachmentlabel").html('Attachment (jpg,jpeg,png,docx,doc)');
                    $("#attachment").attr('required', false);
                }

            });
        });

        //sending ajax request to upload file
        $("#upload").click(function(event) {
            event.preventDefault();

            let fileName = $("input[type=file]").val();
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/upload-file",
                type: "POST",
                data: {
                    file: fileName,
                    _token: _token
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        $('#attach').text(response.result);
                        $("#ajaxform")[0].reset();
                    }
                },
            });
        });
    </script>
@endsection
