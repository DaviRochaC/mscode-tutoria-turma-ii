<?php

namespace MSCode\TutoriaTurmaII\Estoque\Model;


class Produto
{
    public function __construct(private int $codigo, public string $descricao, private string $cores)
    {
    }

    /**
     * Função que retorna o código do produto.
     * @return int
     */
    public function getCodigo():int
    {
        return $this->codigo;
    }

 

   

}
