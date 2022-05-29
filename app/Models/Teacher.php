<?php

namespace App\Models;

use Closure;
use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static where(string $string, $id)
 * @method static find($id)
 * @method static create(array $array)
 * @method static get()
 * @method static when($q, Closure $param)
 * @property mixed profile_photo
 */
class Teacher extends Authenticatable
{
	use HasFactory, WithSearch;

	protected $fillable = [
		'fullname', 'title', 'gender',
		'date_of_birth', 'school_id', 'email',
		'password', 'phone_number', 'profile_photo',
		'slug', 'address', 'nationality_id',
		'state_id', 'lga_id', 'date_of_employment'
	];

	// protected $search = [
	//   'firstname', 'middlename', 'lastname',
	// ];

	protected $hidden = [
		'password',
		'remember_token',
	];

	// public function principal()
	// {
	//   return $this->belongsTo(Principal::class);
	// }

	public function subjects(): BelongsToMany
	{
		// return $this->belongsToMany(Subject::class, 'class_subject_teacher', 'class_room_id');
		return $this->belongsToMany(Subject::class, 'class_subject_teacher', 'class_room_id', 'subject_id')->withPivot('teacher_id');
	}

	public function nationality(): BelongsTo
	{
		return $this->belongsTo(Nationality::class)->withDefault();
	}

	public function state(): BelongsTo
	{
		return $this->belongsTo(State::class)->withDefault();
	}

	public function lga(): BelongsTo
	{
		return $this->belongsTo(Lga::class)->withDefault();
	}

	public function getFullnameAttribute($value): string
	{
		return ucwords($value);
	}

	public function getThumbnailAttribute(): string
	{
		if ($this->profile_photo) {
			return asset('storage/profile-photos/' . $this->profile_photo);
		}
		return asset('assets/_images/avatars/avatar-10.png');
	}
}
