<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{

    use HasFactory, Notifiable, HasRoles;
    

    protected $guarded = [];

    protected function acsrImagePath(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) =>
            $attributes['photo']
                ? Storage::url('user_images/' . $attributes['photo'])
                : null
        );
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')->select('group_name')
            ->groupBy('group_name')->get();
        return $permission_groups;
        
    }

    public static function getpermissionGroupByName($group_name)
    {
        $permissions_group_names = DB::table('permissions')
                        ->select('name','id')
                        ->where('group_name',$group_name)
                        ->get();
        return $permissions_group_names;

    }
}
