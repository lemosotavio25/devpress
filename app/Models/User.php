<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'seniority',
        'skills',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'skills' => 'array',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is developer
     */
    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    /**
     * Articles created by this user
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Articles where this user is listed as a contributor/developer
     */
    public function contributedArticles()
    {
        return $this->belongsToMany(Article::class, 'article_user')
                    ->withTimestamps();
    }

    /**
     * Addresses associated with this user
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

}
