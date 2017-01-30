<template>
    <div>
        <div class="form-group">
            <label class="control-label">จังหวัด : </label>
            <select class="form-control" v-model="provinceId" v-on:change="updateProvince($event.target.value)">
                <option value="0">กรุณาเลือก</option>
                <option v-for="province in provinces" v-bind:value="province.id">{{province.name}}</option>
            </select>
        </div>

        <div class="form-group">
            <label class="control-label">อำเภอ : </label>
            <select class="form-control" v-model="amphureId" v-on:change="updateAmphure($event.target.value)">
                <option value="0">กรุณาเลือก</option>
                <option v-for="amphure in amphures" v-bind:value="amphure.id">{{amphure.name}}</option>
            </select>
        </div>

        <div class="form-group">
            <label class="control-label">ตำบล : </label>
            <select class="form-control" v-model="districtId" v-on:change="updateDistrict($event.target.value)">
                <option value="0">กรุณาเลือก</option>
                <option v-for="district in districts" v-bind:value="district.id">{{district.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default{
        props: {
            province : {
                type : Number,
                default : 0
            },
            amphure : {
                type : Number,
                default : 0
            },
            district : {
                type : Number,
                default : 0
            },
            formErrors : {
                type : [Object,Array],
                default : function(){return {};}
            }
        },
        data(){
            return{
                provinceId : 0,
                provinces : [],

                amphureId : 0,
                amphures: [],

                districtId : 0,
                districts : [],
            }
        },
        methods : {
            loadProvince : function(){
                this.$http.get('/api/thailand/province')
                    .then((response) => {
                        //console.log(response);
                        this.provinces = response.data
                    }, (response) => {

                    });
            },
            loadAmphure : function(id){

                this.$http.get('/api/thailand/province/'+id+'/amphure')
                    .then((response) => {
                        //console.log(response);
                        this.amphures = response.data
                    }, (response) => {

                    });
            },

            loadDistrict : function(pid,aid){
                this.$http.get(window.strFormat("/api/thailand/province/{0}/amphure/{1}/district",pid,aid))
                    .then((response) => {
                        //console.log(response);
                        this.districts = response.data
                    }, (response) => {

                    });
            },

            updateProvince : function(value){
                this.provinceId = value
                this.loadAmphure(this.provinceId)
                this.amphureId = 0
                this.distrcitId = 0
                this.$emit('province_update', this.provinceId)
                this.$emit('amphure_update', this.amphureId)
                this.$emit('district_update', this.districtId)
            },
            updateAmphure: function(value){
                console.log(value)
                if(value){
                    this.amphureId = value
                    this.distrcitId = 0
                    this.loadDistrict(this.provinceId,this.amphureId)
                this.$emit('amphure_update', this.amphureId)
                this.$emit('district_update', this.districtId)
                }
            },
            updateDistrict: function(value){
                if(value){
                this.districtId = value
                this.$emit('district_update', this.districtId)
                }

            },



        },
        mounted : function(){
            this.provinceId  = this.province
            this.amphureId  = this.amphure
            this.districtId  = this.district

            this.loadProvince();
        }
    }

</script>
