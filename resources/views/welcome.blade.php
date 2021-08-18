<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Propa App | A simple web app </title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />
</head>
<body class="antialiased">
    <section class="propa-header">
        <nav class="navbar navbar-expand-lg navbar-light py-lg-2 py-2">
            <div class="container">
                <a class="navbar-brand" href="/"><span class="">Propa-</span>app</a>
            </div>
        </nav>
    </section>
    <section class="propa-mini-hero">
        <div class="inner-cover portfolo-1">
            <div class="container">
                <ul class="breadcrumbs-custom-path">
                    <h3>Properties</h3>
                    <li class="active">Click to Search Property</li>
                    <li>
                        <span href="/"><span class="fa fa-search" aria-hidden="true" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseSearch"></span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="propa-properties-wrapper">
        <div class="collapse" id="collapseSearch">
            <div class="card card-body">
                <div class="container">
                    <form action="/property/search" method="GET">
                        <div class="row">
                            <div class="form-group search-term col-md-2">
                                <label>Town</label>
                                <input class="form-control" name="town" />
                            </div>
                            <div class="form-group search-term col-md-2">
                                <label>Bedrooms</label>
                                <input class="form-control" type="number" name="num_bedrooms" />
                            </div>
                            <div class="form-group search-term col-md-2">
                                <label>Price</label>
                                <input class="form-control" type="number" name="price" />
                            </div>
                            <div class="form-group search-term col-md-2">
                                <label>Property Type</label>
                                <select class="form-control" name="property_type_id">
                                    <option></option>
                                    @if(count($propertyTypes) > 0)
                                    @foreach($propertyTypes as $propertyType)
                                    <option value="{{ $propertyType->id }}"> {{ $propertyType->title }} </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group search-term col-md-2">
                                <label>Advert Type</label>
                                <select class="form-control" name="type">
                                    <option value=""></option>
                                    <option value="rent">Rent</option>
                                    <option value="sale">Sale</option>
                                </select>
                            </div>
                            <div class="form-group search-term col-md-2">
                                <button type="submit" class="btn btn-primary">Search Properties</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                            <a href="/">
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
