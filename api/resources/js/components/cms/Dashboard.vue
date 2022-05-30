<template>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>

                    <div class="page-title-right ml-2 mr-2">
                        <ol class="breadcrumb col-12">
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item">Período</li>
                            <li class="breadcrumb-item">
                                <FilterDate :filter="filter" @change="changeFilter($event)" />
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <Statistics :statistics="statistics" />

        <Navegations :navegations="navegations" /> 
        
        <Timeline :timeline="timeline" />

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
</template>
<script>
import Axios from 'axios'
import moment from 'moment'
import FilterDate from './layout/dashborad/FilterDate'
import Statistics from './layout/dashborad/Statistics'
import Navegations from './layout/dashborad/Navegations'
import Timeline from './layout/dashborad/Timeline'

export default {
    name: 'dashboard',
    components: {
       FilterDate,
       Statistics,
       Navegations,
       Timeline,
    },
    data(){
        return {
            user: this.$store.getters.user,
            filter: null,
            statistics: null,
            navegations: [],
            timeline: []
        }
    },
    methods: {
        resetFilter(){
            localStorage.removeItem('filterSelected')
            this.filter = {
                key: 'current-week',
                name: 'Semana Atual',
                period: {
                    start: moment().subtract(7, 'days').format("YYYY-MM-DD 00:00:00"),
                    end: moment().format("YYYY-MM-DD 23:59:59"),
                }
            }
        },
        changeFilter(filter = null) {
            if (!!filter) this.filter = filter
            else this.resetFilter()
            this.getNavegations()
            this.getTimeline()
            localStorage.filterSelected = JSON.stringify(this.filter)
        },
        getNavegations(){
            Axios.post(`${window.cmsApiBaseUrl}/dashboard/navegations`, {filter: this.filter})
            .then(({data}) => {
                this.statistics = data.statistics
                this.navegations = data.navegations
            })
            .catch(() => {
                this.statistics = null
                this.navegations = []
            })
        },
        getTimeline(){
            Axios.post(`${window.cmsApiBaseUrl}/dashboard/timeline`, {filter: this.filter})
            .then(({data}) => this.timeline = data.timeline)
            .catch(() => this.timeline = [])
        }
    },
    beforeMount(){
        if(!!localStorage.filterSelected) this.filter = JSON.parse(localStorage.filterSelected)
        if (!!this.user) this.changeFilter(this.filter)
    }
}
</script>