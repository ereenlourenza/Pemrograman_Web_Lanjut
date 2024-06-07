<?php

namespace App\Models;

// use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    // use HasFactory;

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return[];
    }

    protected $table = 'm_user'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //mendefinisikan primary key dari tabel yang digunakan
    /** 
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = ['level_id','username','nama','password', 'status', 'profile_img', 'image'];

    public function level(): BelongsTo{
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // public function stok(): HasMany{
    //     return $this->hasMany(StokModel::class, 'stok_id', 'stok_id');
    // }
    // protected function image(): Attribute{
    //     return Attribute::make(
    //         get: fn ($image) => url('/storage/posts/' . $image)
    //     );
    // }

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}
