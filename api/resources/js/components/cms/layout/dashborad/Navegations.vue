<template>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Páginas Visitadas</h4>

            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-centered datatable dt-responsive nowrap dataTable no-footer dtr-inline collapsed" 
                            data-bs-page-length="5" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" 
                            id="DataTables_Table_0" role="grid"
                         >
                                <thead class="table-light">
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 40%;" aria-sort="ascending">Nome</th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 40%;" >URL</th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 20%;" >Views</th>
                                            <!-- <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 20%;" >Mais Detalhes</th> -->
                                        </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="navegation in navegations" :key="navegation.id" class="odd">
                                        <td>{{navegation.page.name}}</td>
                                        <td>
                                            <a 
                                                :href="getURL(navegation)" 
                                                target="_blank" 
                                                class="text-dark fw-bold"
                                            >
                                                {{ getURL(navegation) }}
                                            </a> 
                                        </td>
                                        <td style="">
                                            <div class="badge badge-soft-info font-size-16">{{navegation.views}}</div>
                                        </td>
                                        <!-- <td>
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">Dispositivos</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">IP / Locais </a>
                                                </div>
                                            </div>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    name: 'Navegations',
    props: {
        navegations: {
            type: Array,
            default: () => []
        } 
    },
    methods: {
        getURL(navegation){
            let url = !navegation.page.is_default_page ? `/pagina/${navegation.page.slug}` : `/${navegation.page.slug}`
            if (navegation.page.slug === 'interna-cases') url = `/cases/${navegation.items_id}`
            return url
        }
    }
}
</script>