<?php 

namespace sistema\Nucleo;

use PDO;
use PDOException;


class Conexao
{
    private static $instancia;

    public static function getInstancia():PDO
    {
        if (empty(self::$instancia)){
            try {
                self::$instancia = new PDO('mysql:host='.DB_HOST.'; port='.DB_PORTA.'; dbname='.DB_NOME, DB_USUARIO, DB_SENHA, [
                    PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",
                    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ,
                    PDO::ATTR_CASE => PDO::CASE_NATURAL

                ]);
            } catch (PDOException $ex) {
                die("Erro de conexão:: ".$ex->getMessage());
            }
        }
        return self::$instancia;
    }

    //a classe vai ter uma única instancia
    
    //impede que novas instâncias da classe sejam criadas fora dela
    protected function __construct()
    {    
    }
    //impede que essa classe seja clonada
    private function __clone():void
    {  
    }

}
?>