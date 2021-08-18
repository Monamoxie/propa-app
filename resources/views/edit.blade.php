@extends('layout.base')
@section('content')
    <section class="propa-properties-wrapper">
        <div class="container">
            <div class="form-container shadow">
                <h4> UPDATE PROPERTY </h4>
                <form action="/property/update/{{ $property->id }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @elseif ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group">
                        <label>Property type</label>
                        <select class="form-control" name="property_type">
                            @if(count($propertyTypes) > 0)
                                @foreach($propertyTypes as $propertyType)
                                    <option value="{{ $property->propertyType->id }}">{{ $property->propertyType->title }}</option>
                                    <option value="{{ $propertyType->id }}">{{ $propertyType->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" name="country" value="{{ $property->country }}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $property->address }}">
                    </div>
                    <div class="form-group">
                        <label>Town</label>
                        <input type="text" class="form-control" name="town" value="{{ $property->town }}">
                    </div>
                    <div class="form-group">
                        <label>County</label>
                        <input type="text" class="form-control" name="county" value="{{ $property->county }}">
                    </div>
                    <div class="form-group">
                        <label>Latitude </label>
                        <input type="text" class="form-control" name="latitude" value="{{ $property->latitude }}">
                    </div>
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="text" class="form-control" name="longitude" value="{{ $property->longitude }}">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price" value="{{ $property->price }}">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" class="form-control" name="type" value="{{ $property->type }}">
                    </div>
                    <div class="form-group">
                        <label>Number of Bathrooms</label>
                        <input type="text" class="form-control" name="num_bathrooms" value="{{ $property->num_bathrooms }}">
                    </div>
                    <div class="form-group">
                        <label>Number of Bedrooms</label>
                        <input type="text" class="form-control" name="num_bedrooms" value="{{ $property->num_bedrooms }}">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description">
                            {{ $property->description }}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Image File</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="file" class="form-control" name="image_full">
                            </div>
                            <div class="col-md-4 img-prev">
                                <img src="{{  asset("storage/" . $property->image_full) }}">
                            </div>
                        </div>
                        
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </section 
@endsection
