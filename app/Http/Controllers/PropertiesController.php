<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 1200);

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Labs\ImageProcessor;
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
     * Method edit
     *
     * @param Request $request [explicite description]
     * @param Property $property [explicite description]
     * @param PropertyService $propertyService [explicite description]
     * @param PropertyTypeService $propertyTypeService [explicite description]
     *
     * @return void
     */
    public function edit(Request $request, Property $property, PropertyService $propertyService, PropertyTypeService $propertyTypeService)
    {  
        return view('edit', [
            'property' => $propertyService->getById($property->id),
            'propertyTypes' => $propertyTypeService->distinct()
        ]);
    }

    public function create(Request $request, Property $property, PropertyService $propertyService, PropertyTypeService $propertyTypeService)
    {
        return view('create', [
            'propertyTypes' => $propertyTypeService->distinct()
        ]);
    }

    public function view(Request $request, Property $property, PropertyService $propertyService, PropertyTypeService $propertyTypeService)
    {
        return view('view', [
            'property' => $propertyService->getById($property->id),
            'propertyTypes' => $propertyTypeService->distinct()
        ]);
    }

    public function update(UpdatePropertyRequest $request, Property $property, PropertyService $propertyService, ImageProcessor $imageProcessor)
    {
        $data = $request->all();
        $data['image_full'] = $property->image_full;
        $data['image_thumbnail'] = $property->image_thumbnail;
        if ($request->hasFile('image_full')) {
            $uploadImage = $imageProcessor->saveFromDisk($request->image_full, 'banner', null, null, null, null);
            $uploadThumbnail = $imageProcessor->saveFromDisk($request->image_full, 'thumbnail', 'thumbnails', 100, 100, null);
            if (!$uploadImage[0]) {
                return $this->errorResponse('File was not uploaded successfully: ' . $uploadImage[1], [], 400);
            }
            $data['image_full'] = $uploadImage[1];
            $data['image_thumbnail'] = $uploadThumbnail[1];
        }
        if (!$propertyService->update($data, $property->id)) {
            return redirect()->back()->withErrors(['An error occured. Update was not successful']);
        }
        return redirect()->back()->with('status', 'Property has been successfully updated!');
    }

    public function store(StorePropertyRequest $request, Property $property, PropertyService $propertyService, ImageProcessor $imageProcessor)
    {
        $data = $request->all();
        $data['image_full'] = null;
        $data['image_thumbnail'] = null;
        $uploadImage = $imageProcessor->saveFromDisk($request->image_full, 'banner', null, null, null, null);
        $uploadThumbnail = $imageProcessor->saveFromDisk($request->image_full, 'thumbnail', 'thumbnails', 100, 100, null);
        if (!$uploadImage[0]) {
            return $this->errorResponse('File was not uploaded successfully: ' . $uploadImage[1], [], 400);
        }
        $data['image_full'] = $uploadImage[1];
        $data['image_thumbnail'] = $uploadThumbnail[1];
        
        if (!$propertyService->newFromForm($data)) {
            return redirect()->back()->withErrors(['An error occured.  Please try again']);
        }
        return redirect('/')->with('status', 'Property has been successfully created!');
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
