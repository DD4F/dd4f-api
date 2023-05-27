<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'source',
        'owner',
        'created_by',
        'created_at',
    ];
    
    protected $casts = [];
}
