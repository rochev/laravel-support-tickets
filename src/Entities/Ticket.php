<?php


namespace Rochev\Laravel\SupportTickets\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Ticket
 *
 * @property int $id
 * @property string $message
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property-read bool $is_active
 *
 * @mixin Builder
 */
class Ticket extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'support_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
    ];

    /**
     * Is ticket active
     *
     * @return bool
     */
    public function getIsActiveAttribute(): bool
    {
        return null === $this->deleted_at;
    }
}
