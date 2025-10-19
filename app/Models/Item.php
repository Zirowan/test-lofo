<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Add additional fields to the $fillable array
    protected $fillable = [
        'pic',
        'from',
        'status',
        'description',
        'type',
        'latitude',
        'longitude',
        'reason',
        'image_labels', // Include image labels for storing the recognized labels
        'selected_label'
    ];
    protected $casts = [
        'ai_labels' => 'array',
        'image_labels' => 'array', // Cast JSON column to array
    ];


    public function itemOfStudent()
    {
        return $this->belongsTo(Student::class);
    }
}

