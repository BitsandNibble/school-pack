<?php

namespace App\Models;

use Closure;
use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory, WithSearch;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function class_room(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class)->withDefault();
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class)->withDefault();
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

	public function class_subjects()
	{
		return $this->belongsToMany(ClassRoom::class, 'class_student_subjects', 'student_id');
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