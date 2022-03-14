<?php


require_once('../vendor/autoload.php');

use MSCode\TutoriaTurmaII\Estoque\Model;
use MSCode\TutoriaTurmaII\Estoque\Model\Filial;
use MSCode\TutoriaTurmaII\Estoque\Model\Estoque;
use MSCode\TutoriaTurmaII\Estoque\Model\Produto;


 $produto1 = new Produto(584, 'Microondas', 'branco');
 $produto2 = new Produto(580, 'notebook', 'branco');
$filial1 = new Filial(50, 'Matriz Pinheiros');
$filial2 = new Filial(2, 'Matriz Pinheiros');

$estoque1 = new Estoque($filial1);
$estoque2 = new Estoque($filial2);


$estoque1->entrar($produto1,25);
$reserva = $estoque1->reservar($produto1,5);

//$estoque1->efetivarReserva($reserva);

//problema = na transferencia nao esta somando estoque e sim setando o estoque como valor
//produto 1 tem 0
$estoque2->entrar($produto1,10);
$estoque2->transferir($produto1,10,$estoque1);


var_dump($estoque1->todosProdutos(),$estoque2->todosProdutos());
echo('<br><br>');

echo "<pre>";
   print_r($estoque1->todasReservas());
echo "</pre>";







