<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OperationType
 *
 * @property int $id
 * @property string $type_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationType whereTypeName($value)
 * @mixin \Eloquent
 */
class OperationType extends Model
{
    protected $table = 'operation_types';
    protected $fillable = [
        'type_name'
    ];
    public $timestamps = false;

    public const TYPE_WITHDRAWAL = 1;
    public const TYPE_REPLENISHMENT = 2;
    public const TYPE_TRANSFER = 3;
}
