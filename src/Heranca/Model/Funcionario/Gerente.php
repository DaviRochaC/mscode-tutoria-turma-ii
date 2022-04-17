<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Funcionario;

class Gerente extends Funcionario
{

    public function calculaBonificacao():float  
    {
       return $this->recuperaSalario();
    }


}