<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = ['username', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['password' => 'hashed'];

    public function mitra() { return $this->hasOne(Mitra::class, 'id_user'); }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isMitra(): bool { return $this->role === 'mitra'; }
    public function homeUrl(): string { return route($this->isAdmin() ? 'admin.dashboard' : 'mitra.dashboard'); }
}
