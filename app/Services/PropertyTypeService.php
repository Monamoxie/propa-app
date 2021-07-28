<?php 

namespace App\Services;

use App\Models\PropertyType;
use Illuminate\Support\Facades\Log;

class PropertyTypeService
{
    public function newFromApi(object $data): bool
    {  
        if (PropertyType::firstOrCreate(['id' => $data->id], (array) $data)) {
            return true;
        }
        return false;
    }

    public function distinct()
    {
        return PropertyType::distinct()->get();
    }
}