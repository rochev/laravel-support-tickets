<?php

namespace Rochev\Laravel\SupportTickets\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Rochev\Laravel\SupportTickets\Entities\Ticket;

/**
 * Class TicketResource
 *
 * @property Ticket $resource
 */
class TicketResource extends Resource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'message' => $this->resource->message,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'deleted_at' => $this->resource->deleted_at,
        ];
    }
}
