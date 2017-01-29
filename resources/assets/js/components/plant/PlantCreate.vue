<template>
    <div class="row">
        <div class="col-md-12">

            <!-- general form elements -->

            <div class="panel panel-success">
                <div class="panel-heading">

                    <i class="fa fa-tree"></i>
                    ลงทะเบียนแปลงหม่อน
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form role="form">

                    <div class="panel-body">
                        <h3 class="box-title"><i class="fa fa-leaf"></i> ข้อมูลพื้นฐานแปลงหม่อน</h3>

                        <div class="form-group">
                            <label>เกษตรกรเจ้าของแปลง</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-male"></i>
                                </div>
                                <input type="email" class="form-control" id="user_id"
                                       placeholder="ค้นหาตามเลขประจำตัวประชาชน 13 หลัก หรือ ชื่อ-ชื่อสกุล ของเกษตรกรที่ลงทะเบียนแล้ว">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ชื่อเรียกแปลงหม่อน</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-commenting"></i>
                                </div>
                                <input type="text" class="form-control" id="name"
                                       placeholder="ชื่อเรียกแปลงหม่อน">
                            </div>
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
                        <h3 class="box-title"><i class="fa  fa-map-signs"></i> ข้อมูลพิกัดแปลงหม่อน</h3>


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
