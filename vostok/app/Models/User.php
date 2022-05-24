<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoleAndPermission;
    use Notifiable;

//    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'email',
        'phone',
        'profile_photo_path',
        'one_signal_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'one_signal_token',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function routeNotificationForOneSignal()
    {
        return $this->one_signal_token ?? false;
    }

    public function routeNotificationForSmsru()
    {
        return preg_replace('/\D/', '', $this->phone);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->lastname} {$this->firstname} {$this->middlename}";
    }

    /**
     * @return string
     */
    public function getLastnameWithInitialsAttribute(): string
    {
        return "{$this->lastname} {$this->firstname} {$this->middlename}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vacations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vacation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Station::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'engineer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applicationsForDispatcher(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class, 'dispatcher_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applicationsForEngineers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function inventories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Inventory::class)->withTimestamps();
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereIn('status_id', [1, 2]);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive(Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNotIn('status_id', [1, 2]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logmagazine(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LogMagazine::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl(): string
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode("{$this->lastname} {$this->firstname}") . '&color=FFFFFF&background=00A49D&size=40';
    }
    //  /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function applicationReport(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(ApplicationReport::class, 'engineer_id');
    // }

}
