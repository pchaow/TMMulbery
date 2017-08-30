@extends('layouts._login')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Piankusol</b>Harvesting Management System</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">ลงทะเบียนสมาชิกระบบ</p>

            <form role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">

                    <input placeholder="Name" id="name" type="text" class="form-control" name="name"
                           value="{{ old('name') }}" required autofocus>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">

                    <input placeholder="Username" id="username" type="username" class="form-control" name="username"
                           value="{{ old('username') }}" required>
                    <span class="glyphicon glyphicon-king form-control-feedback"></span>

                    @if ($errors->has('username'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">

                    <input placeholder="E-mail" id="email" type="email" class="form-control" name="email"
                           value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @if ($errors->has('email'))
                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">

                    <input placeholder="Password" id="password" type="password" class="form-control" name="password"
                           required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password'))
                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <input placeholder="Retype Password" id="password-confirm" type="password" class="form-control"
                           name="password_confirmation" required>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>


        </div>
        <!-- /.login-box-body -->
    </div>

@endsection
