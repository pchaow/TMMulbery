<template>
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">กอไก่ ใจดี</h3>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>แปลงทั้งหมด</b> <a class="pull-right">3</a>
                        </li>


                    </ul>

                    <a href="#" class="btn btn-primary btn-block"><b>แก้ไขข้อมูลลงทะเบียน</b></a>
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

                    <p>1560100000001</p>
                    <hr>
                    <strong><i class="fa fa-pencil margin-r-5"></i> ข้อมูลติดต่อ</strong>
                    <p class="text-muted">081-11111233</p>
                    <p class="text-muted">abc@ggmail.com</p>


                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> ที่อยู่</strong>

                    <p class="text-muted">19 หมู่ 2 ต.แม่กา อ.เมือง จ.พะเยา 56120</p>

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

                                    <button type="button" class="btn btn-success">
                                        เพิ่มแปลงหม่อน
                                    </button>


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

</script>
