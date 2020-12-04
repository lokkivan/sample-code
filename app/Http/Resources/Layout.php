<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LayoutFile as LayoutFileResourse;

class Layout extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->layoutFiles) {
            $layoutFile = LayoutFileResourse::collection($this->layoutFiles);
        }   else {
            $layoutFile = null;
        }
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'files' => $layoutFile,
        ];
    }
}
