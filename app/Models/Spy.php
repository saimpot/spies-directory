<?php

declare(strict_types = 1);

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Prosperty\Core\Domain\Spy\ValueObjects\FullName;

/**
 * App\Models\Spy.
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $agency
 * @property string|null $country_of_operation
 * @property string $birth_date
 * @property string|null $death_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read FullName $full_name
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 *
 * @method static Builder|Spy newModelQuery()
 * @method static Builder|Spy newQuery()
 * @method static Builder|Spy query()
 * @method static Builder|Spy whereAgency($value)
 * @method static Builder|Spy whereBirthDate($value)
 * @method static Builder|Spy whereCountryOfOperation($value)
 * @method static Builder|Spy whereCreatedAt($value)
 * @method static Builder|Spy whereDeathDate($value)
 * @method static Builder|Spy whereId($value)
 * @method static Builder|Spy whereName($value)
 * @method static Builder|Spy whereSurname($value)
 * @method static Builder|Spy whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Spy extends Model
{
    use HasFactory;
    use Notifiable;

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_SURNAME = 'surname';
    public const COLUMN_AGENCY = 'agency';
    public const COLUMN_COUNTRY_OF_OPERATION = 'country_of_operation';
    public const COLUMN_BIRTH_DATE = 'birth_date';
    public const COLUMN_DEATH_DATE = 'death_date';
    public const COLUMN_CREATED_AT = 'created_at';
    public const COLUMN_UPDATED_AT = 'updated_at';
    public const COLUMN_FULL_NAME = 'full_name';

    protected $table = 'spies';

    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_SURNAME,
        self::COLUMN_AGENCY,
        self::COLUMN_COUNTRY_OF_OPERATION,
        self::COLUMN_BIRTH_DATE,
        self::COLUMN_DEATH_DATE,
    ];

    protected $guarded = [
        self::COLUMN_ID,
        self::COLUMN_CREATED_AT,
        self::COLUMN_UPDATED_AT,
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => new FullName(
                name: $this->name,
                surname: $this->surname,
            ),
        );
    }
}
