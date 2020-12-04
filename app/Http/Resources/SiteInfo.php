<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SiteCustomValues as SiteCustomValuesResourse;
use App\Http\Resources\Template as TemplateResourse;
use App\Http\Resources\Layout as LayoutResourse;

class SiteInfo extends JsonResource
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
            'id' => $this->id,
            'domain_name' => $this->domain_name,
            'logo_url' => $this->host . '/api/get-file?type=logo&site_id=' . $this->id,
            'icon_url' => $this->host . '/api/get-file?type=icon&site_id=' . $this->id,
            'custom_values' => SiteCustomValuesResourse::collection($this->siteCustomValues),
            'template' => new TemplateResourse($this->template),
            'layout' => LayoutResourse::collection($this->layouts),
        ];
    }
}
