<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model;

class Endereco
{

    public function __construct(private string $cidade, private string $bairro,  private string $rua, private string $numero)
    {
    }

    


}