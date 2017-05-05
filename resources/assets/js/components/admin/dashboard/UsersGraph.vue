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

    export default {
        components: {
            VueHighcharts
        },
        data(){
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
                    xAxis: {
                        categories: ['a', 'b', 'c', 'd'],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Rainfall (mm)'
                        }
                    },
                    tooltip: {},
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [
                        {
                            data: [1, 2, 3, 4]
                        }]
                }
            }
        },
        methods: {
            loadData: function () {
                let columnCharts = this.$refs.columnCharts;
                let charts = columnCharts.chart
                console.log(charts);
                columnCharts.delegateMethod('showLoading', 'Loading...');
                this.$http.get('/api/admin/dashboard/sum_users_by_type')
                    .then(
                        function (response) {
                            this.apiData = response.data;
                            charts.xAxis[0].setCategories(['1', '2', '3', '4'], true)
                            charts.series = [
                                {
                                    data: [5, 6, 7, 8]
                                }
                            ]
                            charts.redraw();
                            columnCharts.hideLoading();
                        },
                        function (response) {
                        }
                    )
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