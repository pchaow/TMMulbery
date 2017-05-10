@extends('layouts._login')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Mulberry</b>Project</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">แบบฟอร์มเข้าสู่ระบบ</p>

            <form class="" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">

                    <input id="email" placeholder="บัญชีผู้ใช้ หรือ อีเมล" type="text" class="form-control" name="email"
                           value="{{ old('email') }}" required autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">

                    <input placeholder="รหัสผ่าน" id="password" type="password" class="form-control" name="password"
                           required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> จดจำฉัน
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">เข้าสู่ระบบ</button>
                    </div>
                    <!-- /.col -->
                </div>

            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
