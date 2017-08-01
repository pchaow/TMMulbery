<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-info">
                <div class="panel-heading">
                    แผนงาน
                </div>

                <div class="panel-body">

                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</template>


<style>

    .cdb-transaction {
        background-color: green;
    }

</style>

<script>

    import fullCalendar from 'fullcalendar'

    export default {
        props: {
            roleType: String,
        },
        components: {},
        data() {
            return {
                fcEvents: []

            }
        },
        methods: {
            initialCalendar: function () {
                var self = this;

                $('#calendar').fullCalendar({
                    height: 650,
                    events: function (start, end, timezone, callback) {
                        axios.post(self.$routes.api.buyer.event, {
                            start: start.unix(),
                            end: end.unix()
                        })
                            .then(response => {
                                self.fcEvents = response.data;

                                for (var i = 0; i < self.fcEvents.length; i++) {
                                    if (self.fcEvents[i].type == "order") {

                                    } else {
                                        self.fcEvents[i].backgroundColor = "green"
                                    }
                                    self.fcEvents[i].allDay = true;
                                }

                                callback(self.fcEvents);
                            })
                    }
                })

            },
            loadCalendar: function () {
                axios.post(this.$routes.api.buyer.event)
                    .then(res => {
                        this.fcEvents = res.data;

                        for (var i = 0; i < this.fcEvents.length; i++) {
                            if (this.fcEvents[i].type == "order") {

                            } else {
                                this.fcEvents[i].backgroundColor = "green"
                            }
                            this.fcEvents[i].allDay = true;

                        }

                        this.initialCalendar();
                    })
            }
        },
        created() {
        },
        mounted() {
//            this.loadCalendar();
            this.initialCalendar();
        }
    }
</script>