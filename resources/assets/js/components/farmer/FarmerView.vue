<template>
    <div class="row" v-if="farmer">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">{{farmer.name}}</h3>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>แปลงทั้งหมด</b> <a v-if="plants" class="pull-right">{{plants.length}}</a>
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

                    <p class="text-muted">{{farmer.address}} {{farmer.district.name}} {{farmer.amphure.name}}
                        {{farmer.province.name}}</p>

                    <hr>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">แปลงหม่อน</a></li>
                    <li><a href="#timeline" data-toggle="tab">ประวัติซื้อขาย</a></li>

                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-tree"></i>
                                รายการแปลงหม่อน

                                <div class="pull-right">

                                    <a v-bind:href="plantCreateUrl" class="btn btn-success">
                                        เพิ่มแปลงหม่อน
                                    </a>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>

                                            <th>ชื่อแปลง</th>
                                            <th>พื้นที่(ตรม.)</th>
                                            <th>คงเหลือเก็บเกี่ยว</th>

                                            <th>ตำบล</th>
                                            <th>อำเภอ</th>
                                            <th>จังหวัด</th>
                                            <th>จัดการ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>

                                            <td>A1</td>
                                            <td>100000</td>
                                            <td><span class="badge bg-yellow">60%</span></td>
                                            <td>แม่กา</td>
                                            <td>เมือง</td>
                                            <td>พะเยา</td>
                                            <td>

                                                <a class="btn btn-primary">แก้ไข</a>
                                                <button type="button" class="btn btn-danger">
                                                    ลบ
                                                </button>
                                            </td>

                                        </tr>
                                        <tr>

                                            <td>A2</td>
                                            <td>5000</td>
                                            <td><span class="badge bg-red">30%</span></td>

                                            <td>แม่นาเรือ</td>
                                            <td>เมือง</td>
                                            <td>พะเยา</td>

                                            <td>
                                                <a class="btn btn-primary">แก้ไข</a>
                                                <button type="button" class="btn btn-danger">
                                                    ลบ
                                                </button>
                                            </td>

                                        </tr>
                                        <tr>

                                            <td>A3</td>
                                            <td>3000</td>
                                            <td><span class="badge bg-green">100%</span></td>

                                            <td>เวียง</td>
                                            <td>เมือง</td>
                                            <td>พะเยา</td>

                                            <td>
                                                <a class="btn btn-primary">แก้ไข</a>
                                                <button type="button" class="btn btn-danger">
                                                    ลบ
                                                </button>
                                            </td>

                                        </tr>


                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div>
                                                    จำนวนทั้งหมด 3 รายการ
                                                </div>
                                                <ul class="pagination">
                                                    <li></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Post -->
                    </div>
                    <div class="tab-pane" id="timeline">
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


</template>

<script>
    export default {
        props: {
            loadUrl: String,
            editUrl: String,
            loadPlantUrl: String,
            plantCreateUrl: String,
            farmerId: Number,
        },
        data() {
            return {
                farmer: null,
                plants: null,
            }
        },
        methods: {

            load: function () {
                return this.$http.get(this.loadUrl)
                    .then((response) => {
                        // success callback
                        // console.log(response);
                        this.farmer = response.data;
                    }, (response) => {

                    })
            },
            loadPlant: function () {
                return this.$http.get(this.loadPlantUrl)
                    .then((response) => {
                        this.plants = response.data
                        console.log(this.plants.length);
                    }, (response) => {

                    })
            }
        },
        mounted() {
            console.log('ready to view farmer.id =', this.farmerId)
            this.load()
            this.loadPlant();
        }
    }
</script>
