<?php

namespace MSCode\TutoriaTurmaII\Estoque\Model;

use \Exception;

class Estoque
{

    private array $produtos = [];
    private array $reservas = [];

    public function __construct(private Filial $filial)
    {
    }



    public function entrar(Produto $produto, int $quantidadeEntrada): void
    {
        $this->verificaQuantidadeNegativa($quantidadeEntrada);

        if ($this->buscaProdutoExisteEmEstoque($produto->getCodigo())) {
            $this->produtos[$produto->getCodigo()] += $quantidadeEntrada;
        } else {
            $this->adicionarProdutoAoEstoque($produto->getCodigo(), $quantidadeEntrada);
            $this->reservas[$produto->getCodigo()] = [0];
        }
    }

    public function reservar(Produto $produto, int $quantidadeAReservar): string
    {
        $this->verificaQuantidadeNegativa($quantidadeAReservar);

        if (!$this->buscaProdutoExisteEmEstoque($produto->getCodigo())) {
            throw new Exception('Produto nao encontrado, entre com o produto em estoque primeiramente', 404);
        }

        if ($quantidadeAReservar > $this->quantidadeProdutoDisponivel($produto->getCodigo())) {
            return throw new Exception('Quantidade indisponivel', 403);
        }

        $identificadorinicialReserva = md5(uniqid());
        $identificadorFinaldaReserva = $produto->getCodigo() . '#' . $identificadorinicialReserva;

        $this->reservas[$produto->getCodigo()][$identificadorinicialReserva] = $quantidadeAReservar;

        return $identificadorFinaldaReserva;
    }

    public function efetivarReserva(string $identificadorReserva): void
    {

        if (!str_contains($identificadorReserva, '#')) {
            throw new Exception('Identificador de reserva inválido, tente novamente', 403);
        }

        $codigoProduto = explode('#', $identificadorReserva)[0];
        $reservaid = explode('#', $identificadorReserva)[1];

        if (!$this->buscaProdutoExisteEmEstoque($codigoProduto)) {
            throw new Exception('Produto nao encontrado com a reserva informada, entre com o produto em estoque primeiramente', 404);
        }

        if (!$this->buscarQuantidadeReservaEspecifica($codigoProduto,$reservaid)) {

            
            throw new Exception('Nenhuma reserva encontrada através do identificador informado', 404);
        }

        $quantidadedeSaida = $this->buscarQuantidadeReservaEspecifica($codigoProduto,$reservaid);

        unset($this->reservas[$codigoProduto][$reservaid]);

        $this->sair($codigoProduto, $quantidadedeSaida);
    }


    public function sair(int $codigoProduto, int $quantidadeDeSaida): void
    {

        $this->verificaQuantidadeNegativa($quantidadeDeSaida);

        if (!$this->buscaProdutoExisteEmEstoque($codigoProduto)) {
            throw new Exception('Produto não encontrado pelo codigo informado, entre com o produto em estoque primeiramente', 404);
        }

        if ($this->quantidadeProdutoDisponivel($codigoProduto) < $quantidadeDeSaida) {
            throw new Exception('Valor a sair é maior do que apresenta em estoque', 403);
        }

        $this->produtos[$codigoProduto] -= $quantidadeDeSaida;
    }


    public function  transferir(Produto $produto, int $quantidadeTransferencia, Estoque $estoque): void
    {
        
        if($estoque->getFilial() == $this->getFilial()){
            throw new Exception('Nao é possivel transferir o produto solicitado para a mesma filial em que o mesmo já se encontra', 403);
            
        }
        $this->sair($produto->getCodigo(),$quantidadeTransferencia);

        $estoque->entrar($produto, $quantidadeTransferencia);
    }

    public function getQuantidadeProduto(int $codigoProduto): int
    {
        return $this->produtos[$codigoProduto];
    }

    public function quantidadeProdutoDisponivel(int $codigoProduto): int
    {
        return $this->getQuantidadeProduto($codigoProduto) - array_sum($this->reservas[$codigoProduto]);
    }


    public function adicionarProdutoAoEstoque(int $codigoProduto, int $quantidade): void
    {
        $this->produtos[$codigoProduto] = $quantidade;
    }

    public function buscaProdutoExisteEmEstoque(mixed $codigoProduto): bool
    {
        if (!array_key_exists($codigoProduto, $this->produtos)) {
            return false;
        }

        return true;
    }

    public function todosProdutos(): array
    {
        return $this->produtos;
    }

    public function todasReservas(): array
    {
        return $this->reservas;
    }

    public function verificaQuantidadeNegativa($quantidade): void
    {
        if ($quantidade <= 0) {
            throw new Exception('Valor negativo nao permitido', 403);
        }
    }

    public function buscarQuantidadeReservaEspecifica($codigoProduto,$reservaid):int | bool
    {

        if (!array_key_exists($reservaid, $this->reservas[$codigoProduto])) {
           return false;
        }

      return $this->reservas[$codigoProduto][$reservaid];
    }

    public function getFilial()
    {
       return $this->filial->getCodigo();
    }
}
