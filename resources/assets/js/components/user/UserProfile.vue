<template>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" v-on:submit.prevent="save">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        แก้ไขข้อมูลส่วนตัว
                    </div>

                    <div class="panel-body">

                        <div class="col-lg-12" v-if="formInputs">

                            <fieldset>

                                <div class="form-group">
                                    <h4>ข้อมูลส่วนตัว</h4>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['identity'] }">
                                    <label class="control-label">เลขประจำตัวประชาชน : </label>
                                    <input readonly class="form-control" placeholder="หมายเลขประจำตัวประชาชน 13 หลัก"
                                           v-model="formInputs.identity"/>
                                    <span v-if="formErrors['identity']"
                                          class="help-block">{{ formErrors['identity'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                                    <label class="control-label">ชื่อ-นามสกุล : </label>
                                    <input readonly class="form-control" placeholder="Name" v-model="formInputs.name"/>
                                    <span v-if="formErrors['name']"
                                          class="help-block">{{ formErrors['name'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['contact_number'] }">
                                    <label class="control-label">เบอร์โทรศัพท์ : </label>
                                    <input class="form-control" placeholder="เบอร์โทรศัพท์"
                                           v-model="formInputs.contact_number"/>
                                    <span v-if="formErrors['contact_number']" class="help-block">{{ formErrors['contact_number'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['address'] }">
                                    <label class="control-label">ที่อยู่ : </label>
                                    <input class="form-control" placeholder="ที่อยู่" v-model="formInputs.address"/>
                                    <span v-if="formErrors['address']"
                                          class="help-block">{{ formErrors['address'] }}</span>
                                </div>


                                <province v-bind:province="formInputs.province_id"
                                          v-on:province_update="formInputs.province_id = arguments[0]"
                                          v-bind:amphure="formInputs.amphure_id"
                                          v-on:amphure_update="formInputs.amphure_id = arguments[0]"
                                          v-bind:district="formInputs.district_id"
                                          v-on:district_update="formInputs.district_id = arguments[0]"
                                          v-bind:formErrors="formErrors"
                                ></province>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['postal_code'] }">
                                    <label class="control-label">รหัสไปรษณีย์ : </label>
                                    <input class="form-control" placeholder="รหัสไปรษณีย์"
                                           v-model="formInputs.postal_code"/>
                                    <span v-if="formErrors['postal_code']" class="help-block">{{ formErrors['postal_code'] }}</span>
                                </div>
                            </fieldset>

                            <fieldset v-if="isBuyer(formInputs)">

                                <div class="form-group">
                                    <h4>พิกัดสำนักงาน</h4>
                                </div>

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
                                            v-bind:class="{ disabled: formInputs.map && formInputs.map.length != 0 }"
                                            @click="markPosition(lat,lng)">
                                        ระบุตำแหน่งจากพิกัด
                                    </button>
                                    <button type="button"
                                            @click="updatePositionFromAddress"
                                            class="btn btn-default">แสดงตำแหน่งจากที่อยู่
                                    </button>

                                    <button v-if="!marker_toggle && formInputs.map && formInputs.map.length == 0"
                                            type="button"
                                            @click="toggleMarkerOption"
                                            class="btn btn-success">ระบุตำแหน่งบนแผนที่
                                    </button>

                                    <button v-if="marker_toggle" type="button"
                                            @click="toggleMarkerOption"
                                            class="btn btn-danger">ยกเลิก
                                    </button>

                                    <button v-if="!marker_toggle && formInputs.map && formInputs.map.length > 0"
                                            type="button"
                                            @click="removeMarker"
                                            class="btn btn-danger">ลบพิกัด
                                    </button>
                                </div>

                                <div class="box" style="height: 30em; width: 100%;">
                                    <gmap-map
                                            ref="map"
                                            style="width: 100%; height: 100%; position: absolute; left:0; top:0"
                                            :center="map_default_position"
                                            :zoom="15"
                                            @click="mapClick">
                                        <google-marker v-for="m in formInputs.map"
                                                       :position="m.position"></google-marker>

                                    </gmap-map>
                                </div>

                            </fieldset>


                            <fieldset>

                                <div class="form-group">
                                    <h4>ข้อมูลการเข้าใช้งานระบบ</h4>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['email'] }">
                                    <label class="control-label">E-mail : </label>
                                    <input readonly class="form-control" placeholder="E-mail"
                                           v-model="formInputs.email"/>
                                    <span v-if="formErrors['email']" class="help-block">{{ formErrors['email'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['username'] }">
                                    <label class="control-label">ชื่อบัญชีผู้ใช้ : </label>
                                    <input readonly type="text" class="form-control" placeholder="Username"
                                           v-model="formInputs.username"/>
                                    <span v-if="formErrors['username']"
                                          class="help-block">{{ formErrors['username'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['password'] }">
                                    <label class="control-label">รหัสผ่าน : </label>
                                    <input type="password" class="form-control" placeholder="Password"
                                           v-model="formInputs.password"/>
                                    <span v-if="formErrors['password']"
                                          class="help-block">{{ formErrors['password'] }}</span>
                                </div>

                                <div class="form-group"
                                     v-bind:class="{ 'has-error': formErrors['password_confirmation '] }">
                                    <label class="control-label">ยืนยันรหัสผ่าน : </label>
                                    <input type="password" class="form-control" placeholder="Password Confirmation"
                                           v-model="formInputs.password_confirmation "/>
                                    <span v-if="formErrors['password_confirmation ']" class="help-block">{{ formErrors['password_confirmation '] }}</span>
                                </div>
                            </fieldset>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="/home" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>
</template>

<script>
    import Province from '../shared/Province.vue'

    Vue.component('google-marker', VueGoogleMaps.Marker);

    export default {
        props: {
            userId: Number,
            saveUrl: String,
            loadUrl: String,
            successUrl: String,
        },
        components: {
            Province
        },
        data() {

            return {
                roles: [],
                formInputs: null,
                formErrors: [],

                map_default_position: {lat: 18.779465, lng: 99.046323},
                marker_toggle: false,
                mapObject: {},
            }
        },
        methods: {

            isBuyer: function (user) {
                for (var i = 0; i < user.roles.length; i++) {
                    if (user.roles[i].name == 'buyer') return true;
                }
                return false;
            },
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
                            console.log(results);

//                            self.map_default_position = {
//                                lat: results[0].geometry.location.lat(),
//                                lng: results[0].geometry.location.lng()
//                            }

                            map.setCenter(results[0].geometry.location)

                        } else {
                            console.log('Geocode was not successful for the following reason: ' + status);
                        }
                    });
                }
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

            save: function () {
                this.formErrors = [];
                this.$http.put(this.saveUrl, this.formInputs)
                    .then((response) => {
                        // success callback
                        // console.log(response);
                        window.location.href = this.successUrl
                    }, (response) => {
                        // error callback
                        this.formErrors = response.data;
                    });


            },
            load: function () {

                this.$http.get(this.loadUrl)
                    .then((response) => {
                        // success callback

                        this.formInputs = response.data;
                        if (!this.formInputs.map) {
                            this.formInputs.map = [];
                        } else if (this.formInputs.map.length > 0) {
                            this.map_default_position = {
                                lat: this.formInputs.map[0].position.lat,
                                lng: this.formInputs.map[0].position.lng
                            }
                        }
                        console.log(response.data);
                    }, (response) => {
                        // error callback
                        this.formErrors = response.data;
                    })
            },
        },
        created() {
        },
        mounted() {
            console.log('ready to edit user.id =', this.userId)
            this.load()
        }
    }
</script>
