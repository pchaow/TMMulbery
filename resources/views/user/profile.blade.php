@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            ข้อมูลส่วนตัวผู้ใช้
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-user"></i>จัดการผู้ใช้</a></li>
            <li><a href="#"></i>ข้อมูลผู้ใช้</a></li>
            <li>รหัสผู้ใช้ : {{$userId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <user-profile
                v-bind:save-url="'/api/profile/{{$userId or 0}}'"
                v-bind:load-url="'/api/profile/{{$userId or 0}}/edit'"
                v-bind:success-url="'/profile/{{$userId or 0}}'"
                v-bind:user-id="{{$userId or 0}}"
        >
        </user-profile>

    </section>
    <!-- /.content -->
@endsection
