<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model;

use \Exception;
abstract class Pessoa 
{

    public function __construct(protected string $nome,private CPF $cpf)
    {
       $this->validaNome($nome);
    }

    public function recuperaCpf(): string
    {
        return $this->cpf->recuperaNumero();
    }

    public function recuperaNome(): string
    {
        return $this->nome;
    }

    protected function validaNome(string $nome)
    {
        if (strlen($nome) < 5) {
            return throw new Exception('Nome precisa ter pelo menos 5 caracteres', 403);
            exit();
        }
    }


}
