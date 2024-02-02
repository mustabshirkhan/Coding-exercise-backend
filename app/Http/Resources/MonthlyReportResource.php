<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MonthlyReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'month' => $this->resource->first()->month,
            'year' => $this->resource->first()->year,
            'paid' => $this->resource->sum('paid'),
            'outstanding' => $this->resource->sum('outstanding'),
            'overdue' => $this->resource->sum('overdue'),
        ];
    }
}
