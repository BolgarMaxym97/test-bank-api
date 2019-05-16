<?php

namespace App\Models;

use App\Helpers\Generators;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Card
 *
 * @property int $id
 * @property int $number
 * @property int $user_id
 * @property string $pin
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Operation[] $operations
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card wherePin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Card onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Card withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Card withoutTrashed()
 */
class Card extends Model
{
    use SoftDeletes;

    protected $table = 'cards';
    protected $fillable = [
        'user_id', 'amount', 'number', 'pin', 'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime:m/Y',
        'number' => 'string',
    ];

    const NUMBER_LENGTH = 16;

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class, 'card_id', 'id');
    }

    public function setPinAttribute($pin): void
    {
        $this->attributes['pin'] = bcrypt($pin);
    }

    public function setNumberAttribute(): void
    {
        do {
            $generatedNumber = Generators::creditCardNumber();
        } while (Card::where('number', $generatedNumber)->get()->isNotEmpty());
        $this->attributes['number'] = $generatedNumber;
    }

    public function setUserIdAttribute(): void
    {
        $user = \Auth::user();
        $this->attributes['user_id'] = $user->id;
    }

    public function setExpiredAtAttribute(): void
    {
        $this->attributes['expired_at'] = Carbon::now()->addYears(3);
    }

    public function doOperation($data): bool
    {
        switch ($data['operation_type_id']) {
            case OperationType::TYPE_WITHDRAWAL:
                return $this->doWithdrawal($data);
            case OperationType::TYPE_REPLENISHMENT:
                return $this->doReplenishment($data);
            case OperationType::TYPE_TRANSFER:
                $data['card_number'] = str_replace(' ', '', $data['card_number']);
                return $this->doTransfer($data);
            default:
                return false;
        }

    }

    private function doWithdrawal($data)
    {
        if ($this->checkAmount($data['amount'])) {
            $this->amount -= $data['amount'];
            return $this->save();
        }
        return false;
    }

    private function doReplenishment($data)
    {
        $this->amount += $data['amount'];
        return $this->save();
    }

    private function doTransfer($data)
    {
        if ($this->checkAmount($data['amount']) && $data['card_number']) {
            $card = self::where('number', $data['card_number'])->first();
            if (!$card) {
                return false;
            }
            $this->amount -= $data['amount'];
            if ($this->save()) {
                $card->amount += $data['amount'];
                return $card->save();
            }
            return false;
        }
        return false;
    }

    private function checkAmount($amount)
    {
        return (int)$this->amount >= (int)$amount;
    }
}
