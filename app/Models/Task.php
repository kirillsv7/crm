<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Task extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $perPage = 20;

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'status_id',
    ];

    protected $with = ['project'];

    public static $statuses = [
        '1' => 'Created',
        '2' => 'Working',
        '3' => 'Paused',
        '4' => 'Pending validation',
        '5' => 'Finished',
    ];

    protected $imageSizes = [
        'thumb' => [300, 200],
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function getStatusAttribute()
    {
        return self::$statuses[$this->status_id];
    }

    public function getDeletedAttribute()
    {
        return $this->deleted_at !== null;
    }

    public function scopeFilterByProject($query)
    {
        if (request('project_id')) {
            return $query->where('project_id', request('project_id'));
        }

        return $query;
    }

    public function scopeFilterByClient($query)
    {
        if (request('client_id')) {
            return $query->whereHas('project', function ($subQuery) {
                $subQuery->where('client_id', request('client_id'));
            });
        }

        return $query;
    }

    public function scopeFilterByUser($query)
    {
        if (request('user_id')) {
            return $query->whereHas('project', function ($subQuery) {
                $subQuery->where('user_id', request('user_id'));
            });
        }

        return $query;
    }

    public function scopeFilterByStatus($query)
    {
        if (request('status_id')) {
            request()->validate([
                'status_id' => [
                    'numeric',
                    Rule::in(collect(self::$statuses)->keys()->prepend(0)),
                ],
            ]);
            if (request('status_id') != 0) {
                return $query->where('status_id', request()->input('status_id'));
            }
        }

        return $query;
    }

    public function scopeFilterAssignedToUser($query)
    {
        if (request()->has('assigned_to_user')) {
            request()->validate(['assigned_to_user' => 'boolean']);
            if (request('assigned_to_user')) {
                return $query->whereHas('project', function ($query) {
                    $query->where('user_id', auth()->id());
                });
            }
        }

        return $query;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        foreach ($this->imageSizes as $name => $dimensions) {
            $this->addMediaConversion($name)
                 ->width($dimensions[0])
                 ->height($dimensions[1])
                 ->sharpen(10);
        }
    }
}
