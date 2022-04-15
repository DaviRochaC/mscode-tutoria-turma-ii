<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Conta;

class ContaPoupanca extends Conta
{
   
    protected function percentualTarifa():float
    {
        return 0.05;
    }
}
