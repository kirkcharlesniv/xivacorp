<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\UserRole;
use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\OpeningHours\OpeningHours;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'hcp_data_id',
        'role',
        'workspace_id',
        'dob',
        'address',
        'gender',
        'hours',
        'is_onboarded',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRole::class,
        'gender' => GenderEnum::class,
    ];

    protected $appends = [
        'company_name',
        'in_schedule',
        'working_hours',
    ];

    public function hcp_data()
    {
        return $this->hasOne(HcpData::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'workspace_id', 'code');
    }

    public function getCompanyNameAttribute() {
        return $this->company->name ?? 'Floating';
    }

    public function getInScheduleAttribute()
    {
        if(!$this->hours ?? null) {
            return false;
        }

        return (OpeningHours::create(json_decode($this->hours, true)))->isOpen();
    }

    public function getWorkingHoursAttribute()
    {
        if(!$this->hours ?? null) {
            return false;
        }

        $decoded = json_decode($this->hours, true);
        $exploded = explode('-', reset($decoded)[0]);
        return [$exploded[0], $exploded[1]];
    }
}
