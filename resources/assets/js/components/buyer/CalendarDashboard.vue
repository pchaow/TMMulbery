<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    แผนงาน
                </div>

                <div class="panel-body">
                    <full-calendar :events="fcEvents" locale="en"></full-calendar>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import fullCalendar from 'vue-fullcalendar'

    export default {
        props: {
            roleType: String,
        },
        components: {
            fullCalendar
        },
        data() {
            return {
                fcEvents: []

            }
        },
        methods: {
            loadCalendar: function () {
                axios.post(this.$routes.api.buyer.event)
                    .then(res => {
                        this.fcEvents = res.data;
                    })
            }
        },
        created() {
        },
        mounted() {
            this.loadCalendar();
        }
    }
</script>