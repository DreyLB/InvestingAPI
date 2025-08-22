<?php

namespace App\Application\Services;

use App\Domain\Entities\Ativo;
use App\Infrastructure\Persistence\AtivoRepository;
use App\Infrastructure\Persistence\CarteiraRepository; // você deve ter este repo
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DateTime;
use SebastianBergmann\Type\NullType;

class AtivoService
{
    public function __construct(
        private AtivoRepository $ativoRepository,
        private CarteiraRepository $carteiraRepository
    ) {}

    private function assertCarteiraDoUsuario(int $carteiraId, int $userId): void
    {
        if (! $this->carteiraRepository->findByIdAndUserId($carteiraId, $userId)) {
            throw new ModelNotFoundException('Carteira não encontrada ou não pertence ao usuário.');
        }
    }

    public function listarAtivos(int $carteiraId): array
    {
        $userId = (int) Auth::id();
        $this->assertCarteiraDoUsuario($carteiraId, $userId);

        return $this->ativoRepository->listarPorCarteira($carteiraId);
    }

    public function buscarAtivo(int $carteiraId, int $ativoId): Ativo
    {
        $userId = (int) Auth::id();
        $this->assertCarteiraDoUsuario($carteiraId, $userId);

        $ativo = $this->ativoRepository->findByIdAndCarteira($ativoId, $carteiraId);
        if (! $ativo) {
            throw new ModelNotFoundException('Ativo não encontrado na carteira informada.');
        }

        return $ativo;
    }

    public function criarAtivo(int $carteiraId, array $dados): Ativo
    {
        $userId = (int) Auth::id();
        $this->assertCarteiraDoUsuario($carteiraId, $userId);

        $agora = new DateTime();

        // novo Ativo: id=0 (falso) para o repo entender como INSERT
        $ativo = new Ativo(
            null,
            $carteiraId,
            null,
            $dados['name'],
            (int) $dados['asset_type_id'],
            (float) $dados['quantity'],
            (float) $dados['price'],
            (float) $dados['average_price'],
            $agora,
            $agora
        );

        $this->ativoRepository->save($ativo);

        // após save(), se você implementou setId() na Entidade, o id já estará preenchido
        if ($ativo->getId()) {
            $reloaded = $this->ativoRepository->findByIdAndCarteira($ativo->getId(), $carteiraId);
            if ($reloaded) {
                return $reloaded;
            }
        }

        // fallback: retorna o próprio objeto (já consistente)
        return $ativo;
    }

    public function atualizarAtivo(int $carteiraId, int $ativoId, array $dados): Ativo
    {
        $ativo = $this->buscarAtivo($carteiraId, $ativoId);

        // atualiza campos no domínio (não mexa em created_at)
        if (array_key_exists('category_id', $dados))  $ativo->setCategoriaId($dados['category_id']);
        if (array_key_exists('asset_type_id', $dados)) $ativo->setTipoId((int) $dados['asset_type_id']);
        if (array_key_exists('name', $dados))         $ativo->setNome($dados['name']);
        if (array_key_exists('quantity', $dados))     $ativo->setQuantidade((float) $dados['quantity']);
        if (array_key_exists('price', $dados))        $ativo->setPreco((float) $dados['price']);
        if (array_key_exists('average_price', $dados)) $ativo->setPrecoMedio((float) $dados['average_price']);

        $ativo->setUpdatedAt(new DateTime());

        $this->ativoRepository->save($ativo);

        $reloaded = $this->ativoRepository->findByIdAndCarteira($ativoId, $carteiraId);
        return $reloaded ?? $ativo;
    }

    public function removerAtivo(int $carteiraId, int $ativoId): void
    {
        // garante ownership (senão alguém poderia tentar deletar asset de outra carteira)
        $this->buscarAtivo($carteiraId, $ativoId);

        $this->ativoRepository->delete($ativoId, $carteiraId);
    }
}
