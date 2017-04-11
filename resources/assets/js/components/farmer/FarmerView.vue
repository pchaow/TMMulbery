<template>
    <div class="row" v-if="farmer">
        <div class="col-md-3">

            <farmer-profile-column
                    :farmer="farmer"
                    :edit-url="farmerEditUrl"
            ></farmer-profile-column>

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
                                        <tr v-for="plant in farmer.plants">

                                            <td>{{plant.name}}</td>
                                            <td>{{plant.area_sqm}}</td>
                                            <td><span class="badge bg-gray">Unknown</span></td>
                                            <td>{{plant.district ? plant.district.name : '-'}}</td>
                                            <td>{{plant.amphure ? plant.amphure.name : '-'}}</td>
                                            <td>{{plant.province ? plant.province.name : '-'}}</td>
                                            <td>

                                                <a class="btn btn-primary"
                                                   v-bind:href="strFormat(plantEditUrl,{id : plant.id})">แก้ไข</a>
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
    import FarmerProfileColumn from './FarmerProfileColumn.vue'

    export default {
        props: {
            loadUrl: String,
            farmerEditUrl: String,
            loadPlantUrl: String,
            plantCreateUrl: String,
            plantEditUrl: String,
            farmer: Object,
        },
        components: {
            FarmerProfileColumn
        },
        data() {
            return {}
        },
        methods: {
            strFormat: window.strFormat,

        },
        mounted() {
            console.log('ready to view farmer.id =', this.farmerId)
        }
    }
</script>