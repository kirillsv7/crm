<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $perPage = 20;

    protected $fillable = ['company', 'vat', 'address'];

    public function getIsDeletedAttribute(): bool
    {
        return $this->deleted_at !== null;
    }
}
