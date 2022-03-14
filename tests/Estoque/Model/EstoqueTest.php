<?php

namespace MSCode\TutoriaTurmaII\Tests\Estoque\Model;

use Exception;
use MSCode\TutoriaTurmaII\Estoque\Model\{Estoque, Produto, Filial};
use PHPUnit\Framework\TestCase;


/**
 * @covers  MSCode\TutoriaTurmaII\Estoque\Model\Estoque
 */
class EstoqueTest extends TestCase
{

    public function testNaoPodeExistirEntradasNegativas()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor negativo nao permitido');
        $produto = new Produto(1, 'vostroDell', 'cinza');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, -2);
    }

    public function testEntrarComProdutoQueNaoExisteEVerificarSuaQuantidade()
    {
        $produto = new Produto(1, 'vostroDell', 'cinza');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $this->assertEquals(50, $estoque->getQuantidadeProduto($produto->getCodigo()));
    }

    public function testEntrarComProdutoqueJáExisteEVerificarSuaQuantidadeFoiSomada()
    {
        $produto = new Produto(1, 'vostroDell', 'cinza');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 3);
        $estoque->entrar($produto, 97);
        $this->assertEquals(100, $estoque->getQuantidadeProduto($produto->getCodigo()));
    }


    public function testNaoPodePassarUmValorDeReservaNegativo()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor negativo nao permitido');
        $produto = new Produto(500, 'Mesa', 'branca');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $estoque->reservar($produto, -5);
    }

    public function testNaoPodeReservarUmProdutoMaisDoqueSuaQuantidadeDisponivel()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Quantidade indisponivel');
        $produto = new Produto(500, 'Mesa', 'branca');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $estoque->reservar($produto, 100);
    }

    public function testNaoPodeReservadaUmProdutoSemRealizarSuaEntradaPrimeiro()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Produto nao encontrado, entre com o produto em estoque primeiramente');
        $produto = new Produto(501, 'Mesa', 'preta');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->reservar($produto, 1);
    }

    public function testVerificarSeUmaReservaFoiEfetuadaDeFato()
    {
        $produto = new Produto(502, 'Cadeira', 'branca');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $reserva = $estoque->reservar($produto, 30);
        $this->assertEquals(30, $estoque->buscarQuantidadeReservaEspecifica(explode('#', $reserva)[0], explode('#', $reserva)[1]));
    }

    public function testEfetivarReservaCorretamente()
    {
        $produto = new Produto(502, 'Cadeira', 'branca');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $reserva = $estoque->reservar($produto, 49);
        $estoque->efetivarReserva($reserva);
        $this->assertEquals(1, $estoque->quantidadeProdutoDisponivel($produto->getCodigo()));
    }

    public function testEfetivarReservaPassandoIdenficadorInexistenteSemHashtag()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Identificador de reserva inválido, tente novamente');
        $produto = new Produto(502, 'Ventilador', 'Cinza');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $estoque->reservar($produto, 30);
        $estoque->efetivarReserva('sadjiasdjias');
    }

    public function testEfetivarReservaPassandoIdenficadorInexistenteComHashtagEcomProdutoNaoidentificavel()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Produto nao encontrado com a reserva informada, entre com o produto em estoque primeiramente');
        $produto = new Produto(502, 'Ventilador', 'Cinza');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $estoque->reservar($produto, 30);
        $estoque->efetivarReserva('ads#sadjiasdjias');
    }

    public function testEfetivarReservaPassandoIdenficadorInexistenteComHashtagEcomProdutoidentificavel()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Nenhuma reserva encontrada através do identificador informado');
        $produto = new Produto(502, 'Ventilador', 'Cinza');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $estoque->reservar($produto, 30);
        $estoque->efetivarReserva('502#sadjiasdjias');
    }

    public function testSairCorretamente()
    {

        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 40);
        $estoque->reservar($produto, 10);
        $estoque->sair($produto->getCodigo(), 30);
        $this->assertEquals(0, $estoque->quantidadeProdutoDisponivel($produto->getCodigo()));
    }

    public function testNaoPodeSairMaisDoqueExisteEmEstoque()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor a sair é maior do que apresenta em estoque');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 40);
        $estoque->reservar($produto, 10);
        $estoque->sair($produto->getCodigo(), 32);
    }

    public function testNaoPodeSairComValorDeSaidaNegativo()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor negativo nao permitido');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 40);
        $estoque->sair($produto->getCodigo(), -50);
    }

    public function testNaoPodeSairSeOProdutoNaofoiIdentifcadoPeloCodigo()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Produto não encontrado pelo codigo informado, entre com o produto em estoque primeiramente');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 40);
        $estoque->reservar($produto, 10);
        $estoque->sair(114, 30);
    }

    public function testNaoPodeTransferirComValorDeTransferenciaNegativo()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor negativo nao permitido');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $filial2 = new Filial(01, 'Pinheiros');
        $estoque1 = new Estoque($filial);
        $estoque2 = new Estoque($filial2);
        $estoque1->entrar($produto, 40);
        $estoque1->transferir($produto, -10, $estoque2);
    }

    public function testNaoPodeTransferirQuantidadeDeProdutoMaiorQueDisponivelEmEstoque()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor a sair é maior do que apresenta em estoque');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $filial2 = new Filial(01, 'Pinheiros');
        $estoque1 = new Estoque($filial);
        $estoque2 = new Estoque($filial2);
        $estoque1->entrar($produto, 40);
        $estoque1->reservar($produto, 31);
        $estoque1->transferir($produto, 10, $estoque2);
    }

    public function testNaoPodeTransferirParaMesmaFilial()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Nao é possivel transferir o produto solicitado para a mesma filial em que o mesmo já se encontra');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque1 = new Estoque($filial);
        $estoque1->entrar($produto, 40);
        $estoque1->transferir($produto, 10, $estoque1);
    }

    public function testNaoPodeTransferirSeOProdutoNaoforIdentificadoNoEstoqueDoQualSaira()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Produto não encontrado pelo codigo informado, entre com o produto em estoque primeiramente');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $produto2 = new Produto(05, 'roteador', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $filial2 = new Filial(01, 'Pinheiros');
        $estoque1 = new Estoque($filial);
        $estoque2 = new Estoque($filial2);
        $estoque1->entrar($produto, 40);
        $estoque1->transferir($produto2, 10, $estoque2);
    }


    public function testVerificacaoSeATransferenciaDeFatoAconteceCorretamente()
    {
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $filial2 = new Filial(01, 'Pinheiros');
        $estoque1 = new Estoque($filial);
        $estoque2 = new Estoque($filial2);
        $estoque1->entrar($produto, 40);
        $estoque1->transferir($produto, 10, $estoque2);
        $this->assertEquals(30, $estoque1->quantidadeProdutoDisponivel($produto->getCodigo()));
        $this->assertEquals(10, $estoque2->quantidadeProdutoDisponivel($produto->getCodigo()));
    }


    public function testgetQuantidadeProdutoEstafuncionandoCorretamente()
    {
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $this->assertEquals(50, $estoque->getQuantidadeProduto($produto->getCodigo()));
    }


    public function testQuantidadeProdutoDisponivelEstafuncionandoCorretamente()
    {
        $produto = new Produto(500, 'Mesa de Jantar', 'Branco');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 50);
        $reserva1 = $estoque->reservar($produto, 40);
        $reserva2 = $estoque->reservar($produto, 5);
        $estoque->efetivarReserva($reserva1);
        $estoque->entrar($produto, 50);
        $estoque->efetivarReserva($reserva2);
        $this->assertEquals(55, $estoque->quantidadeProdutoDisponivel($produto->getCodigo()));
    }

    public function testAdicionarProdutoEmEstoque()
    {
        $produto = new Produto(500, 'Mesa de Jantar', 'Branco');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->adicionarProdutoAoEstoque($produto->getCodigo(), 5);
        $this->assertEquals(5, $estoque->getQuantidadeProduto($produto->getCodigo()));
    }


    public function testBuscandoProdutoQueNaoExisteEmEstoque()
    {
        $produto = new Produto(500, 'Mesa de Jantar', 'Branco');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $busca = $estoque->buscaProdutoExisteEmEstoque($produto->getCodigo());
        $this->assertEquals(false, $busca);
    }

    public function testBuscandoProdutoQueExisteEmEstoque()
    {
        $produto = new Produto(500, 'Escrevaninha', 'Rosa');
        $filial = new Filial(02, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 25);
        $busca = $estoque->buscaProdutoExisteEmEstoque($produto->getCodigo());
        $this->assertEquals(true, $busca);
    }

    public function testVerificandoSeUmValorENegativo()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor negativo nao permitido');
        $filial = new Filial(02, 'Matriz Pinheiros');
        $estoque = new Estoque($filial);
        $estoque->verificaQuantidadeNegativa(-1);
    }


    public function testBuscandoQuantidadeDeReservaEspecificaQueNaoExiste()
    {

        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 2);
        $this->assertEquals(false, $estoque->buscarQuantidadeReservaEspecifica(500, 'adasdadsa'));
    }

    public function testBuscandoQuantidadeDeReservaEspecificaQueExiste()
    {

        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $estoque = new Estoque($filial);
        $estoque->entrar($produto, 2);
        $reserva = $estoque->reservar($produto, 1);
        $this->assertEquals(1, $estoque->buscarQuantidadeReservaEspecifica(explode('#', $reserva)[0], explode('#', $reserva)[1]));
    }
}
