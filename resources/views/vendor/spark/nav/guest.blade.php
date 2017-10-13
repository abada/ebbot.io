<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <div class="hamburger">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#spark-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Branding Image -->
            @include('spark::nav.brand')
        </div>

        <div class="collapse navbar-collapse" id="spark-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <!-- User Photo / Name -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Login
                    </a>

                    <ul class="dropdown-menu" role="menu" style="width:400px;">
                        <li style="padding:40px 40px 20px 40px;">
                            <form class="form form-horizontal" role="form" method="POST" action="/login">
                                {{ csrf_field() }}
        
                                <!-- E-Mail Address -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="email" placeholder="E-Mail" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                                    </div>
                                </div>
        
                                <!-- Password -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="password" placeholder="Password" class="form-control" name="password">
                                    </div>
                                </div>
    
                                <!-- Login Button -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa m-r-xs fa-sign-in"></i>Login
                                        </button>
        
                                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                    </div>
                                </div>
                            </form>
                        </li>
                    </ul>
                </li>
                <li>
                    <!-- User Photo / Name -->
                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="btn btn-primary">Get Started</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
