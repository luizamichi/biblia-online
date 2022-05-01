# Bíblia Online
Site feito em PHP com a utilização do MySQL para armazenamento de dados.

Criado para poder ter acesso fácil e rápido aos versículos da Bíblia livre de anúncios dos diversos sites na web que têm a mesma funcionalidade.


### Configurações
No arquivo `biblia.ini` contém as configurações que devem ser definidas para comunicação com o SGBD, contém as configurações para login de usuário e também as operações permitidas de CRUD (funciona somente CREATE e READ).

Ativando a depuração, os possíveis erros gerados serão exibidos em tela, caso contrário será salvo o último erro no arquivo `biblia.ini`.

Também é possível restringir quais arquivos poderão ser acessados no arquivo `biblia.ini` e definir o nome do COOKIE de sessão, o título e descrição do sistema.

No arquivo `.htaccess` deve ser definida a URL base do sistema.


### Versões
- [MySQL](https://www.mysql.com/) : 8.0.28
- [PHP](https://www.php.net/): 8.1.2
- [jQuery](https://jquery.com/): 3.6.0
- [Semantic UI](https://semantic-ui.com/): 2.4.1
