<?php

namespace MSCode\TutoriaTurmaII\Estoque\Model;

use \Exception;

class Estoque
{
    /**
     *$produtos - Array para armazenar os produtos e suas respectivas quantidades.
     */
    private array $produtos = [];

    /**
     *$reservas - Array para armazenar as reservas e a suas respectivas quantidades.
     */
    private array $reservas = [];

    public function __construct(private Filial $filial)
    {
    }

    /**
     * Função para efetuar a entrada de um produto no estoque da filial.
     * @param Produto $produto - Produto o qual será efetuado a entrada no estoque.
     * @param int $quantidadeEntrada - Quantidade do produto que entrará em estoque.
     */
    public function entrar(Produto $produto, int $quantidadeEntrada): void
    {
        $this->verificaQuantidadeNegativa($quantidadeEntrada);

        if ($this->buscaProdutoExisteEmEstoque($produto->getCodigo())) {
            $this->produtos[$produto->getCodigo()] += $quantidadeEntrada;
            return;
        } 
            $this->adicionarProdutoAoEstoque($produto->getCodigo(), $quantidadeEntrada);
            $this->reservas[$produto->getCodigo()] = [0];
    
    }

    /**
     * Função para efetuar uma reserva, a fim de obter determinado produto no estoque.
     * @param Produto $produto - Produto o qual será efetuada a reserva.
     * @param int $quantidadeAReservar - Quantidade do produto que será reservada em estoque.
     * @return string 
     */
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

    /**
     * Função para efetivar uma reserva, e assim realizar a saída da quantidade do produto reservado.
     * @param string $identificadorReserva - Identificador da reserva retornado ao realizar uma reserva.
     */
    public function efetivarReserva(string $identificadorReserva): void
    {
        if (!str_contains($identificadorReserva, '#')) {
            throw new Exception('Identificador de reserva inválido, tente novamente', 403);
        }

        list($codigoProduto, $reservaId) = explode('#', $identificadorReserva);

        if (!$this->buscaProdutoExisteEmEstoque($codigoProduto)) {
            throw new Exception('Produto nao encontrado com a reserva informada, entre com o produto em estoque primeiramente', 404);
        }

        if (!$this->buscarQuantidadeReservaEspecifica($codigoProduto, $reservaId)) {
            throw new Exception('Nenhuma reserva encontrada através do identificador informado', 404);
        }

        $quantidadeDeSaida = $this->buscarQuantidadeReservaEspecifica($codigoProduto, $reservaId);

        unset($this->reservas[$codigoProduto][$reservaId]);

        $this->sair($codigoProduto, $quantidadeDeSaida);
    }

    /**
     * Função para realizar a saída de determinada quantidade de um produto no estoque.
     * @param int $codigoProduto - Código do produto que sairá do estoque.
     * @param int $quantidadeDeSaida - Quantidade do produto que será retirada do estoque.
     */
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

    /**
     * Função para realizar transferências de produtos entre filiais.
     * @param Produto $produto - Produto o qual será transferido pra outra filial.
     * @param int $quantidadeTransferencia - Quantidade do produto que será transferida.
     * @param Estoque $estoque - Instância que represente o estoque que pertence a filial para qual o produto será transferido.
     */
    public function  transferir(Produto $produto, int $quantidadeTransferencia, Estoque $estoque): void
    {

        if ($estoque->getFilial() == $this->getFilial()) {
            throw new Exception('Nao é possivel transferir o produto solicitado para a mesma filial em que o mesmo já se encontra', 403);
        }
        $this->sair($produto->getCodigo(), $quantidadeTransferencia);

        $estoque->entrar($produto, $quantidadeTransferencia);
    }

    /**
     * Função que retorna a quantidade física de um produto em estoque.
     * @param int $codigoProduto - Código do produto o qual deseja descobrir a quantidade física.
     * @return int
     */
    public function getQuantidadeProduto(int $codigoProduto): int
    {
        return $this->produtos[$codigoProduto];
    }

    /**
     * Função que retorna a quantidade disponível de um produto no estoque. A quantidade disponível é a diferença entre a quantidade física de um produto e a soma da quantidade de todas as reservas do mesmo.
     * @param int $codigoProduto - Código do produto o qual deseja descobrir a quantidade disponível.
     * @return int
     */
    public function quantidadeProdutoDisponivel(int $codigoProduto): int
    {
        return $this->getQuantidadeProduto($codigoProduto) - array_sum($this->reservas[$codigoProduto]);
    }

    /**
     * Função para adicionar um produto no estoque.
     * @param int $codigoProduto - Código do produto que será adicionado.
     * @param int $quantidade - Quantidade do produto que será adicionado.
     */
    public function adicionarProdutoAoEstoque(int $codigoProduto, int $quantidade): void
    {
        $this->produtos[$codigoProduto] = $quantidade;
    }

    /**
     * Função que verifica se há determinado produto no estoque.
     * @param mixed $codigoProduto - Código do produto que será verificado.
     * @return bool 
     */
    public function buscaProdutoExisteEmEstoque(mixed $codigoProduto): bool
    {
        return array_key_exists($codigoProduto, $this->produtos);
    }

    /**
     * Função que retorna todos os produtos presentes no array de produtos e suas respectivas quantidades.
     * @return array
     */
    public function todosProdutos(): array
    {
        return $this->produtos;
    }

    /**
     * Função que retorna todas reservas presentes no array de reservas.
     * @return array
     */
    public function todasReservas(): array
    {
        return $this->reservas;
    }

        /**
     * Função que verifica se uma quantidade é maior que zero.
     * @param int $quantidade - Quantidade a ser verificada.
     */
    public function verificaQuantidadeNegativa(int $quantidade): void
    {
        if ($quantidade <= 0) {
            throw new Exception('Valor negativo nao permitido', 403);
        }
    }

    /**
     * Função que retorna a quantidade de uma reserva especifíca.
     * @param mixed  $codigoProduto - Código do produto que foi reservado.
     * @param string $reservaid - Identificador inicial da reserva.
     * @return int|bool
     */
    public function buscarQuantidadeReservaEspecifica(mixed $codigoProduto, string $reservaid): int | bool
    {

        if (!array_key_exists($reservaid, $this->reservas[$codigoProduto])) {
            return false;
        }

        return $this->reservas[$codigoProduto][$reservaid];
    }

    /**
     * Função que retorna o código da filial vinculada ao estoque em questão.
     * @return int 
     */
    public function getFilial(): int
    {
        return $this->filial->getCodigo();
    }
}
