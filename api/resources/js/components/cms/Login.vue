<template>
<div class="auth-body-bg">
    <div class="home-btn d-none d-sm-block">
        <a href="/"><i class="mdi mdi-home-variant h2 text-white"></i></a>
    </div>
        
    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-4">
                    <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                        <div class="w-100">
                            <div class="row justify-content-center">
                                <div class="col-lg-9">
                                    <div>
                                        <div class="text-center">
                                            <div>
                                                <a href="/home" class="logo"><img :src="`${assets}img/speel.svg`" height="65" alt="logo"></a>
                                            </div>

                                            <h4 class="font-size-18 mt-4">Bem Vindo(a)!</h4>
                                            <p class="text-muted">Faça login para continuar.</p>
                                        </div>
                                        
                                        <div class="p-2 mt-5">
                                            <form @submit.prevent="login()" >           
                                                <div class="mb-3 auth-form-group-custom">
                                                    <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                    <label for="email">Username</label>
                                                    <input aria-label="" type="text" class="form-control" id="email" v-model="form.email" placeholder="seunome@mail.com">
                                                </div>
                                                <div class="mb-3 auth-form-group-custom mb-4">
                                                    <ul v-if="help.email" class="parsley-errors-list filled" id="parsley-email" aria-hidden="false">
                                                        <li class="parsley-minlength">{{help.email}}</li>
                                                    </ul>
                                                </div>
                                                <div class="mb-3 auth-form-group-custom">
                                                    <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="password" v-model="form.password" placeholder="Sua senha">
                                                </div>
                                                <div class="mb-3 auth-form-group-custom mb-4">
                                                    <ul v-if="help.password" class="parsley-errors-list filled" id="parsley-password" aria-hidden="false">
                                                        <li class="parsley-minlength">{{help.password}}</li>
                                                    </ul>
                                                    <ul v-if="help.form" class="parsley-errors-list filled" id="parsley-form" aria-hidden="false">
                                                        <li class="parsley-minlength">{{help.form}}</li>
                                                    </ul>
                                                </div>

                                                <div class="form-check">
                                                    <input v-model="form.remember" type="checkbox" class="form-check-input" id="customControlInline">
                                                    <label class="form-check-label" for="customControlInline">Lembrar de mim</label>
                                                </div>
                                                <div :disabled="!formModified && !validate" class="mt-4 text-center">
                                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Entrar</button>
                                                </div>
                                                <!-- <div class="mt-4 text-center">
                                                    <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i> Esqueceu sua senha?</a>
                                                </div> -->
                                            </form>
                                        </div>
                                        
                                        <div class="mt-5 text-center">
                                            <!-- <p>Ainda Não tem uma conta? <a href="auth-register.html" class="fw-medium text-primary"> Registrar </a> </p> -->
                                            <!-- <p>© <script>document.write(new Date().getFullYear())</script> Nazox. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="authentication-bg">
                        <div class="bg-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</template>
<script>
import DefaultForm from './../commom/DefaultForm.vue'
import Axios from 'axios'

export default {
    name: "login",
    extends: DefaultForm,
    data(){
        return {
            assets: window.assets,
            form_original: null,
            form: {
                email: null,
                password: null,
                remember: false
            },
            help: {
                email: null,
                password: null,
                remember: false,
                form: null
            },
        }
    },
    computed: {
		validations(){
			return {
                email: () => this.defaultValidations.email("O campo email deve conter um endereço válido." ),
                password: () => {
                    let isValid = !!this.form.password && this.form.password.length >= 8 
                    return this.setHelp('password', isValid, "O campo senha não pode ser vazio.")
                }
			}
		},
    },
    methods: {
        login(){
            if (this.validate) {
                this.help.form = null
                Axios.post(`${window.cmsApiBaseUrl}/auth/login`, this.form)
                .then(({data}) => {
                    this.$emit("login", {
                        token: data.access_token,
                        expires_in: data.expires_in,
                        remember: this.form.remember,
                    })
                })
                .catch((error) => {
                    if(error?.response.data.error === "Unauthorized") {
                        this.help.form = "Dados incorretos ou usuário não encontrado."
                    }
                    if(error?.response.data.error?.form) {
                        this.help.form = error?.response.data.error?.form
                    }
                    this.$emit("login", null)
                })
            } else {
                this.help.form = "Preencha todos os campos corretamente."
            }
        }
    },
    beforeMount(){
         this.resetFormDefault({
            email: null,
            password: null,
            remember: true
		})
    }
}
</script>
