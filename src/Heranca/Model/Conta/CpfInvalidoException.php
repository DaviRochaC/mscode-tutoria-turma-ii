<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Conta;


class CpfInvalidoException extends \DomainException{

    public function __construct( string $numeroCpfInvalido)
    {
        $mensagem = "O CPF informado:$numeroCpfInvalido nao atende ao formato XXX.XXX.XXX-XX";
        parent::__construct($mensagem);
    }
}