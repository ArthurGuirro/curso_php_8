<?php 

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Modelo\PostModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;


class SiteControlador extends Controlador
{
    public function __construct ()
    {
        parent::__construct('templates/site/views');
    }

    public function categorias()
    {
        return ((new CategoriaModelo())->busca());
    }

    public function categoria(int $id):void
    {
        $posts = ((new CategoriaModelo())->posts($id));
        echo $this->template->renderizar('categoria.html', [
            'posts'=>$posts,
            'categorias' => $this->categorias()
        ]);
    }
    
    public function buscar():void
    {
        $busca = filter_input(INPUT_POST,'busca', FILTER_DEFAULT);
        if (isset($busca)){
            $posts = (new PostModelo())->pesquisa($busca);
            echo"<p>Opções</p><hr> ";
            foreach ($posts as $post){
                echo "<li class='list-group-item fw-bold'><a href = ".Helpers::url('post/').$post->id." class = 'text-white'> $post->titulo </a></li> ";
                //'<br>';
                //echo "<a href = ".Helpers::url('post/').$post->id." class = 'text-white'> $post->titulo </a><hr>";
            }
        }   
    }

    public function index() :void
    {   
        $posts = (new PostModelo())->busca();
        echo $this->template->renderizar('index.html', [
            'posts'=>$posts,
            'categorias' => $this->categorias()
        ]);
    }

    public function post(int $id): void
    {
       $post = (new PostModelo())->buscaPorId($id);
       if (!$post){
        Helpers::redirecionar('404');
       }
       echo $this->template->renderizar('post.html', [
            'post'=>$post,
            'categorias' => $this->categorias()
       ]);
    }

    public function sobre() :void
    {
        echo $this->template->renderizar('sobre.html', [
            //'titulo'=>'Orientações de um programador web',
            'subtitulo' =>'Questionários rápidos',
            'categorias' => $this->categorias()
        ]);
        //exit;
    }

    
    public function erro404() :void
    {
        echo $this->template->renderizar('404.html', [
            'titulo'=>'Página não encontrada',
            'categorias' => $this->categorias()
        ]);
    }
    

}

?>