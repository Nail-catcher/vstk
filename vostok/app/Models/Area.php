<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;
use Staudenmeir\EloquentEagerLimit\Grammars\MySqlGrammar;
use Staudenmeir\EloquentEagerLimit\Grammars\PostgresGrammar;
use Staudenmeir\EloquentEagerLimit\Grammars\SQLiteGrammar;
use Staudenmeir\EloquentEagerLimit\Grammars\SqlServerGrammar;

class Area extends Model
{
    use HasFactory;
    use SpatialTrait;

    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $spatialFields = [
        'location'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    public function setLatitudeAttribute($value)
    {
        $this->attributes['location'] = new Point($value, $this->longitude);
    }

    public function setLongitudeAttribute($value)
    {
        $this->attributes['location'] = new Point($this->latitude, $value);
    }

    public function getLatitudeAttribute()
    {
        return optional($this->location)->getlat();
    }

    public function getLongitudeAttribute()
    {
        return optional($this->location)->getLng();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Station::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        $grammar = $connection->withTablePrefix($this->getQueryGrammar($connection));

        return new \App\Eloquent\Builder(
            $connection, $grammar, $connection->getPostProcessor()
        );
    }

    /**
     * Get the query grammar.
     *
     * @param \Illuminate\Database\Connection $connection
     * @return \Illuminate\Database\Query\Grammars\Grammar
     */
    protected function getQueryGrammar(Connection $connection)
    {
        $driver = $connection->getDriverName();

        switch ($driver) {
            case 'mysql':
                return new MySqlGrammar;
            case 'pgsql':
                return new PostgresGrammar;
            case 'sqlite':
                return new SQLiteGrammar;
            case 'sqlsrv':
                return new SqlServerGrammar;
        }

        throw new RuntimeException('This database is not supported.'); // @codeCoverageIgnore
    }
}
