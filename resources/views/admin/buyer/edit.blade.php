@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Buyer Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/buyers"><i class="fa fa-user"></i> Buyer Management</a></li>
            <li><i class="fa fa-user-circle-o"></i> Edit Buyer</li>
            <li>Buyer ID : {{$userId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <buyer-edit
                v-bind:save-url="'/api/admin/buyer/{{$userId or 0}}'"
                v-bind:load-url="'/api/admin/buyer/{{$userId or 0}}/edit'"
                v-bind:success-url="'/admin/buyers'"
                v-bind:user-id="{{$userId or 0}}">
        </buyer-edit>

    </section>
    <!-- /.content -->
@endsection
