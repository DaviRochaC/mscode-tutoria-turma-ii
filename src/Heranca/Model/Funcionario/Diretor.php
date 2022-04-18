<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Funcionario;

use MSCode\TutoriaTurmaII\Heranca\Model\Autenticavel;

class Diretor extends Funcionario implements Autenticavel
{

    public function calculaBonificacao(): float
    {
        return $this->recuperaSalario() * 2;
    }

    public function podeAutenticar(string $senha): bool
    {
        return $senha === '4321';
    }
}
