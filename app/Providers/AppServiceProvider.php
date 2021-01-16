<?php

namespace App\Providers;


use App\Models\Comment;
use App\Models\BlogPost;
use App\Observers\CommentObserver;
use App\Observers\BlogPostObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\ActivityComposer;
use App\Services\Counter;
use App\Services\DummyCounter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::component('components.badge', 'badge');
        Blade::component('components.updated', 'updated');
        Blade::component('components.card', 'card');
        Blade::component('components.tags', 'tags');
        Blade::aliasComponent('components.tags', 'tags'); // ovo na neku foru radi vrlo uspesno @tags @endtags
        Blade::aliasComponent('components.errors', 'errors');
        Blade::aliasComponent('components.comment-form', 'commentForm');
        Blade::aliasComponent('components.comment-list', 'commentList');

        // View::composer('posts.index', 'App\Http\ViewComposers\ActivityComposer');
        view()->composer(['posts.index','posts.show'], ActivityComposer::class); // pazi na ovodjenje klasa

        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);

        $this->app->singleton(Counter::class, function($app) {
            return new Counter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                env('COUNTER_TIMEOUT')
            );
        });

        $this->app->bind(
            'App\Contracts\CounterContract',
            Counter::class
            // DummyCounter::class
        );

        // $this->app->when(Counter::class)->needs('$timeout')->give(env('COUNTER_TIMEOUT'));


    }
}
