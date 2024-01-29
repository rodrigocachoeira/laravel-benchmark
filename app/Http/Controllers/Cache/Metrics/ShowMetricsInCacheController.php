<?php

namespace App\Http\Controllers\Cache\Metrics;

use App\Http\Controllers\Controller;
use App\Services\MetricCacheService;

class ShowMetricsInCacheController extends Controller
{
    private MetricCacheService $metricCacheService;
    
    public function __construct(MetricCacheService $metricCacheService)
    {
        $this->metricCacheService = $metricCacheService;
    }
    
    public function __invoke()
    {
        $keys = $this->metricCacheService->getKeys();
        return response($keys);
    }
}