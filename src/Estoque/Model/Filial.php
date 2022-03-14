<?php

namespace MSCode\TutoriaTurmaII\Estoque\Model;

class Filial
{

    public function __construct(private int $codigo, public string $descricao)
    {
    }


    public function getCodigo()
    {
        return $this->codigo;
    }



}
