@extends('layout.base')
@section('content')
    <section class="propa-properties-wrapper">
        <div class="container">
            <div class="row property-viewer">
                <div class="col-md-7">
                    <img src="{{  asset("storage/" . $property->image_full) }}">
                </div>
                <div class="col-md-5">
                    <p> <span> Property Type </span>: {{ $property->propertyType->title }} </p>
                    <p> <span> Country </span>: {{ $property->country }} </p>
                    <p> <span> County </span>: {{ $property->county }} </p>
                    <p> <span> Town </span>: {{ $property->town }} </p>
                    <p> <span> Latitude </span>: {{ $property->latitude }} </p>
                    <p> <span> Longitude </span>: {{ $property->longitude }} </p>
                    <p> <span> Number of Bedrooms </span>: {{ $property->num_bedrooms }} </p>
                    <p> <span> Number of Bathrooms </span>: {{ $property->num_bathrooms }} </p>
                    <p> <span> Price </span>: {{ $property->price }} </p>
                    <p> <span> Type </span>: {{ $property->type }} </p>
                    <div class="mt-4"> 
                     <a href="/property/edit/{{ $property->id }}" class="btn btn-primary mr-2">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="/property/delete/{{ $property->id }}" class="btn btn-danger">X Delete</a>
                    <div>
                </div>
            </div>
        </div>
    </section>
@endsection
