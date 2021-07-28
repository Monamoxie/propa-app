<?php 

namespace App\Services;

use App\Models\PropertyType;

class PropertyTypeService
{    
    /** 
     * @param object $data
     *
     * @return bool
     */
    public function newFromApi(object $data): bool
    {  
        if (PropertyType::firstOrCreate(['id' => $data->id], (array) $data)) {
            return true;
        }
        return false;
    }
    
    /** 
     * @return void
     */
    public function distinct()
    {
        return PropertyType::distinct()->get();
    }
}