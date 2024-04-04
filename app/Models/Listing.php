<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'comapny',
        'location',
        'email',
        'website',
        'tags',
        'description',
        'logo',
        'user_id'

    ];

    public function scopeFilter($query, $tag, $search)
    {
        if ($tag) {
            $query->where('tags', 'like', '%' . $tag . '%');
        }

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%');
        }
    }

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
