<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model;

interface Autenticavel
{
    public function podeAutenticar(string $senha): bool;
}
