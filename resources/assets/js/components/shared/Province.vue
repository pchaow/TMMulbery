<template>
    <div>
        <div class="form-group" v-bind:class="{ 'has-error': formErrors['province_id'] }">
            <label class="control-label">จังหวัด : </label>
            <select class="form-control" v-model="provinceId"
                    v-on:change="updateProvince($event.target.value,$event.target)">
                <option value="0">กรุณาเลือก</option>
                <option v-for="province in provinces" v-bind:value="province.id">{{province.name}}</option>
            </select>
            <span v-if="formErrors['province_id']"
                  class="help-block">{{ formErrors['province_id'] }}</span>
        </div>

        <div class="form-group" v-bind:class="{ 'has-error': formErrors['amphure_id'] }">
            <label class="control-label">อำเภอ : </label>
            <select class="form-control" v-model="amphureId"
                    v-on:change="updateAmphure($event.target.value,$event.target)">
                <option value="0">กรุณาเลือก</option>
                <option v-for="amphure in amphures" v-bind:value="amphure.id">{{amphure.name}}</option>
            </select>
            <span v-if="formErrors['amphure_id']"
                  class="help-block">{{ formErrors['amphure_id'] }}</span>
        </div>

        <div class="form-group" v-bind:class="{ 'has-error': formErrors['district_id'] }">
            <label class="control-label">ตำบล : </label>
            <select class="form-control" v-model="districtId"
                    v-on:change="updateDistrict($event.target.value,$event.target)">
                <option value="0">กรุณาเลือก</option>
                <option v-for="district in districts" v-bind:value="district.id">{{district.name}}</option>
            </select>
            <span v-if="formErrors['district_id']"
                  class="help-block">{{ formErrors['district_id'] }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            province: {
                type: [Number, String],
                default: 0
            },
            amphure: {
                type: [Number, String],
                default: 0
            },
            district: {
                type: [Number, String],
                default: 0
            },
            formErrors: {
                type: [Object, Array],
                default: function () {
                    return {};
                }
            }
        },
        data() {
            return {
                backup: {},
                provinceId: 0,
                provinces: [],

                amphureId: 0,
                amphures: [],

                districtId: 0,
                districts: [],

                isLocked: false,
            }
        },
        methods: {

            loadProvince: function () {
                return this.$http.get('/api/thailand/province')
                    .then((response) => {
                        this.provinces = response.data
                    }, (response) => {

                    });
            },
            loadAmphure: function (id) {

                return this.$http.get('/api/thailand/province/' + id + '/amphure')
                    .then((response) => {
                        this.amphures = response.data
                    }, (response) => {

                    });
            },
            loadDistrict: function (pid, aid) {
                return this.$http.get(window.strFormat("/api/thailand/province/{0}/amphure/{1}/district", pid, aid))
                    .then((response) => {
                        this.districts = response.data
                    }, (response) => {

                    });
            },
            updateProvince: function (value, elem) {
                console.log("update province", this.isLocked)
                if (!this.isLocked) {
                    this.isLocked = true;
                    this.$emit("province_update", value)
                    this.provinceId = value;

                    this.$emit("amphure_update", 0)
                    this.$emit("district_update", 0)

                    this.loadAmphure(this.provinceId)
                    this.amphureId = 0;
                    this.districtId = 0;
                    this.districts = [];

                    this.isLocked = false;
                }

            },
            updateAmphure: function (value, elem) {
                console.log("update amphure", this.isLocked)
                if (!this.isLocked) {
                    this.isLocked = true;
                    this.$emit("amphure_update", value)
                    this.amphureId = value
                    this.$emit("district_update", 0)
                    this.loadDistrict(this.provinceId, this.amphureId)
                    this.districtId = 0;
                    this.isLocked = false;
                }
            },
            updateDistrict: function (value, elem) {

                if (!this.isLocked) {
                    console.log('district not lock', value)
                    this.$emit("district_update", value)
                    this.districtId = value;
                }
            },

        },
        created: function () {
            this.isLocked = true;
            this.loadProvince().then(() => {
                this.provinceId = this.province ? this.province : 0;

                this.loadAmphure(this.province)
                    .then(() => {
                        this.amphureId = this.amphure ? this.amphure : 0;

                        this.loadDistrict(this.province, this.amphure)
                            .then(() => {
                                console.log(this.district);
                                this.districtId = this.district ? this.district : 0;
                                console.log(this.districtId);
                                this.isLocked = false;

                            })
                    })
            })
        },
        mounted: function () {


        }
    }
</script>
