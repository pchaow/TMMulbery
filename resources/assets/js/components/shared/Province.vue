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
                provinceId: 0,
                provinces: [],

                amphureId: 0,
                amphures: [],

                districtId: 0,
                districts: [],
            }
        },
        methods: {
            loadProvince: function () {
                return this.$http.get('/api/thailand/province')
                    .then((response) => {
                        //console.log(response);
                        this.provinces = response.data
                    }, (response) => {

                    });
            },
            loadAmphure: function (id) {

                return this.$http.get('/api/thailand/province/' + id + '/amphure')
                    .then((response) => {
                        //console.log(response);
                        this.amphures = response.data
                    }, (response) => {

                    });
            },
            loadDistrict: function (pid, aid) {
                return this.$http.get(window.strFormat("/api/thailand/province/{0}/amphure/{1}/district", pid, aid))
                    .then((response) => {
                        //console.log(response);
                        this.districts = response.data
                    }, (response) => {

                    });
            },
            updateProvince: function (value, elem) {
                this.provinceId = value
                this.loadAmphure(this.provinceId)
                this.amphureId = 0
                this.districtId = 0
                this.$emit('province_update', this.provinceId, elem.options[elem.selectedIndex].text)
                this.$emit('amphure_update', this.amphureId, "")
                this.$emit('district_update', this.districtId, "")
            },
            updateAmphure: function (value, elem) {

                if (value) {
                    this.amphureId = value
                    this.districtId = 0
                    this.loadDistrict(this.provinceId, this.amphureId)
                    this.$emit('amphure_update', this.amphureId, elem.options[elem.selectedIndex].text)
                    this.$emit('district_update', this.districtId, "")
                }
            },
            updateDistrict: function (value, elem) {
                if (value) {
                    this.districtId = value
                    this.$emit('district_update', this.districtId, elem.options[elem.selectedIndex].text)
                }
            },
        },
        created: function () {
            this.provinceId = this.province
            this.amphureId = this.amphure
            this.districtId = this.district

        },
        mounted: function () {

            var bkProvinceId = this.provinceId;
            var bkAmphureId = this.amphureId;
            var bkDistrictId = this.districtId

            this.loadProvince().then(function (r) {
                this.provinceId = bkProvinceId

                if (this.provinceId) {
                    this.loadAmphure(this.provinceId).then(function (r) {
                        this.amphureId = bkAmphureId

                        if (this.amphureId) {
                            console.log("load amphure",this.amphureId);
                            this.loadDistrict(this.provinceId, this.amphureId).then(function (r) {
                                this.districtId = bkDistrictId
                            })
                        }
                    })
                }
            });
        }
    }
</script>
