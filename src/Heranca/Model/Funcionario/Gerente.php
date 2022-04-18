<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Funcionario;

use MSCode\TutoriaTurmaII\Heranca\Model\Autenticavel;

class Gerente extends Funcionario implements Autenticavel
{

    public function calculaBonificacao():float  
    {
       return $this->recuperaSalario();
    }

    public function podeAutenticar(string $senha): bool                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
    {
       return $senha === '1234';
    }

}