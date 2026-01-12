from django.contrib import admin
from .models import Experiencia
from .models import Conhecimento
from .models import Contato
from .models import Social
from .models import Repositorio
from .models import Projeto
from .models import Formacao
from .models import InformacaoExtra
from .models import AcaoVisitate

# Register your models here.
class DefaultAdmin(admin.ModelAdmin):
    def get_list_display(self, request):
        print(request)
        # if(request.user.is_superuser) :
        #     self.list_display.append('user')
        return super(__class__, self).get_list_display(request)
        
    def add_view(self, request, form_url="", extra_context=None):
        if(request.user.is_superuser) :
            #self.readonly_fields = () # to do remove 'user' field on readonly_fields tuble
            data = request.GET.copy()
            data['user'] = request.user
            request.GET = data
        return super(__class__, self).add_view(request, form_url, extra_context)
    
    def change_view(self, request, object_id, form_url= "", extra_context=None):
        # if(request.user.is_superuser) :
        #     self.readonly_fields = ('user', ) # to do remove 'user' field on readonly_fields tuble
        return super(__class__, self).change_view(request, object_id, form_url, extra_context)

    def save_model(self, request, obj, form, change):
        if(not request.user.is_superuser):
            obj.user = request.user
        return super(__class__, self).save_model(request, obj, form, change)
    
    def delete_model(self, request, obj) :
        if(request.user.is_superuser or obj.user.id == request.user.id):
            return super(__class__, self).delete_model(request, obj)
        
    def delete_queryset(self, request, queryset) :
        for obj in queryset:
            if(request.user.is_superuser or obj.user.id == request.user.id):
                super(__class__, self).delete_model(request, obj)
                
    def get_queryset(self, request):
        items = super(__class__, self).get_queryset(request)
        if(not request.user.is_superuser) :
            return items.filter(user=request.user)
        return items

# Obs: tupla termina com virgula caso a lista tenha somente um item
class ExperienciaAdmin(admin.ModelAdmin):
    list_display = ('empresa', 'cargo', 'descricao', 'periodo_inicio', 'periodo_final', 'user')
    readonly_fields = ('user',)

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Experiências Profissionais"
        self.opts.verbose_name="Experiência"

class ConhecimentoAdmin(DefaultAdmin):
    list_display = ('titulo', 'descricao')
    readonly_fields = ('user',)

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Conhecimentos"
        self.opts.verbose_name="Conhecimento"

class ContatoAdmin(DefaultAdmin):
    list_display = ('contato', 'tipo')
    readonly_fields = ('user',)

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Contatos"
        self.opts.verbose_name="Contato"

class SocialAdmin(DefaultAdmin):
    list_display = ('username', 'provider', 'link')
    readonly_fields = ('user',)
    verbose_name_plural = "Redes Sociais"

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Redes Sociais"
        self.opts.verbose_name="Social"

class RepositorioAdmin(DefaultAdmin):
    list_display = ('username', 'provider', 'link')
    readonly_fields = ('user',)

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Repositórios"
        self.opts.verbose_name="Repositório"

class ProjetoAdmin(DefaultAdmin):
    list_display = ('nome', 'descricao', 'link')
    readonly_fields = ('user',)

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Projetos"
        self.opts.verbose_name="Projeto"

class FormacaoAdmin(DefaultAdmin):
    list_display = ('intituicao', 'curso', 'nivel_de_ensino', 'periodo_inicio', 'periodo_final', 'situacao')
    readonly_fields = ('user',)

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Formações"
        self.opts.verbose_name="Formação"

class InformacaoExtraAdmin(DefaultAdmin):
    list_display = ('informacao', )
    readonly_fields = ('user',)

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Informações Extra"
        self.opts.verbose_name="Informação Extra"

class AcaoVisitateAdmin(DefaultAdmin):
    list_display = ('acao', 'usuario', 'created_at')
    readonly_fields = ('user',)

    def __init__(self, model, admin_site):
        super().__init__(model, admin_site)
        self.opts.verbose_name_plural="Ações dos Visitantes"
        self.opts.verbose_name="Ação do Visitantes"

admin.site.register(Experiencia, ExperienciaAdmin)
admin.site.register(Conhecimento, ConhecimentoAdmin)
admin.site.register(Contato, ContatoAdmin)
admin.site.register(Social, SocialAdmin)
admin.site.register(Repositorio, RepositorioAdmin)
admin.site.register(Projeto, ProjetoAdmin)
admin.site.register(Formacao, FormacaoAdmin)
admin.site.register(InformacaoExtra, InformacaoExtraAdmin)
admin.site.register(AcaoVisitate, AcaoVisitateAdmin)



# Register your actions here.
def my_action(self, request, queryset):
    print("Minha ação teste está ok!", request.user.id, queryset, admin.site.actions)

admin.site.add_action(my_action, 'Minha ação teste')