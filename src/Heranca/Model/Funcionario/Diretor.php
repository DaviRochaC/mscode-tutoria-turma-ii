<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Funcionario;

class Diretor extends Funcionario
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
