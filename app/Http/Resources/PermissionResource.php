<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * 响应数据通过类来管理
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
