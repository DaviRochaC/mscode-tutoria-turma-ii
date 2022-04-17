<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Funcionario;

class Desenvolvedor extends Funcionario
{

    public function sobeDeNivel():void
    {
        $this->recebeAumento($this->recuperaSalario() * 0.75);
    }

    public function calculaBonificacao(): float
    {
        return 500.0; 
    }
}
