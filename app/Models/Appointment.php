<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * @property int $user_id
 * @property string $reason
 * @property DateTime $date
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
#[Fillable(['user_id', 'reason', 'date'])]
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reason',
        'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
