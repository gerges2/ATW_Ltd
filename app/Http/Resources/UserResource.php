<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // public function toArray(Request $request): array
    // {
        // return parent::toArray($request);
        
    // }
    public function toArray(Request $request): array
    {
        return [
            "name"=>$this[0]->Name,
"email"=>$this[0]->email,
"password"=>$this[0]->password,
"Phone_number"=>$this[0]->Phone_number,
"token" => $this[1]
        ];
    }
}
