# Bíblia Online

Este é um site em PHP desenvolvido com a utilização do MySQL para armazenamento de dados, com o objetivo de fornecer acesso fácil e rápido aos versículos da Bíblia, livre de anúncios presentes em diversos sites da web que oferecem a mesma funcionalidade.

## Configurações

### Arquivo de configuração (biblia.ini)

O arquivo `biblia.ini` contém diversas configurações essenciais para o funcionamento do sistema, incluindo:
- Configurações de comunicação com o SGBD;
- Detalhes de autenticação de usuários;
- Definições de permissões de operações;
- Opção de ativar a depuração para exibir erros em tela;
- Possibilidade de registro de erros em arquivo quando a depuração está desativada;
- Restrições de quais arquivos podem ser acessados;
- Nome do COOKIE de sessão;
- Versão da bíblia padrão;
- Título e descrição do sistema.

### Arquivo de configuração de URL (`.htaccess`)

No arquivo `.htaccess`, você deve configurar a URL base do sistema para garantir o funcionamento correto das rotas.

## Requisitos do sistema

No processo de desenvolvimento foram utilizadas as seguintes versões dos softwares:
- [MySQL](https://www.mysql.com): 10.11
- [PHP](https://www.php.net): 8.4

## Frameworks utilizados

Os seguintes frameworks estão inclusos no repositório:
- [jQuery](https://jquery.com): 3.7.1
- [Semantic UI](https://semantic-ui.com): 2.5.0

## Testes locais

Para executar o sistema localmente para fins de teste, utilize o seguinte comando:

```bash
php -S localhost:8080 rotas.php
```

Certifique-se de que todas as dependências estejam devidamente instaladas e configuradas antes de iniciar os testes.

Aproveite o acesso fácil aos versículos da Bíblia e o ambiente livre de anúncios fornecido pelo projeto [Bíblia Online](https://biblia.luizamichi.com.br)!
