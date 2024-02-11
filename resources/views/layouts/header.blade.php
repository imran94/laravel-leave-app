<body>
    <!-- topbar starts -->
    <div class="navbar navbar-default" style="background-color: green;" role="navigation">
        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="#">
                <div class="pull-left">
                    <img alt="Logo" src="img/logo.png" width="50" height="50" />
                </div>
            </a>

            <div style="margin-left: 382px; margin-top:20px; font-family: 'Helvetica Neue', Helvetica, Arial, serif;
                 letter-spacing: 2px;
                 text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
                 color: white;
                 font-size: 17px;"
                class="col-md-6">
                <span>Leave Application Portal</span>
            </div>
            <!-- user dropdown starts -->
            <div class="btn-group pull-right animated ">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs">
                        {{ Auth::user()->username }}</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">

                    <li> <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    <!--<li><a href="showUpdateProfile?id={{ Auth::user()->id }}">Update Profile</a></li>-->
                    <li><a href="updatepassword">Change Password</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->
        </div>
    </div>
    <!-- topbar ends -->
    <div class="ch-container">
        <div class="row">

            <!-- left menu starts -->
            <div class="col-sm-2 col-lg-2">
                <div class="sidebar-nav">
                    <div class="nav-canvas">
                        <div class="nav-sm nav nav-stacked">

                        </div>
                        <ul class="nav nav-pills nav-stacked main-menu">
                            <li class="nav-header">Main</li>

                            @if (Auth::user()->access_type == 1)
                                <li>
                                    <a class="ajax-link" href="users"></i><span> User</span></a>
                                </li>
                                <li>
                                    <a class="ajax-link" href="managers"></i><span> Managers</span></a>
                                </li>
                            @endif

                            <li><a class="ajax-link" href="applyForLeave"></i><span> Apply For Leave</span></a>
                            </li>
                            <li><a class="ajax-link" href="leave-requests"></i><span> View Leave
                                        Requests</span></a></li>
                            <li><a class="ajax-link" href="leave-record"></i><span> View Leaves Record</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- left menu ends -->
