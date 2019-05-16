<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Operation onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Operation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Operation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Operation withoutTrashed()
 */
class Operation extends Model
{
    use SoftDeletes;

    protected $table = 'operations';
    protected $fillable = [
        'user_id', 'card_id', 'operation_type_id', 'amount', 'is_success', 'additional_info'
    ];
    protected $casts = [
        'is_success' => 'boolean',
    ];
    protected $appends = ['type_name'];

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

    public function getTypeNameAttribute(): string
    {
        return $this->operationType->type_name;
    }

    public function saveOperation($data, $isSuccess): bool
    {
        $card = Card::find($data['card_id']);
        if (!$card) {
            return false;
        }
        $this->user_id = $card->user_id;
        $this->card_id = $card->id;
        $this->operation_type_id = $data['operation_type_id'];
        $this->amount = $data['amount'];
        $this->is_success = $isSuccess;
        $this->additional_info = $data['card_number'] ?? null;
        return $this->save();
    }
}
