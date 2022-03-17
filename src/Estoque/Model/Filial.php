<?php

namespace MSCode\TutoriaTurmaII\Estoque\Model;

class Filial
{

    public function __construct(private int $codigo, public string $descricao)
    {
    }


     /**
     * Função que retorna o código da Filial.
     * @return int
     */
    public function getCodigo():int
    {
        return $this->codigo;
    }



}
