<?php

require_once('../../vendor/autoload.php');
use MSCode\TutoriaTurmaII\Heranca\Model\{CPF};
use MSCode\TutoriaTurmaII\Heranca\Model\Funcionario\{Diretor};
use MSCode\TutoriaTurmaII\Heranca\Service\Autenticador;

$cpf = new CPF('123.456.789-10');
$diretor = new Diretor('Joao Paulo',$cpf,10000.0);

$autenticador = new Autenticador();

$autenticador->tentaLogin($diretor,'4321');


