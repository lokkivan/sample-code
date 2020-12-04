<?php

namespace App\Http\Resources;

use App\Helpers\LayoutFileHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class LayoutFile extends JsonResource
{
    /**
     * @var string
     */
    private $host;

    /**
     * LayoutFile constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->host = env('APP_HUB_ADMIN_HOST', false);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'file_type' => LayoutFileHelper::getFileType($this->file_name),
            'layout_id' => $this->layout_id,
            'url' => $this->host . '/api/get-file?type=layout&path=' . $this->file_name,
        ];
    }
}
