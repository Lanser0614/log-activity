<?php

namespace App\Services\ActivityLog\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LogActivity
{
    private array $original = [];
    private array $changed = [];
    private ?int $operableId = null;

    public function __construct()
    {
    }

    public static function log()
    {
        return new self();
    }


    public function setModel(Model $model): static
    {
        $this->setOriginal($model->getOriginal())->setChanged($model->getChanges());
        return $this;
    }

    public function setOperable(): static
    {
        $operableId = DB::table('operable_activities')->where('request_id', '=', request()->header('X-Request-Id'))->select('id')->first()->id;
        $this->setOperableId($operableId);
        return $this;
    }

    public function toArray(): array
    {
        return [
            'datetime' => now()->toDateTimeString(),
            'original' => json_encode($this->getOriginal()),
            'changed' => json_encode($this->getChanged()),
            'operable_id' => $this->getOperableId(),
        ];
    }

    public function setOriginal(array $original): static
    {
        $this->original = $original;
        return $this;
    }

    public function setChanged(array $changed): static
    {
        $this->changed = $changed;
        return $this;
    }

    public function getOriginal(): array
    {
        return $this->original;
    }

    public function getChanged(): array
    {
        return $this->changed;
    }

    public function setOperableId(?int $operableId): void
    {
        $this->operableId = $operableId;
    }

    public function getOperableId(): ?int
    {
        return $this->operableId;
    }
}
