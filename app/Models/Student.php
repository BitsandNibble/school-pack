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

    protected $fillable = [
        'fullname', 'gender', 'date_of_birth',
        'school_id', 'email', 'password',
        'phone_number', 'profile_photo', 'slug',
        'class_room_id', 'section_id',
        'address', 'nationality_id', 'state_id', 'lga_id',
        'graduated', 'graduation_date', 'year_admitted'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class)->withDefault();
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class)->withDefault();
    }

    public function mark(): HasMany
    {
        return $this->hasMany(Mark::class);
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
