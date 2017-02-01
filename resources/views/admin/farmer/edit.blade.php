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
                v-bind:save-url="'/api/admin/farmer/{{$userId or 0}}'"
                v-bind:load-url="'/api/admin/farmer/{{$userId or 0}}/edit'"
                v-bind:success-url="'/admin/farmers'"
                v-bind:user-id="{{$userId or 0}}">
        </farmer-edit>

    </section>
    <!-- /.content -->
@endsection
