<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberConvert extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'number',
        'value'
    ];

    protected $casts = [
        'id' => 'int',
        'number' => 'int',
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];
}
