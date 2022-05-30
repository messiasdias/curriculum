<template>
    <Modal 
        :id="modalId"
        :title="modalTitle"
        :text="`Deseja enviar uma mensagem de confirmação para <b>${user.name} - ${user.email}</b>?`"
        :closeText="'Não'"
        :confirmText="'Sim'"
        @confirm="$emit('confirm', permissions)"
        @close="$emit('close')"
    >
        <template slot="body">
            
            <div class="row mb-3">
                <div v-for="(text, key) in list" :key="key" class="col-6">
                    <div class="col-sm-4 form-switch-conten d-flex justify-content-start mt-2">
                        <div class="form-check form-switc" dir="ltr">
                            <input type="checkbox" class="form-check-input" :id="key"  v-model="permissions[key]" >
                            <label class="form-check-label" :for="key">{{text}}</label>
                        </div>
                    </div>
                </div>
            </div>

        </template>
        <template slot="footer">
            <button 
                type="button" 
                class="btn btn-light waves-effect"
                data-bs-dismiss="modal"
                @click.prevent="$emit('close')"
            >Cancelar</button>
            <button 
                type="button"
                class="btn btn-primary waves-effect waves-light"
                :disabled="disableSaveBtn"
                @click.prevent="$emit('confirm', permissions)"
            >Salvar</button>
        </template>
    </Modal>
</template>
<script>
import Axios from 'axios'
import Modal from './../Modal'
export default {
    name: 'Permissions',
    components: {Modal},
    props: {
        user: Object,
        modalId: String,
        modalTitle: String,
    },
    data(){
        return {
            list: [],
            permissions: null,
            permissions_original: null
        }
    },
    computed: {
        disableSaveBtn(){
            return JSON.stringify(this.permissions) === JSON.stringify(this.permissions_original)
        }
    },
    methods: {
        getList(){
            Axios.get(`${window.cmsApiBaseUrl}/users/permissions`)
            .then(({data}) => this.list = data)
            .catch(() => this.list = [])
        }
    },
    mounted() {
        this.permissions = this.user.permissions
        this.permissions_original = Object.assign({}, this.permissions)
        this.getList()
    }

}
</script>