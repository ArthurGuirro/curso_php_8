<?php 

namespace sistema\Modelo;
use sistema\Nucleo\Conexao;

class PostModelo
{
    public function busca():array
    {
        $query = "select * from post";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }

    public function buscaPorId(int $id):bool|object
    {
        $query ="select * from post where id = {$id}";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();
        return $resultado;
    }

    public function pesquisa(string $busca):array
    {
        $query = "select * from post where status = 1 and titulo like '%{$busca}%'";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
/*------------------------------------------------------
Pode ser feito dessa forma também
    public function ler(int $id = null):array
    {
        $where = ($id ? "WHERE id = {$id}" : '')
        $query = "select * from post {$where}";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;

    }

no index: $posts = (new PostModelo())->ler();
tem que passar o id dentro de ler(), exemplo
$posts = (new PostModelo())->ler(2);
foreach ($posts as $post)
{
    echo $post->titulo.'<br>';
}
------------------------------------------------------*/

}
?>