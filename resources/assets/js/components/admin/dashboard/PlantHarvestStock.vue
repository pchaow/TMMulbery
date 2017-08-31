<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">สถิติการเก็บเกี่ยว</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="chart" ref="chart"></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
</template>

<script type="text/javascript">

    import VueHighcharts from 'vue2-highcharts'
    import Highcharts from 'Highcharts/highstock'


    export default {
        components: {
            VueHighcharts, Highcharts
        },
        props: {
            plantId: Number,
        },
        data() {
            return {
                chart: {},
                seriesOptions: [],
            }
        },
        methods: {
            loadData: function () {
                var self = this
                $.getJSON('/api/public/plant/' + this.plantId + '/harvest_stats', function (data) {
                    console.log(data)
                    $(self.$refs.chart).highcharts('StockChart', {
                        rangeSelector: {
                            buttons: [{
                                count: 3,
                                type: 'month',
                                text: '3M'
                            }, {
                                count: 6,
                                type: 'month',
                                text: '6M'
                            }, {
                                count: 1,
                                type: 'year',
                                text: '1Y'
                            }, {
                                type: 'all',
                                text: 'All'
                            }],
                            inputEnabled: false,
                            selected: 2
                        },
                        xAxis: {
                            plotLines: [{
                                label: {
                                    text: "Today",
                                },
                                color: '#FF0000', // Red
                                width: 2,
                                value: moment()// Position, you'll have to translate this to the values on your x axis
                            }]
                        },
                        yAxis: [
                            {
                                min: 0,
                                title: {
                                    text: 'น้ำหนักเก็บเกี่ยว (กก.)'
                                },
                            }, {
                                title: {
                                    text: 'ค่าความต่างระหว่าง ค่าจริงและค่าประมาณ (กก.)'
                                },
                                opposite: true,
                                tickPositioner: function () {

                                    var maxDeviation = Math.ceil(Math.max(Math.abs(this.dataMax), Math.abs(this.dataMin)));
                                    maxDeviation = maxDeviation
                                    var halfMaxDeviation = maxDeviation / 2

                                    return [-maxDeviation, -halfMaxDeviation, 0, halfMaxDeviation, maxDeviation];
                                },
                            }],

                        series: [{
                            type: 'column',
                            name: 'ปริมาณเก็บเกี่ยวจริง',
                            data: data[0],
                            tooltip: {
                                valueDecimals: 2
                            }
                        }, {
                            type: 'column',
                            name: 'ค่าประมาณจากระบบ',
                            data: data[1],
                            tooltip: {
                                valueDecimals: 2
                            }
                        }, {
                            type: 'spline',
                            dashStyle: 'shortdot',
                            name: 'ค่าประมาณใบหม่อนที่เหลือในแปลง',
                            data: data[3],
                            tooltip: {
                                valueDecimals: 2
                            }
                        }, {
                            type: 'spline',
                            name: 'ผลต่างระหว่างค่าประมาณและค่าจริง',
                            data: data[2],
                            yAxis: 1,
                            tooltip: {
                                valueDecimals: 2
                            }
                        }]
                    });
                });
            }
        },
        created() {
            this.chart = $(this.$refs.chart);
            var self = this
            this.$parent.$on('ReloadHarvestStock', function (id) {
                self.loadData();
            })

        },
        mounted() {
            console.log('Component ready.')
            this.loadData();
        }
    }
</script>