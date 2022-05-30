<template>
<div class="row">
    <div class="col-lg-6">
        <input v-model="form.name" type="text" name="name" placeholder="Nome">
        <p class="text-help" v-if="help.name">{{help.name}}</p>
    </div>
    <div class="col-lg-6">
        <input v-model="form.phone" v-mask="['(##) ####-####', '(##) #####-####']" type="text" name="telefone" attrname="telephone1" placeholder="Telefone">
         <p class="text-help" v-if="help.phone">{{help.phone}}</p>
    </div>
    <div class="col-lg-6">
        <input v-model="form.email" type="text" name="email" placeholder="E-mail">
         <p class="text-help" v-if="help.email">{{help.email}}</p>
    </div>

    <div class="col-lg-6">                              
        <input type="text" v-model="form.state" name="estado" class="form-control" placeholder="Estado" id="estado">
        <p class="text-help" v-if="help.state">{{help.state}}</p>
    </div>
    <div class="col-lg-6">
        <input type="text" v-model="form.city" name="cidade" class="form-control" placeholder="Cidade" id="cidade">
         <p class="text-help" v-if="help.city">{{help.city}}</p>
    </div>

    <div class="col-lg-6">
        <input v-model="form.subject" type="text" name="assunto" placeholder="Assunto">
         <p class="text-help" v-if="help.subject">{{help.subject}}</p>
    </div>
    <div class="col-lg-12">
        <textarea v-model="form.message" name="mensagem" placeholder="Mensagem"></textarea>
         <p class="text-help" v-if="help.message">{{help.message}}</p>
    </div>

    <p class="text-help" v-if="help.form">{{help.form}}</p>
    <div class="col-lg-12">
        <button :disabled="!formModified || !validate" @click.prevent="sendContact()" class="site-btn" id="enviar_mensagem">
            <i class="fa fa-paper-plane mr-2"></i> Enviar mensagem
        </button>
        <input type="hidden" name="action_by_user" value="contato">
    </div>
</div>
</template>
<script>
import Axios from 'axios'
import DefaultForm from './../commom/DefaultForm'
export default {
    name: 'contact',
    extends: DefaultForm,
    data(){
        return {
            form: {
                name: null,
                email: null,
                phone: null,
                state: null,
                city: null,
                subject: null,
                message: null,
            },
            help: {
                name: null,
                email: null,
                phone: null,
                state: null,
                city: null,
                subject: null,
                message: null,
            }
        }
    },
    computed: {
        validations(){
			return {
                name:  () => this.defaultValidations.name("O nome deve conter ao menos 4 caracteres."),
                email: () => this.defaultValidations.email("O email deve ser válido."),
                phone: () => this.defaultValidations.brPhoneNumber("O telefone deve ser válido."),
                city: () => {
                    let isValid = !!this.form.city && this.form.city.length >= 4
                    return this.setHelp('city', isValid, "Uma cidade de ser selecionada.")
                },
                state: () => {
                    let isValid = !!this.form.state && this.form.state.length >= 2
                    return this.setHelp('state', isValid,  "Um estado de ser selecionado.")
                },
                subject: () => {
                    let isValid = !!this.form.subject && this.form.subject.length >= 4
					return this.setHelp('subject', isValid, "O assunto da mensagem deve conter ao menos 4 caracteres." )
                },
                message: () => {
                    let isValid = !!this.form.message && this.form.message.length >= 4
					return this.setHelp('message', isValid, "O texto da mensagem deve conter ao menos 4 caracteres." )
                },
			}
		},
    },
    methods: {
        sendContact(){
            if (this.validate) {
                Axios.post(`${window.cmsApiBaseUrl}/contacts`, {...this.form, phone: this.umaskedPhoneNumber})
                .then(({data}) => {
                    if(data.success) {
                        window.Swal.fire(
                            'Enviada!',
                            'Mensagem enviada com sucesso!',
                            'success'
                        )
                        this.resetFormDefault({
                            name: null,
                            email: null,
                            phone: null,
                            state: null,
                            city: null,
                            subject: null,
                            message: null,
                        })
                        return
                    }
                })
                .catch((error) => {
                    if(error?.response.data.errors)  {
                        let errors = error.response.data.errors
                        this.setHelps(errors)
                        if(errors.form)  {
                            window.Swal.fire(
                                'Ops!',
                                errors.form,
                                'error'
                            )
                            return
                        }
                    }
                    window.Swal.fire(
                        'Ops!',
                        'Ocorreu um erro ao tentar enviar a mensagem!',
                        'error'
                    )
                })
            }
        }
    },
    mounted(){
        this.resetFormDefault({
            name: null,
            email: null,
            phone: null,
            state: null,
            city: null,
            subject: null,
            message: null,
        })
    }
}
</script>