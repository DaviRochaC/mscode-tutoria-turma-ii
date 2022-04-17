<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Funcionario;

use Exception;
use MSCode\TutoriaTurmaII\Heranca\Model\{Pessoa,CPF};

abstract class Funcionario extends Pessoa
{

    public function __construct(string $nome, CPF $cpf, private float $salario)
    {
        parent::__construct($nome,$cpf);
    }

    public function alteraNome($nome): void
    {
        $this->validaNome($nome);
        $this->nome = $nome;
    }

    abstract public function calculaBonificacao():float;

    public function recuperaSalario()
    {
        return $this->salario;
    }

    public function recebeAumento(float $valorAumento)
    {
        if($valorAumento < 0){
           return throw new Exception('Valor deve ser positivo',403);
        }

        $this->salario += $valorAumento;
    }
}

