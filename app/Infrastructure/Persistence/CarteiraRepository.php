<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Carteira;
use App\Domain\Repositories\CarteiraRepositoryInterface;
use App\Infrastructure\Persistence\Models\CarteiraModel;
use App\Infrastructure\Persistence\Models\TransacaoModel;
use Illuminate\Support\Facades\Auth;


class CarteiraRepository implements CarteiraRepositoryInterface
{
  public function findById(int $id): ?Carteira
  {
    $model = CarteiraModel::find($id);
    return $model ? $this->mapToEntity($model) : null;
  }

  public function findAll(): array
  {
    return CarteiraModel::all()
      ->map(fn($model) => $this->mapToEntity($model))
      ->toArray();
  }

  public function save(Carteira $carteira): void
  {
    $model = $carteira->getId() ? CarteiraModel::find($carteira->getId()) : new CarteiraModel();
    if (!$carteira->getId()) {
      $model->user_id = Auth::id();
    }
    $model->nome = $carteira->getNome();
    $model->descricao = $carteira->getDescricao();
    $model->save();
  }

  public function delete(int $id): void
  {
    $model = CarteiraModel::find($id);
    if ($model) {
      $model->delete();
    }
  }
  public function findByUserId(int $userId): array
  {
    return CarteiraModel::where('user_id', $userId)
      ->get()
      ->map(fn($model) => $this->mapToEntity($model))
      ->toArray();
  }

  public function findByIdAndUserId(int $id, int $userId): ?Carteira
  {
    $model = CarteiraModel::where('id', $id)
      ->where('user_id', $userId)
      ->first();

    if (!$model) return null;

    return new Carteira(
      $model->id,
      $userId,
      $model->nome,
      $model->descricao
    );
  }

  private function mapToEntity(CarteiraModel $model): Carteira
  {
    return new Carteira(
      $model->id,
      $model->user_id,
      $model->nome,
      $model->descricao
    );
  }

  public function restore(int $id): void
  {
    $model = CarteiraModel::withTrashed()->find($id);
    if ($model && $model->trashed()) {
      $model->restore();
    }
  }

  public function calcularEvolucaoCarteira(int $carteiraId): array
  {
    $resultados = TransacaoModel::query()
      ->selectRaw("DATE_FORMAT(`data`, '%Y-%m') as mes_ano")
      ->selectRaw('SUM(quantidade * preco_unitario) as valor_total')
      ->where('wallet_id', $carteiraId)
      ->whereNull('deleted_at')
      ->groupBy('mes_ano')
      ->orderByRaw('MIN(`data`) ASC')
      ->get()
      ->keyBy('mes_ano');

    if ($resultados->isEmpty()) {
      return [];
    }

    $primeiroMes = \Carbon\Carbon::createFromFormat('Y-m', $resultados->keys()->first())->startOfMonth();
    $ultimoMes = \Carbon\Carbon::now()->startOfMonth(); // ou ->keys()->last() se não quiser ir até o mês atual

    $evolucao = [];
    $acumulado = 0;
    $cursor = $primeiroMes->copy();

    while ($cursor <= $ultimoMes) {
      $chave = $cursor->format('Y-m');

      if (isset($resultados[$chave])) {
        $acumulado += (float) $resultados[$chave]->valor_total;
      }

      $evolucao[] = [
        'month' => $this->formatarMesAno($chave),
        'value' => round($acumulado, 2),
      ];

      $cursor->addMonth();
    }

    return $evolucao;
  }

  private function formatarMesAno(string $mesAno): string
  {
    static $meses = [
      '01' => 'Jan',
      '02' => 'Fev',
      '03' => 'Mar',
      '04' => 'Abr',
      '05' => 'Mai',
      '06' => 'Jun',
      '07' => 'Jul',
      '08' => 'Ago',
      '09' => 'Set',
      '10' => 'Out',
      '11' => 'Nov',
      '12' => 'Dez',
    ];

    [$ano, $mes] = explode('-', $mesAno);

    return $meses[$mes] . '/' . substr($ano, 2, 2);
  }
}
