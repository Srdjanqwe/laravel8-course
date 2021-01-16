<?php

namespace App\Services;

// use Illuminate\Support\Facades\Cache;

use App\Contracts\CounterContract;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session;
use tidy;

class Counter implements CounterContract
{
    private $timeout;
    private $cache;
    private $session;
    private $supportsTags;

    public function __construct(Cache $cache,Session $session, int $timeout)
    {
        $this->cache = $cache;
        $this->timeout = $timeout;
        $this->session = $session;
        $this->supportsTags = method_exists($cache, 'tags');
    }

    public function increment(string $key, array $tags = null): int
    {
        // dump($this->session);
        // dd($this->cache);
        $sessionId = $this->session->getId();
        $counterKey="{$key}-counter";
        $usersKey="{$key}-users";

        $cache = $this->supportsTags && null !== $tags
            ? $this->cache->tags($tags) : $this->cache;

        $users = $cache->get($usersKey,[]);
        $usersUpdate = [];
        $differences = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) > $this->timeout) {
                $differences--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) > $this->timeout) {
            $differences++;
        }

        $usersUpdate[$sessionId] = $now;
        $cache->forever($usersKey, $usersUpdate);

        if(!$cache->has($counterKey)) {
            $cache->forever($counterKey, 1);
        } else {
            $cache->increment($counterKey, $differences);
        }

        $counter =$cache->get($counterKey);

        return $counter;
    }

}
