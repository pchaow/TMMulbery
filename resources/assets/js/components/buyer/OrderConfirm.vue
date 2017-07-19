<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    รายการขายจากเกษตรกร
                </div>

                <div class="panel-body" v-if="buyConfirmOrder">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                คำสั่งซื้อ
                            </div>

                            <div class="panel-body">
                                <div class="col-md-12">
                                    <p>
                                        <label>ชื่อ</label> {{buyOrder.user.name}}
                                    </p>
                                    <p>
                                        <label>เบอร์โทรศัพท์</label> {{buyOrder.user.contact_number}}
                                    </p>
                                    <p>
                                        <label>แปลง</label> {{buyOrder.plant.name}}
                                    </p>
                                    <p>
                                        <label>จำนวน</label> {{buyOrder.amount}}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                คำสั่งขาย
                            </div>

                            <div class="panel-body">
                                <div class="col-md-12">
                                    <p>
                                        <label>ชื่อ</label> {{sellOrder.user.name}}
                                    </p>
                                    <p>
                                        <label>เบอร์โทรศัพท์</label> {{sellOrder.user.contact_number}}
                                    </p>
                                    <p>
                                        <label>แปลง</label> {{sellOrder.plant.name}}
                                    </p>
                                    <p>
                                        <label>จำนวน</label> {{sellOrder.amount}}
                                    </p>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                ยืนยืนรายการซื้อขาย
                            </div>

                            <div class="panel-body">
                                <div class="col-md-12">
                                    <form class="form-horizontal" v-on:submit.prevent="save">
                                        <div class="form-group"
                                             v-bind:class="{ 'has-error': formErrors['remark.unitprice'] }">
                                            <label class="control-label">ราคาต่อหน่วย : </label>
                                            <input type="number" class="form-control" placeholder="ราคาต่อหน่วย"
                                                   v-model="formInputs.remark.unitprice"/>
                                            <span v-if="formErrors['remark.unitprice']"
                                                  class="help-block">{{ formErrors['remark.unitprice'] }}</span>
                                        </div>

                                        <div class="form-group"
                                             v-bind:class="{ 'has-error': formErrors['remark.unit'] }">
                                            <label class="control-label">จำนวน (กก.) : </label>
                                            <input type="number" class="form-control" placeholder="จำนวน (กก.)"
                                                   v-model="formInputs.remark.unit"/>
                                            <span v-if="formErrors['remark.unit']"
                                                  class="help-block">{{ formErrors['remark.unit'] }}</span>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">รวม (บาท) : </label>
                                            {{numeral(calculateSumUnit()).format('0,0.00')}}
                                        </div>


                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a v-bind:href="successUrl" class="btn btn-default">Cancel</a>
                                        </div>
                                    </form>
                                </div>

                            </div>
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
            orderId: String,
            orderApi: String,
        },
        components: {},
        data() {
            return {
                buyConfirmOrder: null,
                sellOrder: {},
                buyOrder: {},
                formInputs: {
                    remark: {
                        unitprice: 0,
                        unit: 0
                    }
                },
                formErrors: {
                    remark: {}
                }
            }
        },
        methods: {

            calculateSumUnit(){
                if (this.formInputs.remark.unitprice != null && this.formInputs.remark.unit != null) {
                    return this.formInputs.remark.unitprice * this.formInputs.remark.unit
                }
                return 0;
            },
            loadBuyOrder: function () {
                axios.get(this.orderApi + "/" + this.orderId)
                    .then(res => {
                        var data = res.data;
                        this.buyConfirmOrder = data.buy_confirm_orders[0];
                        this.buyOrder = this.buyConfirmOrder.buy_order;
                        this.sellOrder = this.buyConfirmOrder.sell_order;

                        console.log(this.buyConfirmOrder)
                    })
                    .catch(err => {
                    })
            },
            save: function () {
                axios.post(this.orderApi + "/" + this.orderId + "/confirm", this.formInputs)
                    .then(res => {

                    })
                    .catch(err => {

                    })
            }

        },
        created() {
            this.loadBuyOrder();
        },
        mounted() {
        }
    }
</script>