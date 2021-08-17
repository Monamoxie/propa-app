<?php 

namespace App\Services;

use App\Labs\ImageProcessor;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PropertyService
{    
    /**
     * @param object $data
     *
     * @return bool
     */
    public function newFromApi(object $data): bool
    { 
        $imageProcessor = new ImageProcessor;
        if (!$this->isExisting($data->uuid)) {
            
            $fullImageName = $imageProcessor->saveFromUrl($data->image_full, $data->uuid);
            $thumbnailImageName = $imageProcessor->saveFromUrl($data->image_thumbnail, $data->uuid, 'thumbnails');
            $property = new Property;
            $property->uuid = $data->uuid;
            $property->property_type_id = 4;
            $property->county = $data->county;
            $property->country = $data->country;
            $property->town = $data->town;
            $property->description = $data->description;
            $property->address = $data->address;
            $property->image_full = $fullImageName;
            $property->image_thumbnail = $thumbnailImageName;
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
        }
        
        return false;
    }
    
    /**
     * @param string $uuid
     *
     * @return bool
     */
    public function isExisting(string $uuid): bool
    {
        return Property::where('uuid', $uuid)->exists();
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
    
    /**
     *
     * @return void
     */
    public function loadFromApi()
    {
        $nextPageUrl = config('propa.api_endpoint');
        $currPage = 1; $lastPage = 2;
        $this->refreshTable();
        while ($currPage < $lastPage) {
            $response = Http::get($nextPageUrl, [
                'api_key' => config('propa.api_key'),
                'page[size]' => 100,
                'page[number]' => $currPage
            ]);
            $propertyTypeService = new PropertyTypeService;
            if ($response->successful()) {
                $content = json_decode($response->body());
                $currPage++;
                $lastPage = $content->last_page;
                $data = $content->data;
                if (count($data) > 0) {
                    foreach ($data as $propa) {
                        DB::beginTransaction();
                        if ($propertyTypeService->newFromApi($propa->property_type)) {
                            unset($propa->property_type);
                            $this->newFromApi($propa);
                        }
                        DB::commit();
                    }
                }
                
            } else {
                return 'An error occured some the properties';
                break;
            }
        }
        return 'API call has been successfully loaded!';
    }

    protected function refreshTable()
    {
        return DB::table('properties')->delete();
    }

}