<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalHierarchy extends Model
{
    use HasFactory;

    public static function tree()
    {
        $allClass = FederalHierarchy::select(['id', 'name_en', 'name_np', 'parent_id', 'federal_level_type_id'])->get();

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
