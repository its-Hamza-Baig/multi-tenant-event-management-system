<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial=1.0">
    <title>Tenant Event Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: white;
            color: #007bff;
            text-align: center;
        }
        .navbar {
            background: #00356d;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .navbar-brand, .nav-link {
            color: white !important;
            transition: all 0.3s ease-in-out;
            padding: 8px 15px;
            border-radius: 5px;
        }
        .nav-link:hover {
            color: #ffcc00 !important;
            background: rgba(255, 255, 255, 0.2);
        }
        .hero-section {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #00438a, #008db6);
            color: white;
        }
        .typing-text {
            font-size: 24px;
            font-weight: bold;
            min-height: 30px;
        }
        .event-section {
            background: #f8f9fa;
            padding: 60px 0;
        }
        .event-card {
            background: rgba(26, 28, 30, 0.1);
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .event-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky">
        <div class="container">
            <a class="navbar-brand" href="#">Event Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @endauth
                    @endif 
                    <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid hero-section">
        <h1 class="display-4 fw-bold">Welcome to Our Event Management Platform</h1>
        <p class="typing-text" id="dynamicText"></p>
        <a href="#events" class="btn btn-light btn-lg mt-3">View Events</a>
    </div>
    
    <div class="container-fluid event-section" id="events">
        <div class="container">
            <h2 class="text-dark text-center mb-4">Upcoming Events</h2>
            <div class="row">
                @forelse($data as $item)
                    <div class="col-md-4 mb-4">
                        <div class="event-card p-4">
                            <h4 class="card-title">{{ $item->title }}</h4>
                            <p>{{ $item->description }}</p>
                            <p><strong>Start Time:</strong> {{ Carbon\Carbon::parse($item->start_time)->format('Y m d h:i A') }}</p>
                            <p><strong>End Time:</strong>  {{ Carbon\Carbon::parse($item->end_time)->format('Y m d h:i A') }}</p>
                            <p><strong>Capacity:</strong> {{ $item->capacity }}</p>
                            <div class="card-footer text-center">
                                @if($item->price)
                                    <a href="{{ route('bookings.create', $item->id) }}" class="btn btn-info">Book Now</a>
                                @else
                                    <a href="{{ route('free.bookings.store', $item->id) }}" onclick="return confirm('Are you sure you want to book this event?')" class="btn btn-info">Book Now</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty

                    <div class="col-12 text-center">
                        <p class="text-muted">No events available at the moment. Stay tuned for upcoming entertainment!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const text = "Bringing Entertainment to Life with Seamless Events.";
        let index = 0;
        let isDeleting = false;

        function typeEffect() {
            const dynamicText = document.getElementById("dynamicText");
            if (!isDeleting && index <= text.length) {
                dynamicText.innerHTML = text.substring(0, index);
                index++;
            } else if (isDeleting && index >= 0) {
                dynamicText.innerHTML = text.substring(0, index);
                index--;
            }
            if (index === text.length) {
                isDeleting = true;
                setTimeout(typeEffect, 1000);
            } else if (index === 0) {
                isDeleting = false;
                setTimeout(typeEffect, 500);
            } else {
                setTimeout(typeEffect, 100);
            }
        }
        typeEffect();
    </script>
</body>
</html>