<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 1200);

use App\Models\Property;
use App\Services\PropertyService;
use App\Services\PropertyTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PropertiesController extends Controller
{    
    
    /** 
     * @param Request $request 
     * @param PropertyService $propertyService
     * @param PropertyTypeService $propertyTypeService
     *
     * @return void
     */
    public function index(Request $request, PropertyService $propertyService, PropertyTypeService $propertyTypeService)
    {  
        return view('welcome', [
            'properties' => $propertyService->list(),
            'propertyTypes' => $propertyTypeService->distinct()
        ]);
    }
    
    /** 
     * @param Request $request
     * @param Property $property
     * @param PropertyService $propertyService
     *
     * @return void
     */
    public function delete(Request $request, Property $property, PropertyService $propertyService)
    { 
        if (!$propertyService->delete($property->id)) {
            return redirect()->back()->withErrors(['An error occured. Property was no deleted']);
        }
        return redirect('/')->with('status', 'Property has been successfully deleted!');
    }
    
    /** 
     * @param Request $request
     * @param PropertyService $propertyService
     * @param PropertyTypeService $propertyTypeService
     *
     * @return void
     */
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
    
    /**
     * @param ?string $string
     *
     * @return string
     */
    protected function clean(?string $string): ?string
    {
        return $string !== null ? preg_replace("#[^a-z0-9 ]#i", "", $string) : null;
    }
}
