<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class sbmQueryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->location) {
            $sourceFile = storage_path('app/' . str_replace('/storage/', '', $this->location));
            $publicPath = public_path('temp/' . basename($this->location));
            
            if (!file_exists(public_path('temp'))) {
                mkdir(public_path('temp'), 0777, true);
            }

            copy($sourceFile, $publicPath);

            // 20 dakika sonra dosyayı silmek için
            $deleteTime = now()->addMinutes(20);
/*             if (!app()->isScheduled('delete-temp-file-' . basename($this->location))) {
                app()->schedule(function() use ($publicPath) {
                    if (file_exists($publicPath)) {
                        unlink($publicPath);
                    }
                }, $deleteTime);
            } */

            $location = url('temp/' . basename($this->location));
        } else {
            $location = null;
        }

        
        return [
            'id' => $this->id,
            'plate' => $this->plate,
            'user_id' => $this->user->first_name . ' ' . $this->user->last_name,
            'location' => $location,
            'ended_date' => $this->ended_date->format('Y-m-d H:i'),
        ];
    }
    
}
