# Grupo de Pesquisa em Engenharia de Algoritmo
Website desenvolvido com WordPress.

No diretório `wp-db` encontra-se o arquivo exportado pelo WordPress em XML e também todo o banco de dados em SQL.

Basta criar o banco de dados, definir as configurações no arquivo `wp-config.php` e exportar o arquivo com o backup do banco de dados para o servidor MySQL.

Feito isso, coloque os arquivos no diretório configurado para o Apache visualizar na porta 80 (ou a porta configurada) com exceção do diretório `wp-db`. Também vale-se ressaltar que os usuários devem ser criados via banco.