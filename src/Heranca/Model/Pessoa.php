<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model;

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
            throw new \InvalidArgumentException('O atributo nome precisa ter pelo menos 5 caracteres');
            exit();
        }
    }


}
