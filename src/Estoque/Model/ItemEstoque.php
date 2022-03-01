<?php

namespace MSCode\TutoriaTurmaII\Estoque\Model;

use \Exception;


class ItemEstoque


{

    private int $quantidade = 0;
    private array $reservas = [];

    public function __construct(private Produto $produto, private Filial $filial)
    {
    }

    public function entrar(int $quantidadeEntrada): void
    {


        if ($quantidadeEntrada <= 0) {
            throw new Exception('Valor de entrada nao permitido', 403);
        }


        $this->quantidade += $quantidadeEntrada;
    }

    public function sair(int $quantidadeDeSaida): void
    {

        if ($this->quantidadeDisponivel() < $quantidadeDeSaida) {
            throw new Exception('Valor de saída é maior do que apresenta em estoque', 403);
        }

        $this->quantidade -= $quantidadeDeSaida;
    }

    public function transferir(Filial $filialTransferencia,  int $quantidadeATransferir): void
    {
    }

    public function reservar(int $quantidadeAReservar)
    {
        if ($quantidadeAReservar > $this->quantidadeDisponivel()) {
            return throw new Exception('Quantidade indisponivel', 403);
        }


        $identificador = md5(uniqid());

        $this->reservas[$identificador] = $quantidadeAReservar;

        return $identificador;
    }

    public function efetivarReserva(string $identificadorReserva): void
    {
        if (!array_key_exists($identificadorReserva, $this->reservas)) {
            throw new Exception('Nenhuma reserva encontrada através do indentificador informado', 404);
        }

        $quantidadedeSaida = $this->reservas[$identificadorReserva];

        unset($this->reservas[$identificadorReserva]);

        $this->sair($quantidadedeSaida);
    }


    public function getquantidade()
    {
        return $this->quantidade;
    }

    public function quantidadeDisponivel()
    {
        return $this->getquantidade() - array_sum($this->reservas);
    }
}
