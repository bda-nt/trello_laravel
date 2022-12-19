<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stage
 *
 * @property-read Task $task
 * @property int $task_id
 * @property string $description
 * @property int $is_ready
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Stage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereIsReady($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stage extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'stages';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'task_id',
        'description',
        'is_ready'
    ];
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

    public function task()
    {
        return $this->hasOne(Task::class, 'id', 'task_id');
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
