<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Conta;

use MSCode\TutoriaTurmaII\Heranca\Model\{Pessoa,CPF,Endereco};

class Titular extends Pessoa
{

    public function __construct(string $nome, CPF $cpf, private Endereco $endereco)
    {
        parent::__construct($nome, $cpf);
    }



    public function recuperaEndereco(): Endereco
    {
        return $this->endereco;
    }

    
}
