<?php 

namespace sistema\Nucleo;

use Exception;

class Helpers
{
    //
    public static function testeHelpers(string $msg):string
    {
        return $msg;
    }
    //

    public static function redirecionar(string $url = null):void
    {
        header('HTTP/1.1 302 Found');

        $local = ($url ? self::url($url) : self::url());
        
        header("Location: {$local}");
        exit();
    }

    public static function validarCPF(string $cpf):string
    {
        $cpf = self::limparNumero($cpf);

        if (mb_strlen($cpf) !=11 or preg_match('/(\d)\1{10}/',$cpf))
        {
            //exceções
            throw new Exception('CPF precisa ter 11 digitos');
        }
        for ($t = 9; $t < 11; $t++)
        {
            for ($d = 0, $c = 0; $c < $t; $c++)
            {
                $d += $cpf[$c]*(($t+1)-$c);
            }
            $d = ((10*$d)%11)%10;
            if ($cpf[$c] != $d)
            {
                throw new Exception('CPF inválido');
            }

        }
        return true;
    }

    public static function limparNumero(string $numero):string
    {
        return preg_replace('/[^0-9]/','',$numero);
    }
    public static function dataAtual():string
    {
        $diaMes = date('d');
        $diaSemana = date('w');
        $mes = date('n')-1;
        $ano = date('Y');

        $nomeDiasSem = ['dom','seg','ter','qua','qui','sex','sab'];
        $nomeMeses = ['jan','fev','mar','abr','mai','jun','jul','ago','set','out','nov','dez'];

        $dataFormat = $nomeDiasSem[$diaSemana].'-'.$diaMes.'/'.$nomeMeses[$mes].'/'.$ano;

        return $dataFormat;
    }

    public static function validarEmail(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function contarTempo(string $data)
    {

        //recebe os segundos de toda a data atual
        $agora = strtotime(date('Y-m-d H:i:s'));
        //recebe a data de criação do arquivo, vem do db
        $tempo = strtotime($data);
        $diferenca = $agora - $tempo;

        $segundo = $diferenca;
        $minutos = round($diferenca / 60);
        $horas = round($diferenca / 3600);
        $dias = round($diferenca / 86400);
        $semanas = round($diferenca / 604800);
        $meses = round($diferenca / 2419200);
        $anos = round($diferenca / 29030400);

        if ($segundo <= 60) {
            return 'agora';
        } elseif ($minutos <= 60) {
            return $minutos == 1 ? 'há 1 minuto' : 'há ' . $minutos . ' minutos';
        } elseif ($horas <= 24) {
            return $horas == 1 ? 'há 1 hora' : 'há ' . $horas . ' horas';
        } elseif ($dias <= 30) {
            return $dias == 1 ? 'há 1 dia' : 'há ' . $dias . ' dias';
        }elseif ($meses <= 12) {
            return $meses == 1 ? 'há 1 mês' : 'há ' . $meses . ' meses';
        } elseif ($anos <= 30) {
            return $anos == 1 ? 'há 1 ano' : 'há ' . $anos . ' anos';
        }
    }

    public static function url(string $url = null):string
    {
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente = ($servidor == 'localhost' ? URL_DESENVOLVIMENTO : URL_PRODUCAO);

        if (str_starts_with($url, '/')){
            return $ambiente . $url;
        }
        return $ambiente . '/' . $url;

    }

    public static function localhost():bool
    {
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        if ($servidor == 'localhost'){
            return true;
        }
        return false;
    }
}
?>