<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'email_verified_at',
    ];


    /**
     * Perform pre-authorization checks on the model.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('Super-Admin')) {
            return true;
        }
        return null; // see the note above in Gate::before about why null must be returned here.
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userProviders(): HasMany
    {
        return $this->hasMany(UserProvider::class);
    }

    public function mustVerifyEmail(): bool
    {
        return $this instanceof MustVerifyEmail && !$this->hasVerifiedEmail();
    }

    public function createDeviceToken(string $device, string $ip, bool $remember = false): string
    {
        $sanctumToken = $this->createToken(
            $device,
            ['*'],
            $remember ?
                now()->addMonth() :
                now()->addDay()
        );

        $sanctumToken->accessToken->ip = $ip;
        $sanctumToken->accessToken->save();

        return $sanctumToken->plainTextToken;
    }

    /**
     * @return BelongsToMany
     */
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class)
            ->withTimestamps();


    }
}
