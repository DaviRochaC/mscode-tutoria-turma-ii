<?php

namespace MSCode\TutoriaTurmaII\TreinamentoTestes\Model;

class Leilao
{
    /**
     *  @var array<int,Lance>
     */
    private array $lances;

    public function __construct(private string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        $this->lances[] = $lance;
    }

    public function getLances(): array
    {
        return $this->lances;
    }
}
