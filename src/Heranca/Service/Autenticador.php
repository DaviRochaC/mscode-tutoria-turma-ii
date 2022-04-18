<?php

namespace MSCode\TutoriaTurmaII\Heranca\Service;

use Exception;
use MSCode\TutoriaTurmaII\Heranca\Model\Autenticavel;

class Autenticador{

    public function tentaLogin(Autenticavel $autenticavel, string $senha)
    {
         if(!$autenticavel->podeAutenticar($senha)){
             return throw new Exception('Senha invalida');
         }
         echo 'Usuario logado no sistema';
    }


    
}