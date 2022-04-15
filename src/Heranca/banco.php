<?php

require_once('autoload.php');

use MSCode\TutoriaTurmaII\Heranca\Model\{CPF,Funcionario};
use MSCode\TutoriaTurmaII\Heranca\Model\Conta\{Conta,ContaPoupanca};

$cpf = new CPF('123.456.789-10');
$funcionario = new Funcionario('David',$cpf,'Dev');

