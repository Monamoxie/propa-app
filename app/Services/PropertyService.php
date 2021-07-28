<?php 

namespace App\Services;

use App\Models\Property;

class PropertyService
{    
    /**
     * @param object $data
     *
     * @return bool
     */
    public function newFromApi(object $data): bool
    { 
        $property = new Property;
        $property->uuid = $data->uuid;
        $property->property_type_id = 4;
        $property->county = $data->county;
        $property->country = $data->country;
        $property->town = $data->town;
        $property->description = $data->description;
        $property->address = $data->address;
        $property->image_full = $data->image_full;
        $property->image_thumbnail = $data->image_thumbnail;
        $property->latitude = $data->latitude;
        $property->longitude = $data->longitude;
        $property->num_bedrooms = $data->num_bedrooms;
        $property->num_bathrooms = $data->num_bathrooms;
        $property->price = $data->price;
        $property->type = $data->type;
        $property->created_at = $data->created_at;
        $property->updated_at = $data->updated_at;
        if ($property->save()) {
            return true;
        }
        return false;
    }
    
    /** 
     * @return void
     */
    public function list() 
    {
        return Property::with(['propertyType'])->paginate(15);
    }
    
    /** 
     * @return bool
     */
    public function delete(int $id): ?bool
    {
        return Property::where('id', $id)->delete();
    }
    
    /** 
     * @param null|string $town 
     * @param null|string $numBedrooms 
     * @param null|string $price 
     * @param null|string $propertyTypeId 
     * @param null|string $type 
     *
     * @return void
     */
    public function search(?string $town, ?string $numBedrooms, ?string $price, ?string $propertyTypeId, ?string $type) 
    {
        return Property::with(['PropertyType'])
            ->where('town', 'LIKE', "%{$town}%")
            ->where('num_bedrooms', 'LIKE', "%{$numBedrooms}%")
            ->where('price', 'LIKE', "%{$price}%")
            ->where('property_type_id', 'LIKE', "%{$propertyTypeId}%")
            ->where('type', 'LIKE', "%{$type}%")
            ->paginate(15);
    }

}