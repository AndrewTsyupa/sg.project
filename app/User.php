<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable {
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param string|array $roles
     */

    public function authorizeRoles($roles) {

        if (is_array($roles)) {

            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');

        }

        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized.');

    }

    /**
     * Check multiple roles
     * @param array $roles
     */

    public function hasAnyRole($roles) {

        return null !== $this->roles()->whereIn('name', $roles)->first();

    }

    /**
     * Check one role
     * @param string $role
     */

    public function hasRole($role) {

        return null !== $this->roles()->where('name', $role)->first();

    }

    public function messages() {
        return [
            'email.unique' => 'Користувувач із цим username існує',
        ];
    }

    public function getRoleId() {
        $role = $this->roles()->first();

        if ($role) {
            return $role->id;
        }

        return 0;
    }

    public function getRoleName() {
        $role = $this->getRoleId();

        switch ($role) {
            case 1: {
                $name = 'Адмін';
                break;
            }
            case 2: {
                $name = 'Редактор';
                break;
            }
            default: {
                $name = 'Користувач';
            }
        }

        return $name;
    }

    public function setRole($role) {
        DB::table('role_user')->where(['user_id' => $this->id])->delete();

        $this->roles()->attach($role);
    }


    public function isAdmin() {
        return $this->hasAnyRole([Role::ROLE_ADMIN]);
    }

    public function isEditor() {
        return $this->hasAnyRole([Role::ROLE_EDITOR]);
    }

    public function isUser() {
        return $this->hasAnyRole([Role::ROLE_USER]);
    }


    public function canEditPostOrComments() {
        if ($this->isAdmin()) {
            $userId = 0;
        } else if ($this->isEditor()) {
            $userId = $this->id;
        } else {
            $userId = -1;
        }

        return $userId;
    }

}
