#!/bin/bash
#

# carrega o arquivo de configuração
source config.sh


# Mensagem de inicio
echo ""
echo -e "\033[33;1m Script iniciado \033[0m"


# Exporta o banco de dados
echo "  - Exportando o banco de dados do servidor $HOST_SERVER"
$MYSQL_DIR/mysqldump.exe --default-character-set=utf8 --host=$HOST_SERVER --user=$USER_SERVER --password=$PASS_SERVER $BANC_SERVER > $FILE_NAME


# Apaga todas as tabelas do banco
echo "  - Excluindo todas as tabelas do servidor $HOST_LOCAL"
DROP=$($MYSQL_DIR/mysql.exe --host=$HOST_LOCAL --user=$USER_LOCAL --password=$PASS_LOCAL $BANC_LOCAL -e "SELECT concat('DROP TABLE',' ',table_name,';') as TABELAS FROM information_schema.TABLES WHERE TABLE_SCHEMA='$BANC_LOCAL';" | sed s/TABELAS// )
$MYSQL_DIR/mysql.exe --host=$HOST_LOCAL --user=$USER_LOCAL --password=$PASS_LOCAL $BANC_LOCAL -e "$DROP"


# Importando o novo banco de dados 
echo "  - Importando o novo banco de dados no servidor $HOST_LOCAL"
$MYSQL_DIR/mysql.exe --host=$HOST_LOCAL --user=$USER_LOCAL --password=$PASS_LOCAL $BANC_LOCAL < $FILE_NAME


# Mensagem de Finalização
echo ""
echo -e "\033[33;1m Script finalizado \033[0m"
