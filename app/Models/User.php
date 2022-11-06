<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        CrudTrait,
        HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Connection to table user_project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user2project()
    {
        return $this->hasMany(User2Project::class, 'user_id', 'id');
    }

    /**
     * Connection to project tablle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'user_project', 'user_id', 'project_id');
    }

    /**
     * Get active project by user
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAtctiveProject()
    {
        // TODO: if we created archive, remake
        $projects = $this->projects()->get();

        return $projects;
    }
}
