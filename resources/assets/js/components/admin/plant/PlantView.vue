<template>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    จัดการการปลูก
                </div>

                <div class="panel-body">
                    <button @click="changeState(1)" class="btn btn-app">
                        <i class="fa fa-pencil"></i> เริ่มต้นปลูก
                    </button>

                    <button @click="changeState(2)" class="btn btn-app">
                        <i class="fa fa-money"></i> เก็บเกี่ยว
                    </button>
                </div>

            </div>

            <div class="panel panel-info" v-if="currentState == states[1]">
                <div class="panel-heading">
                    เริ่มต้นปลูก
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            เริ่มต้นปลูก
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-default" @click="changeState(0)">ยกเลิก</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info"  v-if="currentState == states[2]">
                <div class="panel-heading">
                    เก็บเกี่ยว
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            เก็บเกี่ยว
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-default" @click="changeState(0)">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    รายการการปลูก
                </div>

                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            plantTransactionApiUrl: String,
            plantApiUrl: String,
            plantPage: String,
        },
        data() {
            return {
                states : ["none","new","harvest"],
                currentState : "none",
            }
        },
        methods: {
            strFormat: window.strFormat,
            changeState : function(stateId){
                this.currentState = this.states[stateId];
            }

        },
        created(){
        },
        mounted() {
            console.log('Component mounted.')

        }
    }


</script>
