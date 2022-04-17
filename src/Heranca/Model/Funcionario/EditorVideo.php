<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Funcionario;
use MSCode\TutoriaTurmaII\Heranca\Model\Funcionario\Funcionario;

class EditorVideo extends Funcionario{

public function calculaBonificacao():float
{
   return 600;
}

}