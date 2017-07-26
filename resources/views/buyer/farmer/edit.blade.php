@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Farmer Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/farmers"><i class="fa fa-user"></i> Farmer Management</a></li>
            <li><a href="/admin/farmers/{{$userId}}/edit"><i class="fa fa-plus"></i> Edit Farmer</a></li>
            <li>Farmers ID : {{$userId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <farmer-edit
                :user-id="{{$userId or 0}}"
                role-type="buyer"></farmer-edit>

    </section>
    <!-- /.content -->
@endsection
