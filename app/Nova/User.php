<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Filters\UserType;
use Illuminate\Support\Facades\Storage;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'user';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()
            ->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            })->hideFromIndex(),
            Avatar::make('Avatar','avatar')
            ->disk('userimages')
            ->path('photos')
            ->prunable()
            ->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            }),
            Text::make('First Name','firstName')
                ->sortable()
                ->rules('required', 'max:255')
                ->canSee(function ($request) {
                    return $request->user()->hasRole('Admin');
                }),
            Text::make('Last Name','lastName')
            ->sortable()
            ->rules('required', 'max:255')
            ->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            }),
            Text::make('Username','username')
            ->sortable()
            ->rules('required', 'max:255')
            ->canSee(function ($request) {
                return $request->user()->hasRole('Admin');
            }),
            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:user,email')
                ->updateRules('unique:user,email,{{resourceId}}')
                ->canSee(function ($request) {
                    return $request->user()->hasRole('Admin');
                }),
            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8')
                ->canSee(function ($request) {
                    return $request->user()->hasRole('Admin');
                }),
                HasMany::make('Comments'),
                HasMany::make('Tasks'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [  new Filters\UserType];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function availableForNavigation(Request $request)
{
    return $request->user()->hasRole('Admin');
}
}
