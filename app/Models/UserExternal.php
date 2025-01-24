<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class UserExternal extends Model
{
    use UuidTrait;

    protected $table = 'user_externals';

    public $incrementing = false;

    protected $fillable = [
        'nome',
        'email',
        'cidade',
        'telefone',
        'foto',
        'data_nascimento',
    ];

}
