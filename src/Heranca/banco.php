<?php

require_once('../../vendor/autoload.php');
use MSCode\TutoriaTurmaII\Heranca\Model\{CPF};
use MSCode\TutoriaTurmaII\Heranca\Model\Conta\{Conta,ContaPoupanca};
use MSCode\TutoriaTurmaII\Heranca\Model\Funcionario\{Diretor,Gerente};
use MSCode\TutoriaTurmaII\Heranca\Service\{ControladorDeBonificacoes};

$cpf = new CPF('123.456.789-10');
$gerente = new Gerente('David',$cpf,'Dev',1000.0);

$controladorBonificacoes = new ControladorDeBonificacoes;

$controladorBonificacoes->adicionaBonificacao($gerente);
var_dump($controladorBonificacoes->RecuperaTotalBonificacoes());


