<?php

namespace MSCode\TutoriaTurmaII\Solid\Model;

use MSCode\TutoriaTurmaII\Solid\Model\Pontuavel;
use MSCode\TutoriaTurmaII\Solid\Model\Assistivel;

class Assistidor
{
    public function assisteCurso(Assistivel $conteudo)
    {
       $conteudo->assistir();
    }

   
}
