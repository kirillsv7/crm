<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'solution',
        'project_id',
        'status_id'
    ];

    public static $statuses = [
        '0' => 'Created',
        '1' => 'Working',
        '2' => 'Paused',
        '3' => 'Pending validation',
        '4' => 'Finished',
    ];
}
