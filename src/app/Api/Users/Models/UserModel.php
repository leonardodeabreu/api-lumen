<?php

declare(strict_types=1);

namespace App\Api\Users\Models;

use App\Api\Books\Models\BookModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class UserModel extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, SoftDeletes;

    protected $table = 'users';

    protected $fillable
        = [
            'id',
            'name',
            'phone',
            'age',
            'email',
            'password',
            'active',
        ];

    protected $hidden
        = [
            'password',
        ];

    protected $dates
        = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

    protected $casts
        = [
            'active' => 'boolean',
        ];

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function favoriteBooks(): BelongsToMany
    {
        return $this->belongsToMany(
            BookModel::class,
            'user_has_books',
            'user_id',
            'book_id'
        );
    }
}
