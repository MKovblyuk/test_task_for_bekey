<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'creator_id'
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
