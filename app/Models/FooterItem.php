<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterItem extends Model
{
    use HasFactory;

    protected $table = 'footer_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'section_id',
        'content',
        'icon',
        'link',
        'position',
        'status'
    ];

    public function section()
    {
        return $this->belongsTo(FooterSection::class, 'section_id', 'id');
    }
}
