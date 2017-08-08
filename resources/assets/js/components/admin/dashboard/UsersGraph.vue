<template>
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">จำนวนผู้ใช้ระบบตามประเภท</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <vue-highcharts :options="options" ref="columnCharts"></vue-highcharts>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</template>

<script type="text/javascript">

    import VueHighcharts from 'vue2-highcharts'
    import Highcharts from 'Highcharts'

    export default {
        components: {
            VueHighcharts
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
                    yAxis: {
                        min: 0,
                        title: {
                            text: ''
                        }
                    },
                    tooltip: {},
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
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

                axios.get('/api/admin/dashboard/sum_users_by_type')
                    .then(
                        response => {

                            this.apiData = response.data;
                            console.log(this.apiData);
                            charts.xAxis[0].setCategories(this.apiData.labels, true);
                            columnCharts.addSeries(this.apiData.series);
                            columnCharts.hideLoading();
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