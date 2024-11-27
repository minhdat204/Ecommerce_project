<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSection extends Model
{
    use HasFactory;
    protected $table = 'footer_sections';
    protected $primaryKey = 'id';

    protected $fillable = [
        'section_name',
        'title',
        'position',
        'status',
    ];

    function items()
    {
        return $this->hasMany(FooterItem::class, 'section_id', 'id');
    }
}
