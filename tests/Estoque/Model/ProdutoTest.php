<?php

namespace MSCode\TutoriaTurmaII\Tests\Estoque\Model;

use Exception;
use MSCode\TutoriaTurmaII\Estoque\Model\{Estoque, Produto, Filial};
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

/**
 * @covers  MSCode\TutoriaTurmaII\Estoque\Model\Produto
 */
class ProdutoTest extends TestCase{
    
    public function testRetornoDoCodigoDoProduto()
    {

       $produto = new Produto(700,'monitor samsung','preto');
       $this->assertEquals(700,$produto->getCodigo());
       
    }
}