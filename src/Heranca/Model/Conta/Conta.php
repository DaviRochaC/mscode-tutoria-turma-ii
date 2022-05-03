<?php

namespace MSCode\TutoriaTurmaII\Heranca\Model\Conta;


abstract class Conta
{
    protected int $saldo;
    private static int $numeroDeContas = 0;

    public function __construct(private Titular $titular)
    {
        $this->titular = $titular;
        $this->saldo = 0;

        self::$numeroDeContas++;
    }

    public function __destruct()
    {
        self::$numeroDeContas--;
    }

    public function saca(float $valorASacar): void
    {
       
        $tarifaSaque = $valorASacar * $this->percentualTarifa();
        $valorSaque  = $valorASacar + $tarifaSaque;

        if ($valorSaque > $this->saldo) {
            throw new SaldoInsuficienteException($valorSaque,$this->saldo);
            return;
        }
        $this->saldo -= $valorSaque;
    }

    public function deposita(float $valorADepositar): void
    {
        if ($valorADepositar < 0) {
            throw new \InvalidArgumentException('Valor precisa ser positivo');
            return;
        }

        $this->saldo += $valorADepositar;
    }

    

    public function recuperaSaldo(): float
    {
        return $this->saldo;
    }

    public function recuperaNomeTitular(): string
    {
        return $this->titular->recuperaNome();
    }

    public function recuperaCpfTitular(): string
    {
        return $this->titular->recuperaCpf();
    }

    public static function recuperaNumeroDeContas(): int
    {
        return self::$numeroDeContas;
    }

    abstract protected function percentualTarifa():float;
}
