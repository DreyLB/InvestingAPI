<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Popula a carteira do usuário logado com ~2 anos de histórico de um investidor
// experiente: aportes recorrentes diversificados, algumas vendas de rebalanceamento,
// dividendos, metas, rendimentos e alertas. Roda avulso (não faz parte do
// DatabaseSeeder padrão): php artisan db:seed --class=InvestidorExperienteSeeder
class InvestidorExperienteSeeder extends Seeder
{
  private Carbon $hoje;

  public function run(): void
  {
    $this->hoje = Carbon::now();

    $user = DB::table('users')->where('email', 'andreycesar02@gmail.com')->first();

    if (!$user) {
      $this->command?->error('Usuário andreycesar02@gmail.com não encontrado.');
      return;
    }

    DB::table('users')->where('id', $user->id)->update([
      'age'             => 34,
      'investorProfile' => 'moderado',
      'balance'         => 9500.00,
      'updated_at'      => $this->hoje,
    ]);

    $walletId = DB::table('wallets')->where('user_id', $user->id)->where('nome', 'Carteira Principal')->value('id');

    if (!$walletId) {
      $walletId = DB::table('wallets')->insertGetId([
        'user_id'    => $user->id,
        'nome'       => 'Carteira Principal',
        'descricao'  => 'Carteira de longo prazo: ações, FIIs, ETFs e BDRs',
        'created_at' => $this->hoje->copy()->subMonths(24),
        'updated_at' => $this->hoje,
      ]);
    }

    // ticker => [id, preço ~24 meses atrás, cotação atual (real, via Brapi), lote por aporte,
    //            nº de aportes, yield anual usado para simular dividendos, periodicidade]
    $ativos = [
      'PETR4'  => ['id' => 1,    'inicio' => 44.00,  'atual' => 41.90,  'lote' => 50,  'compras' => 7,  'yield' => 0.08,  'mensal' => false],
      'VALE3'  => ['id' => 11,   'inicio' => 58.00,  'atual' => 71.90,  'lote' => 30,  'compras' => 7,  'yield' => 0.06,  'mensal' => false],
      'ITUB4'  => ['id' => 12,   'inicio' => 29.50,  'atual' => 38.31,  'lote' => 50,  'compras' => 8,  'yield' => 0.05,  'mensal' => false],
      'BBAS3'  => ['id' => 7,    'inicio' => 26.00,  'atual' => 18.21,  'lote' => 70,  'compras' => 6,  'yield' => 0.07,  'mensal' => false],
      'WEGE3'  => ['id' => 36,   'inicio' => 40.00,  'atual' => 47.50,  'lote' => 30,  'compras' => 8,  'yield' => 0.02,  'mensal' => false],
      'ITSA4'  => ['id' => 8,    'inicio' => 9.80,   'atual' => 12.44,  'lote' => 150, 'compras' => 7,  'yield' => 0.06,  'mensal' => false],
      'HGLG11' => ['id' => 155,  'inicio' => 155.00, 'atual' => 146.10, 'lote' => 8,   'compras' => 9,  'yield' => 0.09,  'mensal' => true],
      'MXRF11' => ['id' => 167,  'inicio' => 10.30,  'atual' => 9.29,   'lote' => 150, 'compras' => 10, 'yield' => 0.10,  'mensal' => true],
      'KNRI11' => ['id' => 191,  'inicio' => 140.00, 'atual' => 150.95, 'lote' => 8,   'compras' => 8,  'yield' => 0.085, 'mensal' => true],
      'XPML11' => ['id' => 143,  'inicio' => 95.00,  'atual' => 102.72, 'lote' => 10,  'compras' => 8,  'yield' => 0.09,  'mensal' => true],
      'BOVA11' => ['id' => 1132, 'inicio' => 118.00, 'atual' => 164.15, 'lote' => 10,  'compras' => 6,  'yield' => 0.0,   'mensal' => false],
      'IVVB11' => ['id' => 1151, 'inicio' => 290.00, 'atual' => 457.00, 'lote' => 3,   'compras' => 6,  'yield' => 0.0,   'mensal' => false],
      'AAPL34' => ['id' => 1473, 'inicio' => 64.00,  'atual' => 79.29,  'lote' => 15,  'compras' => 5,  'yield' => 0.0,   'mensal' => false],
      'MSFT34' => ['id' => 1472, 'inicio' => 80.00,  'atual' => 107.79, 'lote' => 10,  'compras' => 5,  'yield' => 0.0,   'mensal' => false],
    ];

    // vendas parciais de rebalanceamento/realização de lucro — ticker => [mesesAtras, quantidade]
    $vendas = [
      'PETR4'  => ['mesesAtras' => 4, 'quantidade' => 100],
      'BOVA11' => ['mesesAtras' => 9, 'quantidade' => 20],
      'IVVB11' => ['mesesAtras' => 3, 'quantidade' => 3],
    ];

    $assetIds = collect($ativos)->pluck('id')->all();

    // idempotência: limpa apenas dados desta carteira (nunca dados de outras carteiras/usuários)
    DB::table('transactions')->where('wallet_id', $walletId)->whereIn('asset_id', $assetIds)->delete();
    DB::table('positions')->where('wallet_id', $walletId)->whereIn('asset_id', $assetIds)->delete();
    DB::table('goals')->where('wallet_id', $walletId)->delete();
    DB::table('incomes')->where('wallet_id', $walletId)->delete();
    DB::table('alerts')->where('wallet_id', $walletId)->delete();

    $dividendosInseridos = [];

    foreach ($ativos as $ticker => $cfg) {
      $eventos = [];

      foreach ($this->gerarMesesAtras($cfg['compras']) as $mesesAtras) {
        $eventos[] = ['tipo' => 'compra', 'mesesAtras' => $mesesAtras, 'quantidade' => $cfg['lote']];
      }

      if (isset($vendas[$ticker])) {
        $eventos[] = ['tipo' => 'venda', 'mesesAtras' => $vendas[$ticker]['mesesAtras'], 'quantidade' => $vendas[$ticker]['quantidade']];
      }

      // ordem cronológica: mais meses atrás primeiro
      usort($eventos, fn($a, $b) => $b['mesesAtras'] <=> $a['mesesAtras']);

      $qtd = 0.0;
      $precoMedio = 0.0;

      foreach ($eventos as $evento) {
        $data = $this->hoje->copy()->subMonths($evento['mesesAtras'])->subDays(random_int(0, 27));
        $preco = $this->precoNaEpoca($cfg['inicio'], $cfg['atual'], $evento['mesesAtras']);

        DB::table('transactions')->insert([
          'wallet_id'      => $walletId,
          'asset_id'       => $cfg['id'],
          'tipo'           => $evento['tipo'],
          'quantidade'     => $evento['quantidade'],
          'preco_unitario' => $preco,
          'data'           => $data->format('Y-m-d'),
          'created_at'     => $data,
          'updated_at'     => $data,
        ]);

        if ($evento['tipo'] === 'compra') {
          $totalAtual = $qtd * $precoMedio;
          $totalNovo  = $evento['quantidade'] * $preco;
          $qtd += $evento['quantidade'];
          $precoMedio = $qtd > 0 ? ($totalAtual + $totalNovo) / $qtd : 0;
        } else {
          $qtd -= $evento['quantidade'];
        }
      }

      DB::table('positions')->insert([
        'wallet_id'   => $walletId,
        'asset_id'    => $cfg['id'],
        'quantidade'  => $qtd,
        'preco_medio' => round($precoMedio, 8),
        'valor_total' => round($qtd * $precoMedio, 8),
        'created_at'  => $this->hoje->copy()->subMonths(24),
        'updated_at'  => $this->hoje,
      ]);

      if ($cfg['yield'] > 0) {
        $numPagamentos = $cfg['mensal'] ? 18 : 8;
        $divisor       = $cfg['mensal'] ? 12 : 4;
        $valorPorPagamento = round(($qtd * $precoMedio * $cfg['yield']) / $divisor, 2);

        foreach ($this->gerarMesesAtras($numPagamentos, 20, 1) as $mesesAtras) {
          $data = $this->hoje->copy()->subMonths($mesesAtras)->subDays(random_int(0, 5));

          DB::table('dividends')->insert([
            'asset_id'   => $cfg['id'],
            'valor'      => $valorPorPagamento,
            'data'       => $data->format('Y-m-d'),
            'created_at' => $data,
            'updated_at' => $data,
          ]);

          $dividendosInseridos[] = ['data' => $data, 'valor' => $valorPorPagamento];
        }
      }
    }

    // RENDIMENTOS agregados a partir dos dividendos gerados
    $inicioUltimoMes = $this->hoje->copy()->subMonthNoOverflow()->startOfMonth();
    $fimUltimoMes    = $this->hoje->copy()->subMonthNoOverflow()->endOfMonth();

    $totalUltimoMes = collect($dividendosInseridos)
      ->filter(fn($d) => $d['data']->between($inicioUltimoMes, $fimUltimoMes))
      ->sum('valor');

    $inicioUltimoAno = $this->hoje->copy()->subYear();
    $totalUltimoAno = collect($dividendosInseridos)
      ->filter(fn($d) => $d['data']->greaterThanOrEqualTo($inicioUltimoAno))
      ->sum('valor');

    DB::table('incomes')->insert([
      [
        'wallet_id'   => $walletId,
        'rendimento'  => 'mensal',
        'valor'       => round($totalUltimoMes, 2),
        'periodo_ini' => $inicioUltimoMes->format('Y-m-d'),
        'periodo_fim' => $fimUltimoMes->format('Y-m-d'),
        'created_at'  => $this->hoje,
        'updated_at'  => $this->hoje,
      ],
      [
        'wallet_id'   => $walletId,
        'rendimento'  => 'anual',
        'valor'       => round($totalUltimoAno, 2),
        'periodo_ini' => $inicioUltimoAno->format('Y-m-d'),
        'periodo_fim' => $this->hoje->format('Y-m-d'),
        'created_at'  => $this->hoje,
        'updated_at'  => $this->hoje,
      ],
    ]);

    // METAS
    DB::table('goals')->insert([
      [
        'wallet_id'   => $walletId,
        'nome'        => 'Reserva de emergência',
        'descricao'   => 'Manter o equivalente a 6 meses de despesas em ativos líquidos.',
        'valor'       => 30000.00,
        'data_limite' => $this->hoje->copy()->addMonths(4)->format('Y-m-d'),
        'created_at'  => $this->hoje->copy()->subMonths(20),
        'updated_at'  => $this->hoje,
      ],
      [
        'wallet_id'   => $walletId,
        'nome'        => 'Independência financeira',
        'descricao'   => 'Atingir R$ 1.000.000,00 em patrimônio investido.',
        'valor'       => 1000000.00,
        'data_limite' => $this->hoje->copy()->addYears(8)->format('Y-m-d'),
        'created_at'  => $this->hoje->copy()->subMonths(24),
        'updated_at'  => $this->hoje,
      ],
    ]);

    // ALERTAS
    DB::table('alerts')->insert([
      [
        'wallet_id'  => $walletId,
        'tipo'       => 'dividendo',
        'mensagem'   => 'Você recebeu dividendos de HGLG11 este mês.',
        'data'       => $this->hoje->copy()->subDays(6)->format('Y-m-d'),
        'lido'       => true,
        'created_at' => $this->hoje->copy()->subDays(6),
        'updated_at' => $this->hoje->copy()->subDays(6),
      ],
      [
        'wallet_id'  => $walletId,
        'tipo'       => 'preco',
        'mensagem'   => 'IVVB11 atingiu uma nova máxima nos últimos 12 meses.',
        'data'       => $this->hoje->copy()->subDays(2)->format('Y-m-d'),
        'lido'       => false,
        'created_at' => $this->hoje->copy()->subDays(2),
        'updated_at' => $this->hoje->copy()->subDays(2),
      ],
      [
        'wallet_id'  => $walletId,
        'tipo'       => 'meta',
        'mensagem'   => 'Você está a 70% da meta "Reserva de emergência".',
        'data'       => $this->hoje->format('Y-m-d'),
        'lido'       => false,
        'created_at' => $this->hoje,
        'updated_at' => $this->hoje,
      ],
    ]);

    $this->command?->info("Carteira #{$walletId} populada com histórico de investidor experiente.");
  }

  private function gerarMesesAtras(int $quantidade, int $max = 23, int $min = 1): array
  {
    if ($quantidade <= 1) {
      return [$max];
    }

    $meses = [];
    $intervalo = ($max - $min) / ($quantidade - 1);

    for ($i = 0; $i < $quantidade; $i++) {
      $meses[] = (int) round($max - $i * $intervalo);
    }

    return $meses;
  }

  private function precoNaEpoca(float $inicio, float $atual, int $mesesAtras): float
  {
    $progresso = 1 - ($mesesAtras / 24);
    $base = $inicio + ($atual - $inicio) * $progresso;
    $ruido = $base * (random_int(-5, 5) / 100);

    return round(max(0.01, $base + $ruido), 2);
  }
}
