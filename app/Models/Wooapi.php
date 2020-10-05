<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wooapi
 * 
 * @property int $id
 * @property string $name
 * @property string $domain
 * @property string $key_secret
 * @property int $user_id
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Wooapi extends Model
{
	protected $table = 'wooapi';

	protected $casts = [
		'user_id' => 'int',
		'is_active' => 'int'
	];

	protected $hidden = [
		'key_secret'
	];

	protected $fillable = [
		'name',
		'domain',
		'key_secret',
		'user_id',
		'is_active'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
