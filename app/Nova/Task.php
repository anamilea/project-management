<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\File;
use App\Models\Task as BasicTask;
use App\Models\User;
use App\Models\Project;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;

class Task extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Task::class;

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
        // dd($request);
        return [
            ID::make(__('ID'), 'id')->sortable()->readonly(function($request) {
                return !$request->user()->hasRole('Admin');
            })->hideFromIndex(),
            Text::make('Name','name')
            ->sortable()
            ->rules('required', 'max:255')->readonly(function($request) {
                return !$request->user()->hasRole('Admin');
            }),
            Text::make('Description','description')
            ->sortable()
            ->rules('required', 'max:255')->readonly(function($request) {
                return !$request->user()->hasRole('Admin');
            })
            ,
            Select::make('Status', 'status')->options([
                BasicTask::TASK_STATUS_TODO => 'To do',
                BasicTask::TASK_STATUS_INPROGRESS => 'In progress', 
                BasicTask::TASK_STATUS_DONE => 'Done',
            ])->displayUsingLabels()
            ,
            File::make('Attachment')
            ->disk('public')->readonly(function($request) {
                return !$request->user()->hasRole('Admin');
            }) ,
            Select::make('Assigned To','assignedTo')->options(User::pluck('lastName', 'id'))->readonly(function($request) {
                return !$request->user()->hasRole('Admin');
            })->displayUsingLabels()
            ,
            Select::make('Project','project')->options(Project::pluck('name', 'id'))->readonly(function($request) {
                return !$request->user()->hasRole('Admin');
            })->displayUsingLabels()
            ,
            HasMany::make('Comments'),
            
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
        return [  new Filters\TaskStatus];

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
        return $query->where('assignedTo', $request->user()->id);
    }


    
}
