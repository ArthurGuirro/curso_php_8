<?php

namespace sistema\Nucleo;

class Mensagem
{   
    //
    public static function testeMensagem(string $msg):string
    {
        return $msg;
    }
    //
    private $texto;
    private $css;

    public function __toString()
    {
        return $this -> renderizar();
    }
    public function sucesso(string $mensagem): mensagem
    {
        $this->css = "alert alert-success";
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }
    
    public function renderizar() : string
    {
        return "<div class ='{$this->css}'> {$this->texto} </div>";    
    }

    private function filtrar(string $mensagem): string
    {
        return filter_var($mensagem, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}

?>