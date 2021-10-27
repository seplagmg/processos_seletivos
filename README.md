Bem vindos ao sistema de Processos Seletivos Simplificados. Este é um sistema construído em PHP/MySQL para apoiar a realização desses processos no setor público. Este sistema foi criado pela Secretaria de Estado de Planejamento e Gestão do Governo de Minas Gerais. O sistema foi construído usando o framework CodeIgniter 3, com alguns frameworks abertos de javascript.

A instalação se dá manualmente. Até o momento, não construímos a instalação via docker para ele. A homologação desta instalação se deu em um ambiente Debian 10. Para outros ambientes o desenvolvedor irá precisar adaptar alguns dos passos e dependências utilizadas.


## Manuais online

https://ati-seplag.gitbook.io/processos-seletivos-candidatos/: Candidatos

https://ati-seplag.gitbook.io/processos-seletivos-gestores-e-avaliadores/: Gestores e avaliadores


## SMTP

O sistema é bastante dependente de disparos de e-mails. O sistema está utilizando o SMTP para realizar o envio de email. Como isso é uma parte central do sistema, o desenvolvedor deve alterar as credenciais utilizadas para um servidor na qual ele tenha controle no arquivo '/application/config/custom.php'.


## Criptografia das senhas no banco

O CodeIgniter, framework utilizado na construção do sistema, utiliza uma biblioteca própria para criptografar e descriptografar as senhas. O desenvolvedor pode alterar a chave de criptografia utilizada no processo alterando a configuração `encryption_key`, no arquivo `application/config/config.php`. Nesse caso, o usuário de referência não conseguirá acessar pelos dados abaixo.

## Usuários

No script de criação da estrutura do banco de dados existe a criação de um usuário inicial: 
 
Login: 99999999999
Senha: teste123


## Server

O servidor utiliza as seguintes dependências:

	- php7.3
	- php-fpm
	- php-pgsql
	- php-mbstring 
	- php-curl 
	- php7.3-mysql 
	- nginx 
	- sendmail

### Variáveis de ambiente

É necessário cadastrar os parâmetros de banco de dados e da aplicação na pasta '/application/configs', arquivos 'database.php' e 'custom.php'. 


## Detalhamento final

O sistema foi criado com base na lógica de processos seletivos do Poder Executivo de Minas Gerais. Nesse sentido, várias nomenclaturas e funcionalidades são específicas e devem ser adaptadas internamente. É fundamental avaliar o manual de usuário do sistema para se ter maior contato com as funcionalidades.
