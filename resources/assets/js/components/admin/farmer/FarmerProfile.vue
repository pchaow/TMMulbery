<template>
    <div class="row" v-if="formInputs">
        <div class="col-md-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    แก้ไขข้อมูลเกษตรกร
                </div>

                <div class="panel-body">

                    <div class="col-lg-12" v-if="formInputs">
                        <form class="form-horizontal" v-on:submit.prevent="save">

                            <fieldset>

                                <div class="form-group">
                                    <h4>ข้อมูลส่วนตัว</h4>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['identity'] }">
                                    <label class="control-label">เลขประจำตัวประชาชน : </label>
                                    <input readonly class="form-control" placeholder="หมายเลขประจำตัวประชาชน 13 หลัก"
                                           v-model="formInputs.identity"/>
                                    <span v-if="formErrors['identity']"
                                          class="help-block">{{ formErrors['identity'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['name'] }">
                                    <label class="control-label">ชื่อ-นามสกุล : </label>
                                    <input readonly class="form-control" placeholder="Name" v-model="formInputs.name"/>
                                    <span v-if="formErrors['name']"
                                          class="help-block">{{ formErrors['name'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['contact_number'] }">
                                    <label class="control-label">เบอร์โทรศัพท์ : </label>
                                    <input readonly class="form-control" placeholder="เบอร์โทรศัพท์"
                                           v-model="formInputs.contact_number"/>
                                    <span v-if="formErrors['contact_number']" class="help-block">{{ formErrors['contact_number'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['address'] }">
                                    <label class="control-label">ที่อยู่ : </label>
                                    <input readonly class="form-control" placeholder="ที่อยู่"
                                           v-model="formInputs.address"/>
                                    <span v-if="formErrors['address']"
                                          class="help-block">{{ formErrors['address'] }}</span>
                                </div>

                                <province v-bind:province="formInputs.province_id"
                                          v-on:province_update="formInputs.province_id = arguments[0]"
                                          v-bind:amphure="formInputs.amphure_id"
                                          v-on:amphure_update="formInputs.amphure_id = arguments[0]"
                                          v-bind:district="formInputs.district_id"
                                          v-on:district_update="formInputs.district_id = arguments[0]"
                                          v-bind:formErrors="formErrors"
                                          :disabled="true"
                                ></province>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['postal_code'] }">
                                    <label class="control-label">รหัสไปรษณีย์ : </label>
                                    <input readonly class="form-control" placeholder="รหัสไปรษณีย์"
                                           v-model="formInputs.postal_code"/>
                                    <span v-if="formErrors['postal_code']" class="help-block">{{ formErrors['postal_code'] }}</span>
                                </div>
                            </fieldset>

                            <fieldset>

                                <div class="form-group">
                                    <h4>ข้อมูลการเข้าใช้งานระบบ</h4>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['email'] }">
                                    <label class="control-label">E-mail : </label>
                                    <input readonly class="form-control" placeholder="E-mail"
                                           v-model="formInputs.email"/>
                                    <span v-if="formErrors['email']" class="help-block">{{ formErrors['email'] }}</span>
                                </div>

                                <div class="form-group" v-bind:class="{ 'has-error': formErrors['username'] }">
                                    <label class="control-label">ชื่อบัญชีผู้ใช้ : </label>
                                    <input readonly type="text" class="form-control" placeholder="Username"
                                           v-model="formInputs.username"/>
                                    <span v-if="formErrors['username']"
                                          class="help-block">{{ formErrors['username'] }}</span>
                                </div>


                            </fieldset>


                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Province from '../../shared/Province.vue'

    export default {
        props: {
            userId: Number,
            roleType: String,
        },
        components: {
            Province
        },
        data() {
            console.log(this.roleType);
            var saveUrl = '';
            var loadUrl = '';
            var successUrl = '';
            var loadUrl = this.$routes.api[this.roleType].farmer + "/" + this.userId + "/edit";
            var successUrl = this.$routes.web[this.roleType].farmer.index;

            return {
                loadUrl: loadUrl,
                successUrl: successUrl,
                roles: [],
                formInputs: null,
                formErrors: [],
            }
        },
        methods: {
            load: function () {

                axios.get(this.loadUrl)
                    .then((response) => {
                        // success callback
                        this.formInputs = response.data;
                    }, (response) => {
                        // error callback
                        this.formErrors = response.data;
                    })
            },
        },
        created() {
        },
        mounted() {
            console.log('ready to edit user.id =', this.userId)
            this.load()
        }
    }
</script>
