<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\User2Project
 *
 * @property int $project_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|User2Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User2Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User2Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|User2Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User2Project whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User2Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User2Project whereUserId($value)
 * @mixin \Eloquent
 */
class User2Project extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'user_project';
    // protected $primaryKey = 'id';
    public $timestamps = true;
    //protected $guarded = ['id'];
    protected $fillable = ['project_id', 'user_id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * Connection to users
     *
     * Return table users
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Connection to projects
     *
     * Return project table
     * @return HasOne
     */
    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
