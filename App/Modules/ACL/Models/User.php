<?php

namespace Collejo\App\Modules\ACL\Models;

use Cache;
use Collejo\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = ['id', 'first_name', 'last_name', 'date_of_birth', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('permission', $permission)->count();
    }

    public function hasRole($role)
    {
        return (bool) $this->roles->where('role', $role)->count();
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPermissionsAttribute()
    {
        return Cache::remember('user-perms:' . $this->id, config('collejo.tweaks.user_permissions_ttl'), function () {
            return Permission::join('permission_role', 'permission_role.permission_id', '=' ,'permissions.id')
                            ->join('roles', 'permission_role.role_id', '=', 'roles.id')
                            ->join('role_user', 'permission_role.role_id', '=', 'role_user.role_id')
                            ->where('role_user.user_id', $this->id)
                            ->get();
        });
    }

    public function roles()
    {
    	return $this->belongsToMany(Role::class);
    }

    /*public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }*/
}