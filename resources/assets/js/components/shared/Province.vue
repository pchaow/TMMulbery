<template>
    <div>
        <div class="form-group" v-bind:class="{ 'has-error': formErrors['province_id'] }">
            <label class="control-label">จังหวัด : </label>
            <select class="form-control" v-model="provinceId" v-bind:disabled="disabled"
                    v-on:change="updateProvince($event.target.value,$event.target)">
                <option value="0">กรุณาเลือก</option>
                <option v-for="province in provinces" v-bind:value="province.id">{{province.name}}</option>
            </select>
            <span v-if="formErrors['province_id']"
                  class="help-block">{{ formErrors['province_id'] }}</span>
        </div>

        <div class="form-group" v-bind:class="{ 'has-error': formErrors['amphure_id'] }">
            <label class="control-label">อำเภอ : </label>
            <select class="form-control" v-model="amphureId" v-bind:disabled="disabled"
                    v-on:change="updateAmphure($event.target.value,$event.target)">
                <option value="0">กรุณาเลือก</option>
                <option v-for="amphure in amphures" v-bind:value="amphure.id">{{amphure.name}}</option>
            </select>
            <span v-if="formErrors['amphure_id']"
                  class="help-block">{{ formErrors['amphure_id'] }}</span>
        </div>

        <div class="form-group" v-bind:class="{ 'has-error': formErrors['district_id'] }">
            <label class="control-label">ตำบล : </label>
            <select class="form-control" v-model="districtId" v-bind:disabled="disabled"
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
            },
            disabled: {
                type: [Boolean],
                default: function () {
                    return false;
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

                lockStep: 0,
            }
        },
        computed: {
            isLocked: function () {
                if (this.lockStep == 0) return false;
                return true;
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
//                window.test = elem;
//                console.log("update province", this.isLocked)
                if (!this.isLocked) {
                    this.lockStep += 1;
                    this.$emit("province_update", value,elem.selectedOptions[0].innerText)
                    this.provinceId = value;

                    this.$emit("amphure_update", 0)
                    this.$emit("district_update", 0)

                    this.loadAmphure(this.provinceId)
                    this.amphureId = 0;
                    this.districtId = 0;
                    this.districts = [];

                    this.lockStep -= 1;
                }

            },
            updateAmphure: function (value, elem) {
//                console.log("update amphure", this.isLocked)
                if (!this.isLocked) {
                    this.lockStep += 1;
                    this.$emit("amphure_update", value,elem.selectedOptions[0].innerText)
                    this.amphureId = value
                    this.$emit("district_update", 0)
                    this.loadDistrict(this.provinceId, this.amphureId)
                    this.districtId = 0;
                    this.lockStep -= 1;
                }
            },
            updateDistrict: function (value, elem) {

                if (!this.isLocked) {
//                    console.log('district not lock', value)
                    this.$emit("district_update", value,elem.selectedOptions[0].innerText)
                    this.districtId = value;
                }
            },
            initialData: function () {
                this.lockStep += 1;
                this.loadProvince().then(() => {
                    this.provinceId = this.province ? this.province : 0;
                    if (this.provinceId == 0) this.locked = false;
                    this.lockStep += 1;
                    this.loadAmphure(this.province)
                        .then(() => {
                            this.amphureId = this.amphure ? this.amphure : 0;
                            if (this.amphureId == 0) this.locked = false;
                            if (this.province && this.amphures) {
                                this.lockStep += 1;
                                this.loadDistrict(this.province, this.amphure)
                                    .then(() => {
//                                        console.log(this.district);
                                        this.districtId = this.district ? this.district : 0;
//                                        console.log(this.districtId);

                                    })
                                    .finally( () => {
                                        this.lockStep -= 1;
                                    })
                            }
                        })
                        .finally(() => {
                            this.lockStep -= 1;
                        })

                }).finally(() => {
                    this.lockStep -= 1;
//                    console.log("finally", this.isLocked);
                })
            }
        },
        created: function () {
            this.initialData();
        },
        mounted: function () {


        }
    }
</script>
