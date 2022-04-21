<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
  use HasFactory;
  protected $fillable = [
    'author_id', 'title', 'content', 'slug',
    'category', 'tag', 'year', 'month'. 'cover_image', 'public'
  ];

  protected static function boot(): void
  {
    parent::boot();
    // static::addGlobalScope(new PostedScope);
  }

  public function hasThumbnail(): bool
  {
    return filled($this->cover_image);
  }

  public function comments(): HasMany
  {
    return $this->hasMany(Comment::class);
  }

  public function author(): BelongsTo
  {
    return $this->belongsTo(User::class, 'author_id');
  }

}
