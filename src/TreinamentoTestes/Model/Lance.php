<?php

namespace MSCode\TutoriaTurmaII\TreinamentoTestes\Model;

class Lance
{
    public function __construct(private Usuario $usuario, private float $valor)
    {
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    public function getValor(): float
    {
        return $this->valor;
    }
}
