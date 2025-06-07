<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'parent_id'];

    // Relação para permissão pai
    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
