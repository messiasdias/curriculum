<template>
 <div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Dispositivos Utilizados</h4>
                <div id="devices_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
        <!--end card-->
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Sistemas Operacionais Utilizados</h4>
                <div id="platforms_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
        <!--end card-->
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Browsers Utilizados</h4>
                <div id="vendors_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
        <!--end card-->
    </div>
</div>
</template>
<script>
export default {
    name: 'Charts',
    props: {
        vendors: {
            typeo: Object,
            default: () => {
                return {
                    "Teste 1": 76,
                    "Teste 2": 89,
                    "Teste 3": 50,
                }
            }
        },
        platforms: {
            typeo: Object,
            default: () => {
                return {
                    "Teste 1": 10,
                    "Teste 2": 75,
                    "Teste 3": 50,
                }
            }
        },
        devices: {
            typeo: Object,
            default: () => {
                return {
                    "Teste 1": 50,
                    "Teste 2": 78,
                    "Teste 3": 99,
                }
            }
        },
    },
    data(){
        return {
            deviceNames: {
                'mobile': "SmartPhone",
                'tablet': "Tablet",
                'desktop': "Computador",
            },
            devicesChart: null,
            platformsChart: null,
            vendorsChart: null,
        }
    },
    watch: {
        devices(){
            this.initDevices()
        },
        vendors(){
            this.initVendors()
        },
        platforms(){
            this.initPlatforms()
        }
    },
    methods: {
        initDevices(){
            if (this.devicesChart) this.devicesChart.destroy()

            setTimeout(() => {
                var options = {
                    chart: {
                        height: 300,
                        type: 'donut',
                    },
                    series: Object.values(this.devices),
                    labels: Object.keys(this.devices).map((device) => this.deviceNames[device]),
                    colors: ["#1cbb8c", "#5664d2", "#fcb92c", "#4aa3ff", "#ff3d60"],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        verticalAlign: 'middle',
                        floating: false,
                        fontSize: '14px',
                        offsetX: 0,
                        offsetY: 5
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            chart: {
                                height: 240
                            },
                            legend: {
                                show: false
                            },
                        }
                    }]

                }

                this.devicesChart = new ApexCharts(
                    window.document.querySelector("#devices_chart"),
                    options
                )

                this.devicesChart.render()
            }, 10)
        },
        initVendors(){
            if (this.vendorsChart) this.vendorsChart.destroy()
            
            setTimeout(() => {
                let options = {
                    chart: {
                        height: 300,
                        type: 'bar',
                        toolbar: {
                            show: false,
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    series: [{
                        labels: Object.keys(this.vendors),
                        data: Object.values(this.vendors)
                    }],
                    colors: ['#5664d2', '#fcb92c', '#1cbb8c', '#ff3d60', '#ff3d60'],
                    grid: {
                        borderColor: '#f1f1f1',
                        padding: {
                            bottom: 5
                        }
                    },
                    xaxis: {
                        categories: Object.keys(this.vendors),
                    },
                    legend: {
                        offsetY: 5
                    }
                }

                this.vendorsChart = new ApexCharts(
                    window.document.querySelector("#vendors_chart"),
                    options
                );

                this.vendorsChart.render();
            }, 10)

        },
        initPlatforms(){
            if (this.platformsChart) this.platformsChart.destroy()
            
            setTimeout(() => {
                let options = {
                    chart: {
                        height: 300,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            dataLabels: {
                                name: {
                                    fontSize: '22px',
                                },
                                value: {
                                    fontSize: '16px',
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter:  (w) => {
                                        return (Object.values(this.platforms)).reduce((a,b) => a + b)
                                    }
                                }
                            }
                        }
                    },
                    series: Object.values(this.platforms),
                    labels: Object.keys(this.platforms),
                    colors: ['#5664d2', '#fcb92c', '#1cbb8c', '#ff3d60', '#ff3d60'],
                    legend: {
                        offsetY: 5
                    }

                }

                this.platformsChart = new ApexCharts(
                    window.document.querySelector("#platforms_chart"),
                    options
                )

                this.platformsChart.render()
            }, 10)
        },
        init(){
            this.initDevices()
            this.initVendors()
            this.initPlatforms()
        }
    },
    mounted(){
        this.init()
    }
}
</script>