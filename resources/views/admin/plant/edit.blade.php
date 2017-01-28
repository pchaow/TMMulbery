@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Plant Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/roles"><i class="fa fa-sign-in"></i> Plant Management</a></li>
            <li><a href="/admin/plant/{{$plantId}}/edit"><i class="fa fa-pencil"></i> Edit Plant</a></li>
            <li>Plant ID : {{$plantId}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <role-edit
                v-bind:save-prefix="'/api/admin/role/'"
                v-bind:save-postfix="''"
                v-bind:load-prefix="'/api/admin/role/'"
                v-bind:load-postfix="''"
                v-bind:success-url="'/admin/roles'"
                v-bind:role-id="{{$plantId or 0}}"></role-edit>
    </section>
    <!-- /.content -->
@endsection
