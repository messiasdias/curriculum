from django.db import models
from django.contrib.auth.models import User


# Experiências de trabalho
class Experiencia(models.Model) :
    empresa = models.CharField(max_length=200, null=False)
    cargo = models.CharField(max_length=200, null=False)
    descricao = models.TextField(max_length=5000, null=False)
    periodo_inicio = models.DateField(null=False)
    periodo_final = models.DateField(null=True, blank=True)
    user = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self) -> str:
        return f'{self.cargo} em {self.empresa}'


# Conhecimentos do usuário
class Conhecimento(models.Model) :
    titulo = models.CharField(max_length=200, null=False)
    descricao = models.CharField(max_length=5000, null=False)
    user = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self) -> str:
        return self.titulo

 
# Contatos do usuário
class Contato(models.Model) :
    tipos = (
        ('phone', 'Telefone'),
        ('email', 'Email'),
        ('wp', 'Whatsapp'), 
        ('outro', 'Outro')
    )

    contato = models.CharField(max_length=200, null=False)
    tipo = models.CharField(max_length=200, null=False, choices=tipos, default="outro")
    user = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self) -> str:
        # @to-do: return formated by 'tipo' field, ex phone, wp, etc...
        switcher = {
            "Telefone": f"{self.contato}",
            "Email": f"{self.contato}",
            "Whatsapp": f"{self.contato}",
            "Outro": self.contato
        }
        return switcher.get(self.tipo, self.contato)


# Contatos do usuário
class Social(models.Model) :
    providers = (
        ('linkedin', 'Linkedin'), 
        ('facebook', 'Facebook'), 
        ('youtube', 'Youtube'),
        ('github', 'Github'), 
        ('bitbucket', 'Bitbucket'), 
        ('gitlab', 'Gitlab'), 
        ('outro', 'Outro')
    )
    
    username = models.CharField(max_length=200, null=False)
    provider = models.CharField(max_length=200, null=False, choices=providers, default="outro")
    link = models.CharField(max_length=5000, null=True, blank=True)
    user = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self) -> str:
        switcher = {
            "linkedin": f"https://linkedin.com/in/{self.username}",
            "facebook": f"https://facebook.com/{self.username}",
            "youtube": f"https://youtube.com/@{self.username}/videos",
            "github": f"https://github.com/{self.username}",
            "bitbucket": f"https://bitbucket.org/{self.username}",
            "gitlab": f"https://gitlab.com/{self.username}",
            "outro": self.link
        }
        return switcher.get(self.provider, self.link)

# Repositorios do usuário
class Repositorio(models.Model) :
    providers = (
        ('github', 'Github'), 
        ('bitbucket', 'Bitbucket'), 
        ('gitlab', 'Gitlab'), 
        ('outro', 'Outro')
    )

    username = models.CharField(max_length=200, null=False)
    provider = models.CharField(max_length=200, null=False, choices=providers, default="outro", unique=True)
    link = models.CharField(max_length=5000, null=True, blank=True, choices=providers)
    user = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self) -> str:
        switcher = {
            "Github": f"https://github.com/{self.username}",
            "Bitbucket": f"https://bitbucket.org/{self.username}",
            "Gitlab": f"https://gitlab.com/{self.username}",
            "Outro": self.link
        }
        return switcher.get(self.provider, self.link)


# Projetos do usuário
class Projeto(models.Model) :
    nome = models.CharField(max_length=200, null=False)
    descricao = models.CharField(max_length=5000, null=True, blank=True)
    link = models.CharField(max_length=5000, null=False)
    user = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self) -> str:
        return self.nome


# Formações do usuário
class Formacao(models.Model) :
    situacoes = (
        ('completo', 'Completo'),
        ('interrompido', 'Interrompido'), 
        ('em_curso','Em Curso')
    )
    niveis_de_ensino = (
        ('profissionalizante' ,'Profissionalizante'), 
        ('tecnico' ,'Técnico'), 
        ('tecnologo' ,'Tecnólogo'), 
        ('graduacao' ,'Graduação'), 
        ('pos_graduacao' ,'Pós-Graduação'),  
        ('Superior' ,'Superior'), 
        ('outro' ,'Outro')
    )

    intituicao = models.CharField(max_length=200, null=False)
    curso = models.CharField(max_length=200, null=False, default="em_curso")
    nivel_de_ensino = models.CharField(max_length=200, null=False, choices=niveis_de_ensino, default="outro")
    periodo_inicio = models.DateField(null=False)
    periodo_final = models.DateField(null=True, blank=True)
    situacao = models.TextField(max_length=5000, null=False, choices=situacoes)
    user = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self) -> str:
        # @to-do: Format periodo_inicio-periodo_final only year and add to string
        texto = f'{self.curso} - {self.intituicao} 2013-2014 ({self.situacao})'
        if(self.nivel_de_ensino != 'Outro'):
            return f'{self.nivel_de_ensino} em {texto}'
        return texto

   
# Informacões relevantes do usuário
class InformacaoExtra(models.Model) :
    informacao = models.CharField(max_length=5000, null=False, unique=True)
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    
    def __str__(self) -> str:
        return self.informacao

 
# Ações dos visitantes no curriculum
class AcaoVisitate(models.Model) :
    acoes = (
        ('view','Visualização'),
        ('print','Impressão'), 
        ('wp','Envio Menssagem no Whatsapp'), 
        ('email','Envio Menssagem no Email'), 
    )

    device_types = (
        ('mobile','Smartphone'),
        ('tablet','Tablet'), 
        ('desktop','Desktop'), 
        ('tv','SmartTV'), 
    )

    acao = models.CharField(max_length=200, null=False, choices=acoes, default="view")
    usuario = models.CharField(max_length=200, null=True, blank=True)
    ip_address = models.CharField(max_length=200, null=True, blank=True)
    geo_location = models.CharField(max_length=200, null=True, blank=True)
    device_vendor = models.CharField(max_length=200, null=True, blank=True)
    device_type = models.CharField(max_length=200, null=True, blank=True, choices=device_types)
    device_browser = models.CharField(max_length=200, null=True, blank=True)
    created_at = models.DateTimeField(auto_now_add=True)
    user = models.ForeignKey(User, on_delete=models.CASCADE)

    def __str__(self) -> str:
        switcher = {
            'print': 'Impressão', 
            'wp': 'Envio Menssagem no Whatsapp', 
            'email': 'Envio Menssagem no Email',
            'view': 'Visualização'
        }
        return switcher.get(self.acao, 'Nenhuma Ação')