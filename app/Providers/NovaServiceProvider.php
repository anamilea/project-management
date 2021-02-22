<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Models\User;
use App\Http\Controllers\LoginController;
use App\Nova\Metrics\ApprovedProjects;
use App\Nova\Metrics\TasksDone;
use App\Nova\Metrics\TasksInProgress;
use App\Nova\Metrics\TasksToDo;
use App\Nova\Metrics\UsersPerPlan;
use Illuminate\Support\Facades\Hash;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::createUserUsing(function($command) {
            return [
                $command->ask('First Name'),
                $command->ask('Last Name'),
                $command->ask('Email Address'),
                $command->secret('Password'),
                $command->ask('Username'),
            ];
        }, function($firstName, $lastName, $email, $password, $username) {
            $user = new User;
           
            ($user)->forceFill([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $username,
                'email' => $email,
                'password' => bcrypt($password),
                'avatar' => 'ceva.jpg'
             ])->save();
             $user->assignRole('Admin');
        });

        Nova::routes()->withAuthenticationRoutes()->withPasswordResetRoutes()->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            (new ApprovedProjects)->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            }),
            (new TasksInProgress)->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            }),
            (new TasksDone())->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            }),
            (new TasksToDo())->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            }),
            new UsersPerPlan
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LoginController::class, \App\Http\Controllers\LoginController::class);
    }
}
