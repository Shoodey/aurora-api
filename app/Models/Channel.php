<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
    protected $fillable = [
        'name',
        'user_id',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_password_protected'];

    /**
     * Assess if channels is password protected.
     *
     * @var bool
     */
    public function getIsPasswordProtectedAttribute()
    {
        return !empty($this->attributes['password']);
    }

    /**
     * Get the user that owns the Channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
