<?php

namespace App\Models;

use App\Scopes\ProjectNonDeletedRelationsScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $perPage = 20;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'client_id',
        'user_id',
        'status_id',
    ];

    public static array $statusList = [
        '1' => 'Created',
        '2' => 'Working',
        '3' => 'Paused',
        '4' => 'Pending validation',
        '5' => 'Finished',
    ];

    protected array $imageSizes = [
        'thumb' => [300, 200],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getDeadlineInvertedAttribute()
    {
        return Carbon::parse($this->deadline)->format('d/m/Y');
    }

    public function getStatusAttribute()
    {
        return self::$statusList[$this->status_id];
    }

    public function getIsDeletedAttribute(): bool
    {
        return $this->deleted_at !== null;
    }

    public function scopeFilterByStatus($query)
    {
        if (request()->has('status_id')) {
            request()->validate([
                'status_id' => [
                    'numeric',
                    Rule::in(collect(self::$statusList)->keys()->prepend(0)),
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
                return $query->where('user_id', auth()->id());
            }
        }

        return $query;
    }

    protected static function booted()
    {
        static::addGlobalScope(new ProjectNonDeletedRelationsScope);
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
