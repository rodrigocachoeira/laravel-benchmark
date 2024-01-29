<?php

namespace App\Http\Controllers\Cache\Metrics;

use App\Http\Controllers\Controller;
use App\Services\MetricCacheService;
use Illuminate\Http\Request;
use Swoole\Http\Status;

class StoreMetricInCacheController extends Controller
{
    private MetricCacheService $metricCacheService;

    public function __construct(MetricCacheService $metricCacheService)
    {
        $this->metricCacheService = $metricCacheService;
    }

    public function __invoke(Request $request)
    {
        $data = $request->all();
        $this->metricCacheService->persist($data);

        return response([
            'status' => 200,
        ]);
    }
}