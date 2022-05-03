<?php

require_once('../../vendor/autoload.php');

use MSCode\TutoriaTurmaII\TreinamentoTestes\Model\{Leilao,Usuario,Lance};
use MSCode\TutoriaTurmaII\TreinamentoTestes\Service\Avaliador;

$leilao = new Leilao('Notebook');

$user1 = new Usuario('maria');
$user2 = new Usuario('Joao');

$lance1 = new Lance($user1,2499);
$lance2 = new Lance($user2,2500);


$leilao->recebeLance($lance1);
$leilao->recebeLance($lance2);

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);
echo($leiloeiro->getMaiorValor());
