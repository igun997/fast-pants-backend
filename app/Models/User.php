<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Wooapi[] $wooapis
 *
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $hidden = [
        "password"
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

	public function wooapis()
	{
		return $this->hasMany(Wooapi::class);
	}
}
