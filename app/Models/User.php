<?php

namespace App\Models;

use League\Glide\Server;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, MustVerifyEmail
{
    use SoftDeletes, Authenticatable, Authorizable, HasFactory, Notifiable;
    use \Illuminate\Auth\MustVerifyEmail;

    protected $casts = [
        'owner' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }


    // public function setPasswordAttribute($password)
    // {
    //     if (!$password) return;

    //     $this->attributes['password'] = Hash::make($password);
    // }

    public function setPhotoAttribute($photo)
    {
        if (!$photo) return;

        $this->attributes['photo_path'] = $photo instanceof UploadedFile ? $photo->store('users') : $photo;
    }

    public function getPhotoAttribute()
    {
        return $this->photoUrl(['w' => 40, 'h' => 40, 'fit' => 'crop']);
    }

    public function photoUrl(array $attributes)
    {
        if ($this->photo_path) {
            return URL::to(App::make(Server::class)->fromPath($this->photo_path, $attributes));
        }
    }

    public function isDemoUser()
    {
        return $this->email === 'johndoe@example.com';
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    public function scopeWhereRole($query, $role)
    {
        switch ($role) {
            case 'user':
                return $query->where('owner', false);
            case 'owner':
                return $query->where('owner', true);
        }
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        })->when($filters['role'] ?? null, function ($query, $role) {
            $query->whereRole($role);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
