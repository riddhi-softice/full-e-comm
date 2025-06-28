<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];

    public function address()  // related product
    {
        return $this->hasOne(Address::class)->oldest(); // or ->orderBy('id')
    }

}
