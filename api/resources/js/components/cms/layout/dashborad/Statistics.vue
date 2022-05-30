<template>
<div v-if="statistics" class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-1 overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Páginas Visitadas</p>
                        <h4 class="mb-0">{{statistics.pages_total || 0}}</h4>
                    </div>
                    <div class="text-primary ms-auto">
                        <i class="ri-newspaper-fill font-size-24"></i>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body border-top py-3">
                <div class="text-truncate">
                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i>
                        2.4% </span>
                    <span class="text-muted ms-2">From previous period</span>
                </div>
            </div> -->
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-1 overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Total de Visualizções</p>
                        <h4 class="mb-0">{{statistics.views_total || 0}}</h4>
                    </div>
                    <div class="text-primary ms-auto">
                        <i class="ri-computer-fill font-size-24"></i>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body border-top py-3">
                <div class="text-truncate">
                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i>
                        2.4% </span>
                    <span class="text-muted ms-2">From previous period</span>
                </div>
            </div> -->
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-1 overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Visitantes Únicos</p>
                        <h4 class="mb-0">{{statistics.unique_visitor_total || 0}}</h4>
                    </div>
                    <div class="text-primary ms-auto">
                        <i class="ri-team-line font-size-24"></i>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body border-top py-3">
                <div class="text-truncate">
                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i>
                        2.4% </span>
                    <span class="text-muted ms-2">From previous period</span>
                </div>
            </div> -->
        </div>
    </div>

      <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-1 overflow-hidden">
                        <p class="text-truncate font-size-14 mb-2">Contatos Recebidos</p>
                        <h4 class="mb-0">{{statistics.contacts_total || 0}}</h4>
                    </div>
                    <div class="text-primary ms-auto">
                        <i class="ri-mail-send-line font-size-24"></i>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body border-top py-3">
                <div class="text-truncate">
                    <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i>
                        2.4% </span>
                    <span class="text-muted ms-2">From previous period</span>
                </div>
            </div> -->
        </div>
    </div>

     <Charts 
        v-if="statistics"
        :devices="statistics.devices_total" 
        :vendors="statistics.vendors_total" 
        :platforms="statistics.platforms_total" 
    />
</div>
</template>
<script>
import Charts from './Charts'
export default {
    name: "Statistics",
    components: {
        Charts
    },
    props: {
        statistics: {
            type: Object,
            default: () => {
                return {
                    pages_total: 0,
                    unique_visitor_total: 0,
                    views_total: 0,
                    contacts_total: 0,
                    devices_total: null,
                    vendors_total: null,
                    platforms_total: null
                }
            }
        } 
    }
}
</script>