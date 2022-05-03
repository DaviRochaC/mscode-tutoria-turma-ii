<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model;

use MSCode\TutoriaTurmaII\Heranca\Model\Conta\CpfInvalidoException;

final class CPF
{
    public function __construct(private string $numero)
    {
        $numero = filter_var($numero, FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp' => '/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/'
            ]
        ]);

        if ($numero === false) {
            throw new CpfInvalidoException($numero);
            exit();
        }
        $this->numero = $numero;
    }

    public function recuperaNumero(): string
    {
        return $this->numero;
    }
}
