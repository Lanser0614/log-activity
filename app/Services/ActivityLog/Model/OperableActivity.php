<?php

namespace App\Services\ActivityLog\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class OperableActivity
{
    private ?string $request_id = null;
    private ?array $payload = null;
    private ?string $datetime = null;
    private ?string $action = null;
    private ?string $route = null;

    public function makeOperable(stdClass $class, array $payload): static
    {
        $this->request_id = request()->header('X-Request-Id');
        $this->payload = $payload;
        $this->datetime = now()->format('Y-m-d H:i:s');
        $this->action = (new \ReflectionClass($class))->getName();
        $this->route = request()->route()->uri;

        return $this;
    }

    public function save(): void
    {
        DB::table('operable_activities')->insert($this->toArray());
    }

    private function toArray(): array
    {
        return [
            'request_id' => $this->request_id,
            'payload' => $this->payload,
            'datetime' => $this->datetime,
            'action' => $this->action,
            'route' => $this->route,
        ];
    }


}
