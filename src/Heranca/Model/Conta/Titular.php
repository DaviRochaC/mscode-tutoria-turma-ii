<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Conta;

use MSCode\TutoriaTurmaII\Heranca\Model\{Autenticavel, Pessoa,CPF,Endereco};

class Titular extends Pessoa implements Autenticavel
{

    public function __construct(string $nome, CPF $cpf, private Endereco $endereco)
    {
        parent::__construct($nome, $cpf);
    }

    public function recuperaEndereco(): Endereco
    {
        return $this->endereco;
    }

    public function podeAutenticar(string $senha): bool
    {
        return $senha === '12345678';
    }


    
}
