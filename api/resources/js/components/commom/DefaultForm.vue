<script>
export default {
    name: "default-form",
    data(){
        return {
            form_original: null,
            form: null,
            help: {
                form: null
            },
            regex: {
                email:  new RegExp("^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"),
                //password: new RegExp("^[a-zA-Z0-9.]$"),
            }
        }
    },
    computed: {
        disableSaveBtn(){
            return !this.formModified || (!this.formModified && !this.validate)
        },
        formModified(){
			return JSON.stringify(this.form_original) !== JSON.stringify(this.form)
		},
        umaskedPhoneNumber() {
            return  !!this.form.phone ? 
                    this.form.phone
                    .replaceAll('(', '')
                    .replaceAll(')', '')
                    .replaceAll(' ', '')
                    .replaceAll('-', '')
                    .trim() : ''
        },
        defaultValidations(){
            return {
                email: (message = null) => {
                    let isValid = (!!this.form.email && this.form.email.length >= 4) && this.regex.email.test(this.form.email)
                    return this.setHelp('email', isValid, (message || "O campo email de conter um endereço válido."))
                },
                password: (message = null, minlength = 8) => {
                    let isValid = !!this.form.password && this.form.password.length >= (parseInt(minlength) || 8) 
                    //&& this.regex.password.test(this.form.password)
                    return this.setHelp('password', isValid, (message || "O campo senha não pode ser vazio."))
                },
                name: (message = null) => {
                    let isValid = !!this.form.name && this.form.name.length >= 4
                    return this.setHelp('name', isValid, (message || "O campo nome deve conter ao menos 4 caracteres."));
                },
                brPhoneNumber: (message = null, allowNull = false) => {
                    let phonelength = 0
                    if (!!this.form.phone) phonelength = this.umaskedPhoneNumber.length
                    let isValid = (phonelength === 10 || phonelength === 11) || (!this.form.phone && allowNull === true)
					return this.setHelp('phone', isValid, (message || "O telefone deve ser válido."));
                },
            }
        },
		validations(){
			return {
                //Ex: validation_name: () => arrow_function_here
                default: () => false
			}
		},
		validate(){
			let validated = Object.values(this.validations).every(v => v())
			if (validated || !this.formModified) this.resetHelps()
            if(!validated && this.formModified) this.help.form = "Preencha todos os campos corretamente."
			return validated
		},
    },
    methods: {
        setFormDefault(data = {}){
            this.form = Object.assign({}, data)
            this.form_original = Object.assign({}, data)
        },
        resetFormDefault(form = null){
            this.form = Object.assign({}, form)
            this.form_original = Object.assign({}, this.form)
            this.resetHelps()
        },
        resetHelps() {
            Object.keys(this.help).forEach((key) => {this.help[key] = null})
        },
        setHelps(msgs = []) {
            Object.keys(msgs).forEach((key) => {
                if(typeof msgs[key] === 'object') this.help[key] = msgs[key][0]
                else this.help[key] = msgs[key]
            })
        },
        setHelp(formProp, isValid = false, message = null) {
            if (this.form.hasOwnProperty(formProp) && this.help.hasOwnProperty(formProp))  {
                this.help[formProp]  = !isValid && !!this.form[formProp] ? message : null
            } else {
                console.error(`Propriedade ${formProp} não encontrada no object form ou help`)
                return false;
            }
            return isValid
        }
    }
}
</script>
