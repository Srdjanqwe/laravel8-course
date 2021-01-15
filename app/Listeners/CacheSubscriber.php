<?php

namespace App\Listeners;
// namespace Illuminate\Cache\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheEvent;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{
    public function handleCacheHit(CacheHit $event)
    {
        Log::info("{$event->key} cache hit");
    }
    public function handleCacheMissed(CacheMissed $event)
    {
        Log::info("{$event->key} cache miss");
    }
    public function subscriber($events)
    {
        $events->listen(
            CacheHit::class,
            'App\Listeners\CacheSubscirber@handleCacheHit'
        );

        $events->listen(
            CacheMissed::class,
            'App\Listeners\CacheSubscirber@handleCacheMissed'
        );
    }
}
