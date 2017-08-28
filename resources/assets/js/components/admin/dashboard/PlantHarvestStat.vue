<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">สถิติการเก็บเกี่ยว</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <vue-highcharts :options="options" ref="columnCharts"></vue-highcharts>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
</template>

<script type="text/javascript">

    import VueHighcharts from 'vue2-highcharts'
    import Highcharts from 'Highcharts'

    export default {
        components: {
            VueHighcharts
        },
        props: {
            plantId: Number,
        },
        data() {
            return {
                apiData: null,
                options: {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '',
                        style: {
                            display: 'none'
                        }
                    },
                    subtitle: {
                        text: '',
                        style: {
                            display: 'none'
                        }
                    },
                    xAxis: {},
                    yAxis: [{
                        min: 0,
                        title: {
                            text: 'น้ำหนักเก็บเกี่ยว (กก.)'
                        }
                    }, {
                        title: {
                            text: 'ค่าความต่างระหว่าง ค่าจริงและค่าประมาณ (กก.)'
                        },
                        opposite: true,
                        tickPositioner: function () {

                            var maxDeviation = Math.ceil(Math.max(Math.abs(this.dataMax), Math.abs(this.dataMin)));
                            var halfMaxDeviation = maxDeviation/2

                            return [-maxDeviation, -halfMaxDeviation, 0, halfMaxDeviation, maxDeviation];
                        },
                    }],
                    tooltip: {},
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true

                        },
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true

                        },
                    },
                    series: [],
                }
            }
        },
        methods: {
            loadData: function () {
                let columnCharts = this.$refs.columnCharts;

                let charts = columnCharts.chart

                console.log(columnCharts);

                columnCharts.delegateMethod('showLoading', 'Loading...');

                axios.get('/api/public/plant/' + this.plantId + "/harvest_stats")
                    .then(
                        response => {

                            this.apiData = response.data;
                            console.log(this.apiData);
                            charts.xAxis[0].setCategories(this.apiData.categories, true);
                            columnCharts.addSeries(this.apiData.series[0]);
                            columnCharts.addSeries(this.apiData.series[1]);

                            this.apiData.series[2].yAxis = 1;
                            this.apiData.series[2].type = 'spline';

                            columnCharts.addSeries(this.apiData.series[2]);
                            columnCharts.hideLoading();
                            console.log(columnCharts);
                        })
            }
        },
        created() {
        },
        mounted() {
            console.log('Component ready.')
            this.loadData();

        }
    }
</script>