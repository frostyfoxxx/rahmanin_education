<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, hasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number',
        'email',
        'password',
        'stuff'
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
    ];

    public $timestamps = false;
//<------------------------------------------------------------------------------------------------------------------------->
    public function School()
    {
      return $this->hasMany(School::class);
    }
//School
    public function PersonalData()
    {
      return $this->hasMany(PersonalData::class);
    }
//PersonalData
    public function Passport()
    {
      return $this->hasMany(Passport::class);
    }
//Passport
    public function Parents()
    {
      return $this->hasMany(Parents::class);
    }
//Parents
    public function Appraisal()
    {
      return $this->hasMany(Appraisal::class);
    }
//Appraisal
    public function AdditionalEducation()
    {
      return $this->hasMany(AdditionalEducation::class);
    }

//AdditionalEducation
}
