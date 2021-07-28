<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 600);

use App\Models\Property;
use App\Services\PropertyService;
use App\Services\PropertyTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PropertiesController extends Controller
{
    public function loadFromApi(Request $request, PropertyTypeService $propertyTypeService, PropertyService $propertyService)
    {  
        $nextPageUrl = 'https://trial.craig.mtcserver15.com/api/properties';
        $currPage = 1; $lastPage = 2;
        while ($currPage < 2) {
            $response = Http::get($nextPageUrl, [
                'api_key' => '2S7rhsaq9X1cnfkMCPHX64YsWYyfe1he',
                'page[size]' => 100,
                'page[number]' => $currPage
            ]);
            if ($response->successful()) {
                $content = json_decode($response->body());
                $currPage = $content->current_page + 1;
                $lastPage = $content->last_page;
                Log::error('Current Page', [$currPage]);
                $data = $content->data;
                if (count($data) > 0) {
                    foreach ($data as $propa) {
                        DB::beginTransaction();
                        if ($propertyTypeService->newFromApi($propa->property_type)) {
                            unset($propa->property_type);
                            $propertyService->newFromApi($propa);
                        }
                        DB::commit();
                    }
                }
                
            } else {
               Log::error('An error occured loading the properties', []);
               break;
            }
        }
 
        return redirect('/')->with('status', 'API call has been successfully loaded!');
    }

    public function index(Request $request, PropertyService $propertyService, PropertyTypeService $propertyTypeService)
    { 
        return view('welcome', [
            'properties' => $propertyService->list(),
            'propertyTypes' => $propertyTypeService->distinct()
        ]);
    }

    public function delete(Request $request, Property $property, PropertyService $propertyService)
    { 
        if (!$propertyService->delete($property->id)) {
            return redirect()->back()->withErrors(['An error occured. Property was no deleted']);
        }
        return redirect('/')->with('status', 'Property has been successfully deleted!');
    }

    public function search(Request $request, PropertyService $propertyService, PropertyTypeService $propertyTypeService)
    { 
        return view('welcome', [
            'properties' => $propertyService->search(
                $this->clean($request->town), $this->clean($request->num_bedrooms), $this->clean($request->price), 
                $this->clean($request->property_type_id), $this->clean($request->type), 
            ),
            'propertyTypes' => $propertyTypeService->distinct()
        ]);
    }

    protected function clean(?string $string): ?string
    {
        return $string !== null ? preg_replace("#[^a-z0-9 ]#i", "", $string) : null;
    }
}
