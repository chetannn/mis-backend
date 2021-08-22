<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassHierarchy extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(ClassHierarchy::class, 'parent_id');
    }

    public static function tree()
    {
        $allClass = ClassHierarchy::get();

        $rootClasses = $allClass->whereNull('parent_id');

        self::formatTree($rootClasses, $allClass);

        return $rootClasses;
    }

    private static function formatTree($classes, $allClasses)
    {
        foreach ($classes as $class) {
            $class->children = $allClasses->where('parent_id', $class->id)->values();

            if($class->children->isNotEmpty()) {
                self::formatTree($class->children, $allClasses);
            }

        }

    }
}
