<?php

namespace MSCode\TutoriaTurmaII\Tests\Estoque\Model;

use Exception;
use MSCode\TutoriaTurmaII\Estoque\Model\{ItemEstoque, Produto, Filial};
use PHPUnit\Framework\TestCase;

/**
 * @covers  MSCode\TutoriaTurmaII\Estoque\Model\ItemEstoque
 */
class ItemEstoqueTest extends TestCase
{

    public function testNaoPodeExistirEntradasNegativas()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor de entrada nao permitido');
        $produto = new Produto(1, 'vostroDell', 'cinza');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $itemEstoque = new ItemEstoque($produto, $filial);
        $itemEstoque->entrar(-2);
    }


    public function testNaoPodeReservarMaisDoqueAquantidadeDisponivel()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Quantidade indisponivel');
        $produto = new Produto(500, 'Mesa', 'branca');
        $filial = new Filial(01, 'Matriz Pinheiros');
        $itemEstoque = new ItemEstoque($produto, $filial);
        $itemEstoque->entrar(50);
        $itemEstoque->reservar(100);
    }

    public function testNaoPodeSairMaisDoqueExisteEmEstoque()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor de saída é maior do que apresenta em estoque');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $itemEstoque = new ItemEstoque($produto, $filial);
        $itemEstoque->entrar(40);
        $itemEstoque->reservar(10);
        $itemEstoque->sair(32);
    }

    public function testLançarExceptionQuandoNaoIdenficarReserva()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Nenhuma reserva encontrada através do indentificador informado');
        $produto = new Produto(500, 'Guarda Roupa', 'Cinza');
        $filial = new Filial(02, 'Sao Mateus');
        $itemEstoque = new ItemEstoque($produto, $filial);
        $itemEstoque->entrar(40);
        $itemEstoque->reservar(10);
       $itemEstoque->efetivarReserva('sadsadsa');
    }
}
