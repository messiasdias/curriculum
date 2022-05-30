<template>
<div class="d-flex">
        <div class="btn-group dropleft">
            <a @click.prevent href="#" class="waves-light waves-effect dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false"
            >
                {{filterSelected.name}}
            </a>
            <div class="left dropdown-menu">
                <a 
                    class="dropdown-item" 
                    href="#"
                    v-for="(filter, key) in filters"
                    :key="key"
                    :class="{'active text-primary': key == filterSelected.key}"
                     @click.prevent="selectFilter({...filter, key: key})" 
                >
                    {{filter.name}}
                </a>
            </div>
        </div>
    <Modal 
        v-if="isShowPeriodModal"
        :id="`periodModal`"
        :size="'modal-md'"
        :title="`${toEdit ? 'Editar' : 'Adicionar'} Contato`"
        @confirm="confirmPeriod($event)"
        @close="hidePeriodModal"
    >
        <template slot="body">
            <div class="row">
                <div class="row mb-3">
                    <label for="name" class="col-sm-4 col-form-label">Nome</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" placeholder="John Santos" id="name" v-model="form.name"> 
                         <ul v-if="help.name" class="parsley-errors-list filled" id="parsley-name" aria-hidden="false">
                            <li class="parsley-minlength">{{help.name}}</li>
                        </ul>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input required class="form-control" type="email" placeholder="john@exemplo.com" id="email" v-model="form.email"> 
                         <ul v-if="help.email" class="parsley-errors-list filled" id="parsley-email" aria-hidden="false">
                            <li class="parsley-minlength">{{help.email}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
        <template slot="footer">
             <button 
                type="button" 
                class="btn btn-light waves-effect"
                :disabled="validate"
                @click.prevent=""
            >Cancelar</button>
            <button 
                type="button"
                class="btn btn-primary waves-effect waves-light"
                :disabled="!formModified || !validate"
                @click.prevent=""
            >Salvar</button>
        </template>
    </Modal>
</div>
</template>
<script>
import moment from 'moment'
import Modal from './../Modal'
export default {
    name: 'FilterDate',
    props: {
        filter: Object,
    },
    components: {Modal},
    data(){
        return {
            filters: {
                'today': {
                    name: "Hoje",
                    period: {
                        start: moment().format("YYYY-MM-DD 00:00:00"),
                        end: moment().format("YYYY-MM-DD 23:59:59"),
                    }
                },
                'yesterday': {
                    name: 'Ontem',
                    period: {
                        start: moment().subtract(1, 'days').format("YYYY-MM-DD 00:00:00"),
                        end: moment().subtract(1, 'days').format("YYYY-MM-DD 23:59:59"),
                    }
                },
                'current-week': {
                    name: 'Semana Atual',
                    period: {
                        start: moment().subtract(7, 'days').format("YYYY-MM-DD 00:00:00"),
                        end: moment().format("YYYY-MM-DD 23:59:59"),
                    }
                },
                'last-week': {
                    name: 'Semana Anterior',
                    period: {
                        start: moment().subtract(14, 'days').format("YYYY-MM-DD 00:00:00"),
                        end: moment().subtract(7, 'days').format("YYYY-MM-DD 23:59:59"),
                    }
                },
                'current-month': {
                    name: 'Mês Atual',
                    period: {
                        start: moment().subtract(30, 'days').format("YYYY-MM-DD 00:00:00"),
                        end: moment().format("YYYY-MM-DD 23:59:59"),
                    }
                },
                'last-month': {
                    name: 'Mês Anterior',
                    period: {
                        start: moment().subtract(60, 'days').format("YYYY-MM-DD 00:00:00"),
                        end: moment().subtract(30, 'days').format("YYYY-MM-DD 23:59:59"),
                    }
                },
                'current-year': {
                    name: 'Ano Atual',
                    period: {
                        start: moment().subtract(365, 'days').format("YYYY-MM-DD 00:00:00"),
                        end: moment().format("YYYY-MM-DD 23:59:59"),
                    }
                },
                'last-year': {
                    name: 'Ano Anterior',
                    period: {
                        start: moment().subtract(730, 'days').format("YYYY-MM-DD 00:00:00"),
                        end: moment().subtract(365, 'days').format("YYYY-MM-DD 23:59:59"),
                    }
                },
                'all-period': {
                    name: 'Todo o Período',
                    period: {
                        start: moment().format("2000-01-01 00:00:00"),
                        end: moment().format("YYYY-MM-DD 23:59:59"),
                    }
                }
            } ,
            filterSelected: {
                key: 'today',
                name: "Hoje",
                period: {
                    start: moment().format("YYYY-MM-DD 00:00:00"),
                    end: moment().format("YYYY-MM-DD 23:59:59"),
                }
            },
            isShowPeriodModal: false
        }
    },
    methods: {
        selectFilter(filter){
            this.filterSelected = filter
            this.$emit("change", {...filter})
        },
        showPeriodModal(){
            this.isShowAddEndEditModal = true
            setTimeout( () => {$(`#periodModal`).modal('show')})
        },
        hidePeriodModal(){
           setTimeout( () => {$(`#periodModal`).modal('hide')})
           this.isShowAddEndEditModal = false
        },
        confirmPeriod(period){
            console.log(period)
        }
    },
    beforeMount(){
        if (!!this.filter) this.filterSelected = this.filter
        else this.filterSelected = {...this.filters['current-week'], key: 'current-week'}
    }
}
</script>