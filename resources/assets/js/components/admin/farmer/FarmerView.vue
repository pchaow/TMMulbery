<template>
    <div class="row" v-if="farmer">
        <div class="col-md-3" v-show="showSidePanel">

            <farmer-profile-column v-if="farmerData"
                                   :farmer="farmerData"
                                   :edit-url="farmerEditUrl"
            ></farmer-profile-column>

        </div>
        <!-- /.col -->
        <div v-bind:class="{'col-md-9' : showSidePanel,'col-md-12' : !showSidePanel}">
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
                                        <tr v-for="plant in farmerData.plants">

                                            <td>{{plant.name}}</td>
                                            <td>{{plant.area_sqm}}</td>
                                            <td>{{plant.remainingBalance}}</td>
                                            <td>{{plant.district ? plant.district.name : '-'}}</td>
                                            <td>{{plant.amphure ? plant.amphure.name : '-'}}</td>
                                            <td>{{plant.province ? plant.province.name : '-'}}</td>
                                            <td>
                                                <a class="btn btn-success"
                                                   v-bind:href="strFormat(plantTransactionUrl,{id : plant.id})"
                                                >
                                                    การปลูก
                                                </a>
                                                <a class="btn btn-primary"
                                                   v-bind:href="strFormat(plantEditUrl,{id : plant.id})">แก้ไข</a>
                                                <button @click="deletePlant(plant)" type="button"
                                                        class="btn btn-danger">
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
            farmerLoadUrl: String,
            plantCreateUrl: String,
            plantEditUrl: String,
            plantDeleteUrl: String,
            plantTransactionUrl: String,
            farmer: Object,
            showSidePanel: true,

        },
        components: {
            FarmerProfileColumn
        },
        data() {
            return {
                farmerData: {
                    withbalance: true,
                    withLastHarvest: true,
                }
            }
        },
        methods: {
            strFormat: window.strFormat,
            loadFarmerData: function () {
                this.$http.get(this.farmerLoadUrl).then(
                    function (response) {
                        this.farmerData = response.data
                    }
                )
            },
            deletePlant: function (plant) {
                if (confirm("Do you want to delete this plant?")) {
                    this.$http.delete(this.strFormat(this.plantDeleteUrl, {id: plant.id}), {}).then(function (r) {
                        this.loadFarmerData();
                    })
                }
            },

        },
        created() {
            this.farmerData = this.farmer;
        },
        mounted() {

            console.log(this.showSidePanel)

        }
    }
</script>