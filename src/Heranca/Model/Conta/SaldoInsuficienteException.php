<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Conta;


class SaldoInsuficienteException extends \DomainException{

    public function __construct(float $valorSaque, float $saldoAtual)
    {
        $mensagem = "Voce tentou sacar:$valorSaque, mas tem apenas $saldoAtual em conta.";

        parent::__construct($mensagem);
    }
}