<template>
    <div>
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <h3 class="profile-username text-center">{{farmer.name}}</h3>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>แปลงทั้งหมด</b> <a class="pull-right">{{farmer.plants.length}}</a>
                    </li>


                </ul>

                <a v-bind:href="editUrl" class="btn btn-primary btn-block"><b>แก้ไขข้อมูลลงทะเบียน</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">ข้อมูลส่วนตัว</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-file-text-o margin-r-5"></i> เลขประจำตัวประชาชน</strong>

                <p>{{farmer.identity}}</p>
                <hr>
                <strong><i class="fa fa-pencil margin-r-5"></i> ข้อมูลติดต่อ</strong>
                <p class="text-muted">{{farmer.contact_number}}</p>
                <p class="text-muted">{{farmer.email}}</p>


                <hr>

                <strong><i class="fa fa-map-marker margin-r-5"></i> ที่อยู่</strong>

                <p class="text-muted">
                    {{farmer.address}}
                    {{farmer.district ? farmer.district.name : ''}}
                    {{farmer.amphure ? farmer.amphure.name : ''}}
                    {{farmer.province ? farmer.province.name : ''}}
                </p>

                <hr>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

</template>

<script>
    export default {
        props: {
            farmer: Object,
            editUrl: String,
        },
        data() {
            return {}
        },
        methods: {},
        mounted() {
        }
    }
</script>