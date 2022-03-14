<?php

namespace MSCode\TutoriaTurmaII\Tests\Estoque\Model;

use Exception;
use MSCode\TutoriaTurmaII\Estoque\Model\{Estoque, Produto, Filial};
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

/**
 * @covers  MSCode\TutoriaTurmaII\Estoque\Model\Filial
 */
class FilialTest extends TestCase{


    public function testRetornoDoCodigoDaFilial()
    {

       $filial = new Filial(003,'Loja de Sao Mateus');
       $this->assertEquals(003,$filial->getCodigo());
       
    }
}