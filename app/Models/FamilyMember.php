<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    /** @use HasFactory<\Database\Factories\FamilyMemberFactory> */

    use HasFactory;

    protected $table = 'family_members';

    protected $fillable = ['tree_id', 'name', 'birth_date', 'gender', 'address', 'parent_id', 'photo'];

    public function tree()
    {
        return $this->belongsTo(FamilyTree::class);
    }

    public function parent()
    {
        return $this->belongsTo(FamilyMember::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(FamilyMember::class, 'parent_id');
    }
}
