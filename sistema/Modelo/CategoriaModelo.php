<?php 

namespace sistema\Modelo;
use sistema\Nucleo\Conexao;

class CategoriaModelo
{
    public function busca():array
    {
        $query = "select * from categorias order by titulo asc";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    public function buscaPorId(int $id):bool|object
    {
        $query ="select * from categorias where id = {$id}";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();
        return $resultado;
    }

    public function posts(int $id):array
    {
        $query = "select * from post where categoria_id = {$id} and status = 1 order by id desc";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

}
?>
