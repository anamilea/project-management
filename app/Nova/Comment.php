<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use App\Models\User;
use App\Models\Task;
use Laravel\Nova\Http\Requests\NovaRequest;

class Comment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Comment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        if($request->user()->hasRole('Admin')){
            return [
                ID::make(__('ID'), 'id')->sortable()->hideFromIndex(),
                Select::make('Task','taskId')->options(Task::pluck('name', 'id'))->displayUsingLabels(),
                Select::make('User','userId')->options(User::pluck('lastName', 'id'))->displayUsingLabels(),
                Text::make('Text','text')
                ->sortable()
                ->rules('required', 'max:255') 
                 ];
        } else if($request->user()->hasRole('User')) {
            return [
                ID::make(__('ID'), 'id')->sortable(),
                Select::make('Task','taskId')->options(Task::where('assignedTo', $request->user()->id)->pluck('name', 'id'))->displayUsingLabels(),
    
                
                Select::make('User','userId')->options(User::where('id', $request->user()->id)->pluck('lastName', 'id'))->displayUsingLabels(),
                Text::make('text','text')
                ->sortable()
                ->rules('required', 'max:255') 
            ];
        
        }
     
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
        return [];
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

    public static function indexQuery(NovaRequest $request, $query)
    {
        if($request->user()->hasRole('Admin')) 
            return $query;
        return $query->where('userId', $request->user()->id);
    }

}
