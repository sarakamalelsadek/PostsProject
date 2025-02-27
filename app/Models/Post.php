<?php

namespace App\Models;

use App\Models\Scopes\ScopeWithAtLeastXComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    //status consts
    public const STATUS_DRAFT = 'draft';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    //relation
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    //scope
    /**
     * Retrieve posts with at least X comments.
     */
    protected static function booted()
    {
        static::addGlobalScope(new ScopeWithAtLeastXComments(1)); 
    }
}
