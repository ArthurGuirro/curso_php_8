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

    public function armazenar(array $dados):void
    {
        $query = "insert into post (categoria_id, titulo, texto, status) values (?,?,?,?)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['categoria_id'],$dados['titulo'], $dados['texto'], $dados['status']]);
    }
    
    public function atualizar(array $dados, int $id):void
    {
        
        $query = "update post set titulo = ?, texto = ?, status = ?, categoria_id = ? where id = {$id}";

        $stmt = Conexao::getInstancia()->prepare($query);

        $stmt->execute([$dados['titulo'], $dados['texto'], $dados['status'], $dados['categoria_id']]);
        
    }

    public function excluir (int $id):void
    {
        $query = "delete from post where id = {$id}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();   
    }

    public function total (?string $termo = null):int
    {
        $termo = ($termo ? "where {$termo}":"") ;
        $query = "select * from post {$termo}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();   
        return $stmt->rowCount();
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

--jeito que não deu bom de armazenar--
public function armazenar(array $dados):void
    {
        $query = "insert into post (categoria_id, titulo, texto, status) values (:categoria_id,:titulo,:texto,:status)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute($dados);
    }
------------------------------------------------------*/

}
?>