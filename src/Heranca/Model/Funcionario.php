<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model;

class Funcionario extends Pessoa
{

    public function __construct(string $nome, CPF $cpf, private string $cargo)
    {
        parent::__construct($nome,$cpf);
    }

    public function alteraNome($nome): void
    {
        $this->validaNome($nome);
        $this->nome = $nome;
    }
}

