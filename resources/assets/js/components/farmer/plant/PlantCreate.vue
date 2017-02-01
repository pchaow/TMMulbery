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
        <div class="col-md-9">

            <!-- general form elements -->

            <div class="box box-success">

                <!-- /.box-header -->
                <div class="box-header with-border">
                    <i class="fa fa-leaf"></i> ข้อมูลพื้นฐานแปลงหม่อน
                </div>
                <!-- form start -->

                <form role="form" v-on:submit.prevent="save">

                    <div class="box-body">

                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                            <label for="row_spacing">ชื่อเรียกแปลงหม่อน</label>
                            <input type="text" class="form-control" id="name" v-model="formInputs.name"
                                   placeholder="ชื่อเรียกแปลงหม่อน">
                            <span v-if="formErrors['name']"
                                  class="help-block">{{ formErrors['name'] }}</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['area_rai'] }">
                                    <label for="area_rai">จำนวนไร่</label>
                                    <input type="text" class="form-control"
                                           id="area_rai" v-model="formInputs.area_rai"
                                           placeholder="จำนวนไร่">
                                    <span v-if="formErrors['area_rai']"
                                          class="help-block">{{ formErrors['area_rai'] }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['area_ngan'] }">
                                    <label for="area_ngan">งาน</label>
                                    <input type="text" class="form-control"
                                           id="area_ngan"
                                           v-model="formInputs.area_ngan"
                                           placeholder="งาน">
                                    <span v-if="formErrors['area_ngan']"
                                          class="help-block">{{ formErrors['area_ngan'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['area_sqm'] }">
                            <label for="row_spacing">ขนาดพื้นที่แปลงหม่อนโดยประมาณ(ตารางเมตร)</label>
                            <input readonly type="text" class="form-control" id="area_sqm"
                                   v-bind:value="calculateAreaSqm"
                                   placeholder="ขนาดพื้นที่แปลงหม่อนโดยประมาณ(ตารางเมตร)">
                            <span v-if="formErrors['area_sqm']"
                                  class="help-block">{{ formErrors['area_sqm'] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['row_spacing'] }">
                            <label for="row_spacing">ระยะปลูกระหว่างแถว(เมตร)</label>
                            <input type="text" class="form-control" id="row_spacing"
                                   v-model="formInputs.row_spacing"
                                   placeholder="ระยะปลูกระหว่างแถว(เมตร)">
                            <span v-if="formErrors['row_spacing']"
                                  class="help-block">{{ formErrors['row_spacing'] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['plant_spacing'] }">
                            <label for="row_spacing">ระยะปลูกระหว่างต้น(เมตร)</label>
                            <input type="text" class="form-control" id="plant_spacing"
                                   v-model="formInputs.plant_spacing"
                                   placeholder="ระยะปลูกระหว่างแถว(เมตร)">
                            <span v-if="formErrors['plant_spacing']"
                                  class="help-block">{{ formErrors['plant_spacing'] }}</span>
                        </div>


                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['density'] }">
                            <label for="density">จำนวนต้นต่อไร่</label>
                            <input readonly type="text" class="form-control" id="density"
                                   v-bind:value="calculateDensity"
                                   placeholder="จำนวนต้นต่อไร่">
                            <span v-if="formErrors['density']"
                                  class="help-block">{{ formErrors['density'] }}</span>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': formErrors['quality'] }">
                            <label for="quality">สิ่งแวดล้อมใกล้เคียงแปลงหม่อน</label>
                            <textarea class="form-control" rows="3" id="quality"
                                      placeholder="สิ่งปลูกสร้าง/สภาวะแวดล้อม บริเวณใกล้เคียงแปลงหม่อน เช่น แม่น้ำ โรงงาน ไร่ข้าวโพด"
                                      v-model="formInputs.quality"></textarea>
                            <span v-if="formErrors['quality']"
                                  class="help-block">{{ formErrors['quality'] }}</span>
                        </div>
                        <!-- /.input group -->

                        <strong><i class="fa fa-map-signs margin-r-5"></i> ข้อมูลพิกัดแปลงหม่อน</strong>

                        <province v-bind:province="formInputs.province_id"
                                  v-on:province_update="formInputs.province_id = arguments[0]"
                                  v-bind:amphure="formInputs.amphure_id"
                                  v-on:amphure_update="formInputs.amphure_id = arguments[0]"
                                  v-bind:district="formInputs.district_id"
                                  v-on:district_update="formInputs.district_id = arguments[0]"
                                  v-bind:formErrors="formErrors"
                        ></province>

                        <div class="form-group">
                            <label><i class="fa  fa-map"></i> บริเวณพื้นที่แปลงหม่อน</label>

                            <g-map></g-map>


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
    import Province from '../../shared/Province.vue'
    import GMap from '../../shared/GMap.vue'

    export default {
        props: {
            loadUrl: String,  //load farmer
            editUrl: String,
            savePlantUrl: String,
            plantCreateUrl: String,
            farmerId: Number,
        },
        components: {
            Province,
            GMap
        },
        data() {
            return {
                farmer: null,
                formInputs: {
                    row_spacing: 2.5,
                    plant_spacing: 0.75,
                    area_rai: 0,
                    area_ngan: 0
                },
                plants: null,
                formErrors: {},
            }
        },
        computed: {
            // a computed getter
            calculateAreaSqm: function () {
                var rai = parseInt(this.formInputs.area_rai ? this.formInputs.area_rai : 0)
                var ngan = parseInt(this.formInputs.area_ngan ? this.formInputs.area_ngan : 0)

                var sqm = (1600 * rai) + (400 * ngan)

                this.formInputs.area_sqm = Math.floor(sqm);
                return sqm;
            },
            calculateDensity: function () {
                console.log("test")
                var row_spacing = this.formInputs.row_spacing
                var plant_spacing = this.formInputs.plant_spacing
                var density = 1600 / (row_spacing * plant_spacing)
                this.formInputs.density = Math.floor(density);

                return density
            },
        },
        methods: {
            save: function () {
                this.$http.post(this.savePlantUrl, this.formInputs)
                    .then((response) => {

                    }, (response) => {
                        // error callback
                        this.formErrors = response.data;
                    });
            },


            load: function () {
                return this.$http.get(this.loadUrl)
                    .then((response) => {
                        // success callback
                        // console.log(response);
                        this.farmer = response.data;
                    }, (response) => {

                    })
            },
        }
        ,
        mounted()
        {
            console.log('ready to view farmer.id =', this.farmerId)
            this.load()
        }
    }





</script>
