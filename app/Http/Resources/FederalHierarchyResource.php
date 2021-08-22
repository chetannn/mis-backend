<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FederalHierarchyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_np' => $this->name_np,
            'parent_id' => $this->parent_id,
            'federal_level_type_id' => $this->federal_level_type_id
        ];
    }
}
