<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    {{farmer.name}}

                    <div class="btn-group btn-group-sm pull-right">
                        <a v-bind:href="editUrl"
                           class=" btn btn-primary"><b>แก้ไขข้อมูลลงทะเบียน</b></a>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-4">
                            <p>
                                <label>จำนวนแปลง</label> :
                                <span>{{farmer.plants.length}}</span> <br/>
                            </p>
                            <p>
                                <label>เลขประจำตัวประชาชน</label> :
                                <span>{{farmer.identity ? farmer.identity : '-'}}</span>
                            </p>
                            <p>
                                <label>ข้อมูลติดต่อ</label> <br/>
                                <span class="text-muted">{{farmer.contact_number}}</span>
                                <span class="text-muted">{{farmer.email}}</span>

                                <label>ที่อยู่</label>

                                <span class="text-muted">
                                {{farmer.address}}
                                {{farmer.district ? farmer.district.name : ''}}
                                {{farmer.amphure ? farmer.amphure.name : ''}}
                                {{farmer.province ? farmer.province.name : ''}}
                            </span>
                            </p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            farmer: Object,
            editUrl: String,
        },
        data() {
            return {}
        },
        methods: {},
        mounted() {
        }
    }
</script>