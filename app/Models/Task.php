<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\File;

class Task extends Model implements HasMedia {
    use HasFactory, InteractsWithMedia;
   
    protected $table = 'task';
    
     /* static identifiers */
    const TASK_STATUS_TODO = 0;
    const TASK_STATUS_INPROGRESS = 1;
    const TASK_STATUS_DONE = 2;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'attachment',
        'assignedTo',
        'project'
    ];

    public function getTaskAttachments()
    {
        $additionalImages = $this->getMedia('attachment');
        $additionalImagesUrls = [];

        foreach ($additionalImages as $media) {
            $additionalImagesUrls[] = $media->getUrl();
        }

        return collect($additionalImagesUrls);
    }

    public function registerMediaCollections() : void
    { 
      // downloadabble pdf catalog file
      $this->addMediaCollection('attachment');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class,'taskId');
    }
}
