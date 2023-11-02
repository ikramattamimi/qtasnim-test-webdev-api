<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public bool $success;
    public string $message;

    public function __construct($success, $message, $resource)
    {
        $this->success = $success;
        $this->message = $message;
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->resource
        ];
    }
}
