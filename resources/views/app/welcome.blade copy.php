<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        
        <!-- Styles -->
        
    </head>
    <body>
        <div class="container-fluid">

            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ url('/login') }}" class="nav-link">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/register') }}" class="nav-link">Register</a>
                                </li> 
                            @endauth
                        @endif
                    </ul> 
                </div>
                </div>
            </nav>
            <div class="row mt-5">
                {{-- {{ auth()->user()->role }} --}}
                @forelse ($data as $item)
                    
                    <div class="col-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5> 
                                <p>{{ $item->description }}</p>
                                <span>Start Time : {{ $item->start_time }}</span>
                                <span>End Time : {{ $item->end_time }}</span>
                                <span>Capacity : {{ $item->capacity }}</span> 
                            </div>
                            <div class="card-footer">
                                @if($item->price)
                                    
                                    <a href="{{ route('bookings.create', $item->id) }}" class="btn btn-sm btn-info">Book Now</a>
                                
                                @else

                                    <a href="{{ route('free.bookings.store', $item->id) }}" onclick="return confirm('Are you sure you want to book this event?')" class="btn btn-sm btn-info">Book Now</a>

                                @endif
                            </div>
                        </div>
                    </div>

                @empty
                    
                @endforelse
            </div>
        </div>
            

             
     </body>
</html>
