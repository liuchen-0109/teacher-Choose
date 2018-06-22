<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
class AppPassword extends Authenticatable
{
    protected $guarded = [];
    protected $table = 'app_password';

}
