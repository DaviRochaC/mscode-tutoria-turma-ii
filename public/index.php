<?php


require_once('../vendor/autoload.php');

use MSCode\TutoriaTurmaII\Estoque\Model;
use MSCode\TutoriaTurmaII\Estoque\Model\Filial;
use MSCode\TutoriaTurmaII\Estoque\Model\ItemEstoque;
use MSCode\TutoriaTurmaII\Estoque\Model\Produto;

$produto = new Produto(1, 'Microondas', 'branco');
$filial = new Filial(50, 'Matriz Pinheiros');

$itemEstoque = new ItemEstoque($produto, $filial);

$itemEstoque->entrar(7);

var_dump($itemEstoque->getquantidade());

$id = $itemEstoque->reservar(6);
$id2 = $itemEstoque->reservar(1);
$itemEstoque->efetivarReserva($id);
$itemEstoque->efetivarReserva($id2);

var_dump($itemEstoque->getquantidade());
