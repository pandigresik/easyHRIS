<?php

namespace App\Models\Base;

use App\Models\Base as Model;
use Kalnoy\Nestedset\NodeTrait;

class MenusTree extends Model
{
    use NodeTrait;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const CREATED_BY = null;
    public const UPDATED_BY = null;

    public $table = 'menus';
    public $fillable = [
        'name',
        'description',
        'status',
        'icon',
        'route',
        'parent_id',
        'seq_number',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Base\Permission::class, 'menu_permissions', 'menu_id');
    }

    public function menuPermission()
    {
        return $this->hasMany(\App\Models\Base\MenuPermissions::class);
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Base\Menus::class, 'parent_id');
    }

    public function setParentIdAttribute($value)
    {
        if ($this->getParentId() == $value) {
            return;
        }
        if ($value) {
            $this->appendToNode($this->toNode(\App\Models\Base\Menus::findOrFail($value)));
        } else {
            $this->makeRoot();
        }
    }

    private function toNode(Menus $menu)
    {
        $node = new \App\Models\Base\MenusTree();
        $node->id = $menu->getKey();
        foreach (array_merge($menu->getFillable(), ['id', '_lft', '_rgt']) as $f) {
            $node->{$f} = $menu->{$f};
        }
        $node->syncOriginal();

        return $node;
    }
}
