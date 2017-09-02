<template>
    <div class="row" v-if="isLoaded">
        <div class="col-md-3" v-show="showSidePanel">

            <slot></slot>

        </div>
        <!-- /.col -->
        <div v-bind:class="{'col-md-9' : showSidePanel,'col-md-12' : !showSidePanel}">

            <!-- general form elements -->

            <div class="box box-success">

                <!-- /.box-header -->
                <div class="box-header with-border">
                    <i class="fa fa-leaf"></i> ข้อมูลพื้นฐานแปลงหม่อน
                </div>
                <!-- form start -->

                <form method="post" role="form" v-on:submit.prevent="save">

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
                                  v-on:province_update="provinceUpdate(arguments[0],arguments[1])"
                                  v-bind:amphure="formInputs.amphure_id"
                                  v-on:amphure_update="amphureUpdate(arguments[0],arguments[1])"
                                  v-bind:district="formInputs.district_id"
                                  v-on:district_update="districtUpdate(arguments[0],arguments[1])"
                                  v-bind:formErrors="formErrors"
                        ></province>

                        <label><i class="fa  fa-map"></i> บริเวณพื้นที่แปลงหม่อน</label>

                        <div class="">
                            <label>ระบุตำแหน่งจากพิกัด</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>lat</label>
                                        <input type="text" v-model="lat" class="form-control" placeholder="lat"
                                               :disabled="formInputs.map.length != 0"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>lng</label>
                                        <input type="text" v-model="lng" class="form-control" placeholder="lng"
                                               :disabled="formInputs.map.length != 0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary"
                                        v-bind:class="{ disabled: formInputs.map.length != 0 }"
                                        @click="markPosition(lat,lng)">
                                    ระบุตำแหน่งจากพิกัด
                                </button>
                                <button type="button"
                                        @click="updatePositionFromAddress"
                                        class="btn btn-default">แสดงตำแหน่งจากที่อยู่
                                </button>

                                <button v-if="!marker_toggle && formInputs.map.length == 0" type="button"
                                        @click="toggleMarkerOption"
                                        class="btn btn-success">ระบุตำแหน่งบนแผนที่
                                </button>

                                <button v-if="marker_toggle" type="button"
                                        @click="toggleMarkerOption"
                                        class="btn btn-danger">ยกเลิก
                                </button>

                                <button v-if="!marker_toggle && formInputs.map.length > 0" type="button"
                                        @click="removeMarker"
                                        class="btn btn-danger">ลบพิกัด
                                </button>
                            </div>
                        </div>


                        <div class="box" style="height: 30em; width: 100%;">
                            <gmap-map
                                    ref="map"
                                    style="width: 100%; height: 100%; position: absolute; left:0; top:0"
                                    :center="map_default_position"
                                    :zoom="15"
                                    @click="mapClick">
                                <google-marker v-for="m in formInputs.map" :position="m.position"></google-marker>

                            </gmap-map>
                        </div>


                    </div>


                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary ">บันทึก</button>
                        <a v-bind:href="successUrl" class="btn btn-default ">ยกเลิก</a>
                    </div>
                </form>
            </div>
            <!-- /.box -->


        </div>
    </div>
</template>

<script>
    import Province from '../../../shared/Province.vue'

    Vue.component('google-marker', VueGoogleMaps.Marker);


    export default {
        props: {
            roleType: String,
            plant: Object,
            plant_id: String,
            showSidePanel: Boolean,
        },
        components: {
            Province
        },
        data() {

            var default_position = {lat: 18.779465, lng: 99.046323}

            if (this.plant.map[0]) {
                default_position = {lat: this.plant.map[0].position.lat, lng: this.plant.map[0].position.lng}
            }

            return {
                successUrl: null,
                isLoaded: false,
                formInputs: {
                    row_spacing: 2.5,
                    plant_spacing: 0.75,
                    area_rai: 0,
                    area_ngan: 0,
                    map: [],
                    lat: null,
                    lng: null,
                },
                textSearch: "",
                formErrors: {},
                map_default_position: default_position,
                marker_toggle: false,
                mapObject: {},
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
                var row_spacing = this.formInputs.row_spacing
                var plant_spacing = this.formInputs.plant_spacing
                var density = 1600 / (row_spacing * plant_spacing)
                density = Math.floor(density);
                this.formInputs.density = Math.floor(density);


                return density
            },

        },
        methods: {
            removeMarker: function () {
                this.formInputs.map = []
            },
            markPosition: function (lat, lng) {
                if (lat && lng) {
                    console.log(lat, lng)
                    this.formInputs.map.push({
                        position: {
                            lat: parseFloat(lat),
                            lng: parseFloat(lng)
                        }
                    })
                }

            },
            mapClick: function (event) {
                console.log(event)
                let latLng = event.latLng
                if (this.marker_toggle) {
                    this.markPosition(latLng.lat(), latLng.lng())
                    this.toggleMarkerOption()
                } else {

                }
            },
            toggleMarkerOption: function () {
                this.marker_toggle = !this.marker_toggle
                let map = this.$refs.map.$mapObject
                if (this.marker_toggle) {

                    map.setOptions({
                        draggableCursor: 'crosshair'
                    });
                } else {
                    map.setOptions({
                        draggableCursor: 'default'
                    });
                }
            },
            updatePositionFromAddress: function () {
                let map = this.$refs.map.$mapObject

                console.log(this.formInputs);

                if (this.formInputs.map.length > 0) {
                    map.setCenter(this.formInputs.map[0].position)
                }

                else if (!(this.formInputs.province_name && this.formInputs.amphure_name && this.formInputs.district_name )) {
                    alert('กรุณาเลือก จังหวัด อำเภอ ตำบล')
                } else {
                    let addressStr = "จังหวัด" + this.formInputs.province_name
                    addressStr += '+ อำเภอ' + this.formInputs.amphure_name
                    addressStr += '+ ตำบล' + this.formInputs.district_name

                    let geocoder = new google.maps.Geocoder();
                    let self = this
                    geocoder.geocode({'address': addressStr}, function (results, status) {
                        if (status === 'OK') {
                            self.map_default_position = {
                                lat: results[0].geometry.location.lat(),
                                lng: results[0].geometry.location.lng()
                            }

                        } else {
                            console.log('Geocode was not successful for the following reason: ' + status);
                        }
                    });
                }


            },
            save: function () {
                this.formErrors = {}
                this.$http.put(this.$routes.api[this.roleType].plant + "/" + this.plant_id, this.formInputs)
                    .then((response) => {
                        window.location.href = this.successUrl
                    }, (response) => {
                        // error callback
                        this.formErrors = response.data;
                    });
            },

            provinceUpdate: function (val, name) {
                this.formInputs.province_id = val
                this.formInputs.province_name = name
                this.calculateAddress()
            },
            amphureUpdate: function (val, name) {
                this.formInputs.amphure_id = val
                this.formInputs.amphure_name = name
                this.calculateAddress()
            },
            districtUpdate: function (val, name) {
                this.formInputs.district_id = val
                this.formInputs.district_name = name
                this.calculateAddress()
            },
            calculateAddress: function () {
                var text = this.formInputs.district_name + " " + this.formInputs.amphure_name + " " + this.formInputs.province_name;
                this.textSearch = text;
            },

            loadPlant: function () {
                this.isLoaded = false;
                axios.get(this.$routes.api[this.roleType].plant + "/" + this.plant_id)
                    .then(res => {
                        this.formInputs = res.data;
                        console.log('loadPlant', this.formInputs);
                        this.isLoaded = true;
                    })
            }
        },
        created() {
            this.loadPlant();
            this.successUrl = this.roleType == "farmer" ? this.$routes.web.farmer.index : this.$routes.web[this.roleType].plant;

        },
        mounted() {

        },
    }


</script>
