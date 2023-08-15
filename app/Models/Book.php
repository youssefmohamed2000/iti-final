<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable
        = [
            'user_id',
            'name',
            'description',
            'author',
            'return_date',
        ];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn() => is_null($this->user_id)
            && is_null($this->return_date)
                ? 'Available'
                : 'Not Available',
        );
    }

    // relations

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
