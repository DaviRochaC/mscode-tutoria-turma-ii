<?php

namespace MSCode\TutoriaTurmaII\Solid\Model;

use  MSCode\TutoriaTurmaII\Solid\Model\Pontuavel;

class CalculadorPontuacao
{
    public function recuperarPontuacao(Pontuavel $conteudo)
    {
        return $conteudo->recuperarPontuacao();
    }
}
