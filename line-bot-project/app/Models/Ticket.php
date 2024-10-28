<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'path_img',
        'status',
        'line_id',
        'plan_date',
        'actual_date',
        'response',
        'rating',
    ];
}
