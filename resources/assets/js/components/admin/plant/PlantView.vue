<template>

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    จัดการการปลูก
                </div>

                <div class="panel-body">
                    <button @click="changeState(1)" class="btn btn-app"
                            v-bind:class="{disabled : transactions.length > 0}">
                        <i class="fa fa-pencil"></i> เริ่มต้นปลูก
                    </button>

                    <button @click="changeState(2)" class="btn btn-app"
                            v-bind:class="{disabled : transactions.length == 0}">
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
                            <form @submit.prevent="saveInitialForm()">
                                <div class="form-group">
                                    <label>วันที่ปลูก:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input v-model="initialForm.transaction_date" type="date"
                                               class="form-control pull-right">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>จำนวนต้น:</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calculator"></i>
                                        </div>
                                        <input v-model="initialForm.amount" type="number"
                                               class="form-control pull-right">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">บันทึก</button>
                                    <button class="btn btn-default" type="button" @click="changeState(0)">ยกเลิก
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info" v-if="currentState == states[2]">
                <div class="panel-heading">
                    เก็บเกี่ยว
                </div>

                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <form @submit.prevent="saveHarvestForm()">
                                <div class="form-group"
                                     v-bind:class="{ 'has-error': harvestErrorForm['transaction_date'] }">
                                    <label>วันที่เก็บเกี่ยว:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input @change="updateHarvestAmount()" v-model="harvestForm.transaction_date"
                                               type="date"
                                               class="form-control pull-right">
                                    </div>
                                    <span v-if="harvestErrorForm['transaction_date']"
                                          class="help-block">{{ harvestErrorForm['transaction_date'] }}</span>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>น้ำหนักเก็บเกี่ยวคาดการณ์จากระบบ (กิโลกรัม):</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calculator"></i>
                                        </div>
                                        <input v-model="harvestForm.amount" type="number" step="0.01"
                                               class="form-control pull-right">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">บันทึก</button>
                                    <button class="btn btn-default" type="button" @click="changeState(0)">ยกเลิก
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info" v-if="currentState == states[3]">
                <div class="panel-heading">
                    ยืนยันรายการเก็บเกี่ยว
                </div>

                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <form @submit.prevent="saveConfirmHarvestForm()">
                                <div class="form-group"
                                     v-bind:class="{ 'has-error': harvestErrorForm['transaction_date'] }">
                                    <label>วันที่เก็บเกี่ยว:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input disabled @change="updateHarvestAmount()"
                                               v-model="currentConfirmTransaction.transaction_date"
                                               type="date"
                                               class="form-control pull-right">
                                    </div>
                                    <span v-if="harvestErrorForm['transaction_date']"
                                          class="help-block">{{ harvestErrorForm['transaction_date'] }}</span>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>น้ำหนักเก็บเกี่ยว (กิโลกรัม):</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calculator"></i>
                                        </div>
                                        <input disabled v-model="currentConfirmTransaction.amount" type="number"
                                               step="0.01"
                                               class="form-control pull-right">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>บันทึกน้ำหนักเก็บเกี่ยวจริง(กิโลกรัม):</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calculator"></i>
                                        </div>
                                        <input v-model="currentConfirmTransaction.confirm_amount" type="number"
                                               step="0.01"
                                               class="form-control pull-right">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">บันทึก</button>
                                    <button class="btn btn-default" type="button" @click="changeState(0)">ยกเลิก
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    รายการการปลูก
                </div>

                <div class="panel-body">
                    <div class="table-responsive" v-if="pages">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>ประเภท</th>
                                <th>จำนวน</th>
                                <th>ประมาณคงเหลือ(กก.)</th>
                                <th>น้ำหนักเก็บเกี่ยวจริง (กก.)</th>

                                <th>สถานะ</th>
                                <th>การจัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="transaction in transactions">
                                <td>{{transaction.transaction_date | moment("DD MMM YYYY")}}</td>
                                <td>{{transaction.type}}</td>
                                <td v-bind:class="{ danger : transaction.type=='-', 'text-right' : transaction.type=='-'}">
                                    {{numeral(transaction.amount).format("0,0.00")}} {{ transaction.status.name == "N" ? 'ต้น' : 'กก.' }}


                                </td>
                                <td>

                                    {{numeral(transaction.balance).format("0,0.00")}}
                                    </td>
                                <td v-bind:class="{success : transaction.confirm_amount != null } "
                                >{{numeral(transaction.confirm_amount).format("0,0.00")}}
                                </td>
                                <td>{{transaction.status ? transaction.status.description : ''}}</td>
                                <td>
                                    <template
                                            v-if="transaction.status.name == 'H' && transaction.confirm_amount == null">
                                        <button type="button" class="btn btn-default"
                                                @click="changeState(3,transaction)">ยืนยัน
                                        </button>
                                    </template>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div>
                                        จำนวนทั้งหมด {{pages.total}} รายการ
                                    </div>
                                    <ul class="pagination">
                                        <li v-bind:class="{ 'active' : (pages.current_page == n) }"

                                            v-for="n in pages.last_page ">
                                            <a style="cursor: default;" v-on:click="gotoPage(n)">{{ n }}</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        props: {
            roleType: String,
            plantId: String,
        },
        data() {
            var plantPage;
            if (this.roleType == 'farmer') {
                plantPage = this.$routes.web[this.roleType].index;
            } else {
                plantPage = this.$routes.web[this.roleType].plant;
            }

            var plantTransactionApiUrl = this.$routes.api[this.roleType].plant + '/' + this.plantId + '/transaction';

            return {
                plantPage: plantPage,
                plantTransactionApiUrl: plantTransactionApiUrl,
                plantApiUrl: this.$routes.api[this.roleType].plant + "/" + this.plantId,
                states: ["none", "new", "harvest", "confirm_harvest"],
                currentState: "none",
                currentConfirmTransaction: null,

                plant: {},
                pages: {},
                transactions: [],

                initialForm: {
                    type: "+",
                    transaction_date: '',
                    status: "N",
                    amount: 100
                },
                harvestErrorForm: {},
                harvestForm: {
                    type: "-",
                    transaction_date: '',
                    status: "H",
                    amount: 0
                },
                form: {
                    keyword: "",
                    page: 1
                }
            }
        },
        methods: {
            strFormat: window.strFormat,
            resetForm: function (form) {
                if (form == this.initialForm) {
                    this.initialForm = {
                        type: "+",
                        transaction_date: '',
                        status: "N",
                        amount: 100,
                    }
                } else if (form == this.harvestForm) {
                    this.initializeHarvestForm();
                }
            },
            calculateNumberOfTrees: function () {
                return this.plant.area_sqm / (this.plant.plant_spacing * this.plant.row_spacing)
            },
            saveInitialForm: function () {
                axios.post(this.plantTransactionApiUrl + "/initialFarm", this.initialForm)
                    .then(response => {
                        console.log(response);
                        this.loadTransaction().then(r => {
                            this.currentState = this.states[0];
                            this.resetForm(this.initialForm);
                            this.$parent.$emit('ReloadHarvestStock');

                        });
                    })
            },
            initializeInitialForm: function () {
                this.initialForm.transaction_date = moment().format("YYYY-MM-DD")
                this.initialForm.amount = Math.floor(this.calculateNumberOfTrees());
            },
            updateHarvestAmount: function () {
                var now = moment();
                var transaction_date = moment(this.harvestForm.transaction_date, "YYYY-MM-DD").hours(now.hours())

                if (this.transactions.length > 0) {

                    //find last amount
                    var amount = 0;
                    for (var i = 0; i < this.transactions.length; i++) {
                        if (this.transactions[i].status.name == 'N') {
                            amount = this.transactions[i].amount;
                            break;
                        }
                    }
                    var lastBalance = this.transactions[this.transactions.length - 1].balance;
                    var lastTransaction = moment(this.transactions[this.transactions.length - 1].transaction_date)
                    var daydiff = lastTransaction.diff(transaction_date, 'days') * -1
                    var nextbalance = lastBalance + (0.0095 * daydiff * amount);
                    this.harvestForm.amount = nextbalance.toFixed(2)
                    console.log(nextbalance, daydiff, lastTransaction, transaction_date)
                } else {
                    this.harvestForm.amount = 0;
                }

            },

            saveHarvestForm: function () {
                this.harvestErrorForm = {}
                axios.post(this.plantTransactionApiUrl + "/harvestFarm", this.harvestForm)
                    .then(response => {
                            console.log(response);
                            this.loadTransaction().then(r => {
                                this.currentState = this.states[0];
                                this.resetForm(this.harvestForm);
                                this.$parent.$emit('ReloadHarvestStock');

                            });
                        }
                    )
                    .catch(error => {
                        console.log(error.response)
                        this.harvestErrorForm = error.response.data;
                        console.log(this.harvestErrorForm);
                    })
            },

            saveConfirmHarvestForm: function () {
                this.harvestErrorForm = {}
                axios.post(this.plantTransactionApiUrl + "/confirmHarvest", this.currentConfirmTransaction)
                    .then(response => {
                            console.log(response);
                            this.loadTransaction().then(r => {
                                this.currentState = this.states[0];
                                this.changeState(0);
                                this.resetForm(this.harvestForm);
                                this.$parent.$emit('ReloadHarvestStock');
                            });
                        }
                    )
                    .catch(error => {
                        console.log(error.response)
                        this.harvestErrorForm = error.response.data;
                        console.log(this.harvestErrorForm);
                    })
            },

            initializeHarvestForm: function () {
                this.harvestForm.transaction_date = moment().format("YYYY-MM-DD")
                var transaction_date = moment();

                if (this.transactions.length > 0) {

                    //find last amount
                    var amount = 0;
                    for (var i = 0; i < this.transactions.length; i++) {
                        if (this.transactions[i].status.name == 'N') {
                            amount = this.transactions[i].amount;
                            break;
                        }
                    }
                    var lastBalance = this.transactions[this.transactions.length - 1].balance;
                    var lastTransaction = moment(this.transactions[this.transactions.length - 1].transaction_date)
                    var daydiff = Math.abs(lastTransaction.diff(transaction_date, 'days'))
                    var nextbalance = lastBalance + (0.0095 * daydiff * amount);
                    this.harvestForm.amount = nextbalance.toFixed(2)
//                    console.log(nextbalance, daydiff, lastTransaction, transaction_date)
                } else {
                    this.harvestForm.amount = 0;
                }

            },


            changeState: function (stateId, item = null) {
                if (stateId == 0) {
                    this.currentConfirmTransaction = null;
                }
                if (stateId == 1) {
                    if (this.transactions.length > 0) {
                        return;
                    }
                }
                if (stateId == 2) {
                    if (this.transactions.length == 0) {
                        return;
                    }
                    this.initializeHarvestForm();
                }

                if (stateId == 3) {
                    if (!item) {
                        return;
                    } else {
                        this.currentConfirmTransaction = item;
                        this.currentConfirmTransaction.transaction_date = moment(this.currentConfirmTransaction.transaction_date).format("YYYY-MM-DD")
                    }
                }
                this.currentState = this.states[stateId];
            },
            loadPlant: function () {
                return axios.get(this.plantApiUrl)
                    .then(response => {
                        this.plant = response.data;
                    })
            },
            loadTransaction: function () {
                return axios.get(this.plantTransactionApiUrl, {
                    params: this.form
                }).then(response => {
                    this.pages = response.data
                    this.transactions = this.pages.data
                })
            },
            gotoPage: function (n) {
                this.form.page = n;
            },

        },
        created() {
        },
        mounted() {
            var self = this;
            axios.all([this.loadPlant(), this.loadTransaction()])
                .then(axios.spread(function (acct, perms) {
                    self.initializeInitialForm();
                    self.initializeHarvestForm();
                    console.log(self.transactions)
                }));

            console.log('Component mounted.')


        }
    }


</script>
