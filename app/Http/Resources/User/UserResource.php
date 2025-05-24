<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [ 
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];

        if($request['dashboard']) { 
            $data['created_at'] = $this->created_at->toDateTimeString();
            $data['updated_at'] = $this->updated_at->toDateTimeString();
        }

        return $data;
    }
}
