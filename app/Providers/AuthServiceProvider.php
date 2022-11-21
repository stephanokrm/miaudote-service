<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Animal;
use App\Models\Answer;
use App\Models\Breed;
use App\Models\Form;
use App\Models\Image;
use App\Models\Question;
use App\Policies\AnimalPolicy;
use App\Policies\AnswerPolicy;
use App\Policies\BreedPolicy;
use App\Policies\FormPolicy;
use App\Policies\ImagePolicy;
use App\Policies\QuestionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    protected $policies = [
        Animal::class => AnimalPolicy::class,
        Answer::class => AnswerPolicy::class,
        Breed::class => BreedPolicy::class,
        Form::class => FormPolicy::class,
        Image::class => ImagePolicy::class,
        Question::class => QuestionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
