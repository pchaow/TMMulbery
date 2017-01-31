<template>
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">farmer.name</h3>

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
        <div class="col-md-9">

            <!-- general form elements -->

            <div class="box box-success">

                <!-- /.box-header -->
                <div class="box-header with-border">
                    <i class="fa fa-leaf"></i> ข้อมูลพื้นฐานแปลงหม่อน</div>
                <!-- form start -->

                <form role="form">

                    <div class="box-body">


                        <div class="form-group">
                            <label for="row_spacing">ชื่อเรียกแปลงหม่อน</label>
                            <input type="text" class="form-control" id="name"
                                   placeholder="ชื่อเรียกแปลงหม่อน">

                        </div>
                        <div class="form-group">
                            <label for="row_spacing">ระยะปลูกระหว่างแถว(เมตร)</label>
                            <input type="text" class="form-control" id="row_spacing"
                                   placeholder="ระยะปลูกระหว่างแถว(เมตร)">

                        </div>
                        <div class="form-group">
                            <label for="plant_spacing">ระยะปลูกระหว่างต้น(เมตร)</label>
                            <input type="text" class="form-control" id="plant_spacing"
                                   placeholder="ระยะปลูกระหว่างต้น(เมตร)">

                        </div>
                        <div class="form-group">
                            <label for="density">จำนวนต้น/ไร่</label>
                            <input disabled type="text" class="form-control" id="density"
                                   placeholder="จำนวนต้น/ไร่">

                        </div>
                        <div class="form-group">
                            <label for="quality">สภาวะแวดล้อมบริเวณใกล้เคียงแปลงหม่อน</label>
                            <textarea class="form-control" rows="3" id="quality"
                                      placeholder="สิ่งปลูกสร้าง/สภาวะแวดล้อม บริเวณใกล้เคียงแปลงหม่อน เช่น แม่น้ำ โรงงาน ไร่ข้าวโพด"></textarea>


                        </div>


                        <!-- /.input group -->

                    <strong><i class="fa fa-map-signs margin-r-5"></i> ข้อมูลพิกัดแปลงหม่อน</strong>
                        <div class="form-group">
                            <label>จังหวัด</label>
                            <select class="form-control">
                                <option>กรุณาเลือกจังหวัด</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                                <option>option 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>อำเภอ</label>
                            <select class="form-control">
                                <option>กรุณาเลือกอำเภอ</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                                <option>option 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ตำบล</label>
                            <select class="form-control">
                                <option>กรุณาเลือกตำบล</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                                <option>option 5</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fa  fa-map"></i> บริเวณพื้นที่แปลงหม่อน</label>
                            <div id="map">
                                draw map
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="area_sqm">ขนาดพื้นที่แปลงหม่อนโดยประมาณ(ตารางเมตร)</label>
                            <input disabled type="text" class="form-control" id="area_sqm">

                        </div>
                    </div>


                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">บันทึก</button>
                        <a v-bind:href="successUrl" class="btn btn-default">ยกเลิก</a>
                    </div>
                </form>
            </div>
            <!-- /.box -->


        </div>
    </div>


</template>

<script>
export default {
        props: {
            successUrl : String,
            saveUrl : String,
        },
        data() {
            return {
                formInputs: {},
                formErrors: [],
            }
        },
        methods: {
            save: function () {
                this.formErrors = [];
                this.$http.post(this.saveUrl, this.formInputs)
                        .then((response) => {
                            // success callback
                            window.location.href = this.successUrl

                        }, (response) => {
                            // error callback
                            this.formErrors = response.data;
                        });

            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }


</script>
