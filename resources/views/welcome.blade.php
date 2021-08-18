@extends('layout.base')
@section('content')
    <section class="propa-properties-wrapper">
        @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
        @elseif ($errors->any())
        <div class="alert alert-danger text-center">
            {{ $errors->first() }}
        </div>
        @endif
        <div class="propa-ladder">
            @if (count($properties) < 1)
                <div class="alert alert-warning text-center mt-4">
                    No record found
                </div>
            @else
            <div id="propa-klanx" class="py-5">
                <div class="container py-md-3">
                    <div class="row">
                        @foreach ($properties as $property)
                        <div class="propa-box-info col-lg-4 col-md-6">
                            <a href="/property/view/{{ $property->id }}">
                                <img src="{{  asset("storage/" . $property->image_full) }}" class="img-fluid" alt="">
                            </a>
                            <p>{{ ucfirst($property->type) }}</p>
                            <div class="info-bg">
                                <h5><a href="/">{{ $property->address }}</a></h5>
                                <ul>
                                    <li><span class="fa fa-bed"></span> {{ $property->num_bedrooms }} Bedrooms</li>
                                    <li><span class="fa fa-bath"></span> {{ $property->num_bathrooms }} Baths</li>
                                </ul>
                                <div class="d-flex bt-row">
                                    <h5> ${{ $property->price }} </h5>
                                    <a href="/property/edit/{{ $property->id }}" class="btn btn-primary mr-2">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="/property/delete/{{ $property->id }}" class="btn btn-danger">X</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="pagination-wrapper d-flex justify-content-center">{!! $properties->links() !!}</div>
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection
