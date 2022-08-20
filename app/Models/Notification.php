<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'background_color', 'limit_color', 'text_color', 'text_size', 'link', 'texte', 'display'
    ];
}
