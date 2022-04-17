<?php

namespace MSCode\TutoriaTurmaII\Heranca\Service;

use MSCode\TutoriaTurmaII\Heranca\Model\Funcionario\Funcionario;

class ControladorDeBonificacoes {

    private float $totalBonificacoes = 0;

    public function adicionaBonificacao(Funcionario $funcionario)
    {
        $this->totalBonificacoes += $funcionario->calculaBonificacao();
    }

    public function RecuperaTotalBonificacoes()
    {
      return $this->totalBonificacoes;
    }

}