<?php

namespace  MSCode\TutoriaTurmaII\Solid\Model;


class AluraMais extends Video implements Pontuavel,Assistivel
{

    public function __construct(string $nome, private string $categoria)
    {
        parent::__construct($nome);
    
    }

    public function recuperarUrl(): string
    {
        return 'http://videos.alura.com.br/' . str_replace(' ', '-', strtolower($this->categoria));
    }

    public function recuperarPontuacao(): int
    {
        return $this->minutosDeDuracao() * 2;
    }
}
