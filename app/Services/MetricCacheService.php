<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Psr\SimpleCache\InvalidArgumentException;

class MetricCacheService
{
    public function getKeys(): array
    {
        $pattern = '*';
        $keys = Redis::keys($pattern);

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = Redis::get($key);
        }

        return $data;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function persist(array $data): bool
    {
        $id = (int) ($data['media_id']);
        $key = $this->mountKey($data['type'], $id);

        if (! Redis::get($key)) {
            Redis::set($key, 1);
        }
        
        Redis::incr($key);
        
        return true;
    }

    private function mountKey(string $type, int $id): string
    {
        $keyDate = Carbon::now()->format('Ymd');
        $keyId = ':type_' . $type . '_' . $id;

        return 'view_' . $keyDate . $keyId;
    }
}
