<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Operation
 *
 * @property int $id
 * @property int $user_id
 * @property int $card_id
 * @property int $operation_type_id
 * @property float $amount
 * @property bool $is_success
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Card $card
 * @property-read \App\Models\OperationType $operationType
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereIsSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereOperationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereUserId($value)
 * @mixin \Eloquent
 */
class Operation extends Model
{
    protected $table = 'operations';
    protected $fillable = [
        'user_id', 'card_id', 'operation_type_id', 'amount', 'is_success'
    ];
    protected $casts = [
        'is_success' => 'boolean',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function card(): HasOne
    {
        return $this->hasOne(Card::class, 'id', 'card_id');
    }

    public function operationType(): HasOne
    {
        return $this->hasOne(OperationType::class, 'id', 'operation_type_id');
    }
}