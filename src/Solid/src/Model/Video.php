<?php

namespace  MSCode\TutoriaTurmaII\Solid\Model;

class Video
{

    protected bool $assistido = false;
    protected \DateInterval $duracao;

    public function __construct(protected string $nome)
    {
        $this->duracao = \DateInterval::createFromDateString('0');
    }

    public function assistir(): void
    {
        $this->assistido = true;
    }

    public function minutosDeDuracao(): int
    {
        return $this->duracao->i;
    }

    public function recuperarUrl(): string
    {
        return 'http://videos.alura.com.br/' . http_build_query(['nome' => $this->nome]);
    }
}
