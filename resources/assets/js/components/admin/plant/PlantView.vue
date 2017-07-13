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
                                    <label>Date:</label>

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
                                    <button class="btn btn-primary" type="submit">save</button>
                                    <button class="btn btn-default" @click="changeState(0)">ยกเลิก</button>
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
                            เก็บเกี่ยว
                        </div>
                        <div class="col-lg-12">
                            <form @submit.prevent="saveHarvestForm()">
                                <div class="form-group">
                                    <label>Date:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input @change="updateHarvestAmount()" v-model="harvestForm.transaction_date"
                                               type="date"
                                               class="form-control pull-right">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>น้ำหนัก (เก็บเกี่ยว):</label>

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
                                    <button class="btn btn-primary" type="submit">save</button>
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
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Balance (กิโลกรัม)</th>
                                <th>Status</th>
                                <th>การจัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="transaction in transactions">
                                <td>{{transaction.transaction_date | moment("YYYY-MM-DD")}}</td>
                                <td>{{transaction.type}}</td>
                                <td v-bind:class="{ danger : transaction.type=='-', 'text-right' : transaction.type=='-'}">
                                    {{transaction.amount}} {{ transaction.status.name == "N" ? 'ต้น' : 'กก.' }}
                                </td>
                                <td>{{transaction.balance}}</td>
                                <td>{{transaction.status ? transaction.status.name : ''}}</td>
                                <td>
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
            plantTransactionApiUrl: String,
            plantApiUrl: String,
            plantPage: String,
        },
        data() {
            return {
                states: ["none", "new", "harvest"],
                currentState: "none",

                plant: {},
                pages: {},
                transactions: [],

                initialForm: {
                    type: "+",
                    transaction_date: '',
                    status: "N",
                    amount: 100
                },

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
                    this.initializeHarvestForm;
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
                        });
                    })
            },
            initializeInitialForm: function () {
                this.initialForm.transaction_date = moment().format("YYYY-MM-DD")
                this.initialForm.amount = Math.floor(this.calculateNumberOfTrees());
            },
            updateHarvestAmount: function () {
                var transaction_date = moment(this.harvestForm.transaction_date, "YYYY-MM-DD")
                var lastBalance = 0
                if (this.transactions.length > 0) {
                    var lastBalance = this.transactions[0].balance;
                    var lastTransaction = moment(this.transactions[0].transaction_date)
                    var daydiff = Math.abs(lastTransaction.diff(transaction_date, 'days'))
                    console.log(daydiff);
                    this.harvestForm.amount = lastBalance + (0.008 * daydiff) * this.transactions[0].amount;
                } else {
                    this.harvestForm.amount = 0;
                }

            },

            saveHarvestForm: function () {
                axios.post(this.plantTransactionApiUrl + "/harvestFarm", this.harvestForm)
                    .then(response => {
                        console.log(response);
                        this.loadTransaction().then(r => {
                            this.currentState = this.states[0];
                            this.resetForm(this.harvestForm);
                        });
                    })
            },
            initializeHarvestForm: function () {
                this.harvestForm.transaction_date = moment().format("YYYY-MM-DD")
                var transaction_date = moment(this.harvestForm.transaction_date, "YYYY-MM-DD")

                if (this.transactions.length > 0) {

                    //find last amount
                    var amount = 0;
                    for (var i = 0; i < this.transactions.length; i++) {
                        if (this.transactions[i].status.name == 'N') {
                            amount = this.transactions[i].amount;
                            break;
                        }
                    }
                    var lastBalance = this.transactions[this.transactions.length-1].balance;
                    var lastTransaction = moment(this.transactions[this.transactions.length-1].transaction_date)
                    var daydiff = lastTransaction.diff(transaction_date, 'days')
                    var nextbalance = lastBalance + (0.008 * Math.abs(daydiff) * amount);
                    this.harvestForm.amount = nextbalance.toFixed(2)
                    console.log(lastBalance)
                } else {
                    this.harvestForm.amount = 0;
                }

            },


            changeState: function (stateId) {
                if (stateId == 1) {
                    if (this.transactions.length > 0) {
                        return;
                    }
                }
                if (stateId == 2) {
                    if (this.transactions.length == 0) {
                        return;
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
        created(){
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
