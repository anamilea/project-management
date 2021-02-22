<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\File;

class User extends Authenticatable
{
    use HasRoles, HasFactory;

    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'password',
        'avatar',
        'username',
        'email'
    ];


    public function getUserAttachments()
    {
        $additionalImages = $this->getMedia('avatar');
        $additionalImagesUrls = [];

        foreach ($additionalImages as $media) {
            $additionalImagesUrls[] = $media->getUrl();
        }

        return collect($additionalImagesUrls);
    }
    
    public function registerMediaCollections() : void
    { 

      $this->addMediaCollection('avatar');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'assignedTo');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'userId');
    }
}
