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

    public function armazenar(array $dados):void
    {
        $query = "insert into categorias (titulo, texto, status) values (?,?,?)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['titulo'], $dados['texto'], $dados['status']]);
    }

    public function atualizar(array $dados, int $id):void
    {
        
        $query = "update categorias set titulo = ?, texto = ?, status = ? where id = {$id}";

        $stmt = Conexao::getInstancia()->prepare($query);

        $stmt->execute([$dados['titulo'], $dados['texto'], $dados['status']]);
        
    }

    public function excluir(int $id):void
    {
        
        $query = "delete from categorias where id = {$id}";

        $stmt = Conexao::getInstancia()->prepare($query);

        $stmt->execute();
    }

    public function total (?string $termo = null):int
    {
        $termo = ($termo ? "where {$termo}":"") ;
        $query = "select * from categorias {$termo}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();   
        return $stmt->rowCount();
    }

}
?>
