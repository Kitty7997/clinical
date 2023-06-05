<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinical extends Model
{
    use HasFactory;
    protected $privatekey = 'id';
    protected $table = 'clinical';
}
