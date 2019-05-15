<?php

namespace App\Models;

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
        'user_id', 'amount', 'number'
    ];
    protected $hidden = [
        'pin',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class, 'card_id', 'id');
    }

    public function setPinAttribute($password): void
    {
        $this->attributes['pin'] = bcrypt($password);
    }
}
