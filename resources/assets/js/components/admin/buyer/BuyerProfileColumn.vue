<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    {{buyer.name}}
                    <div class="btn-group btn-group-sm pull-right">
                        <a v-bind:href="editUrl"
                           class=" btn btn-primary"><b>แก้ไขข้อมูลผู้รับซื้อ</b></a>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-4">
                            <p>
                                <label>เลขประจำตัวประชาชน</label> :
                                <span>{{buyer.identity ? buyer.identity : '-'}}</span>
                            </p>
                            <p>
                                <label>ข้อมูลติดต่อ</label> <br/>
                                <span class="text-muted">{{buyer.contact_number}}</span>
                                <span class="text-muted">{{buyer.email}}</span>

                                <label>ที่อยู่</label>

                                <span class="text-muted">
                                {{buyer.address}}
                                {{buyer.district ? buyer.district.name : ''}}
                                {{buyer.amphure ? buyer.amphure.name : ''}}
                                {{buyer.province ? buyer.province.name : ''}}
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
            buyer: Object,
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