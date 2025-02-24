<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial=1.0">
    <title>Event Management System</title>
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
        .feature-section {
            background: #f8f9fa;
            padding: 60px 0;
        }
        .about-section {
            background: #e3f2fd;
            padding: 60px 0;
        }
        .feature-card {
            background: rgba(0, 123, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .feature-card:hover {
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('tenant.register') }}">Register Your Organization</a></li>

                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid hero-section">
        <h1 class="display-4 fw-bold">Welcome to Our Event Management Platform</h1>
        <p class="typing-text" id="dynamicText"></p>
        <a href="#features" class="btn btn-light btn-lg mt-3">Explore Features</a>
    </div>
    
    <div class="container-fluid feature-section" id="features">
        <div class="container">

            <h2 class="text-dark text-center mb-4">Why Choose Us?</h2>
            <div class="row">
                <div class="col-md-4 mb-4" >
                    <div class="feature-card p-4 " style="height: 100%">
                        <h4>📅 Event Scheduling & Management</h4>
                        <p>Effortlessly create, manage, and track events with our intuitive dashboard.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" >
                    <div class="feature-card p-4 " style="height: 100%">
                        <h4>👥 Multi-Tenant Support</h4>
                        <p>Each tenant gets a dedicated workspace to manage their own events, attendees, and bookings independently.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" >
                    <div class="feature-card p-4 " style="height: 100%">
                        <h4>🎟️ Online Bookings & Registrations</h4>
                        <p>Enable attendees to book events online with instant confirmations and automated capacity tracking.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" >
                    <div class="feature-card p-4 " style="height: 100%">
                        <h4>⏳ Live Availability & Capacity Tracking</h4>
                        <p>Real-time event capacity monitoring ensures events do not get overbooked.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" >
                    <div class="feature-card p-4 " style="height: 100%">
                        <h4>🌍 Custom Domains for Each Tenant</h4>
                        <p>Every tenant can have a unique subdomain to maintain brand identity.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" >
                    <div class="feature-card p-4 " style="height: 100%">
                        <h4>💳 Secure Payment Integration</h4>
                        <p>Allow ticket purchases and event registrations with built-in secure payment gateways.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <div class="container-fluid about-section" id="about">
        <div class="container">

            <h2 class="text-dark text-center mb-4">About Our Platform</h2>
            <p class="text-dark text-center">Our Multi-Tenant Event Management Platform is designed to streamline event planning and management for businesses, organizations, and individuals. With a scalable multi-tenant architecture, each tenant gets a dedicated space to manage their events, bookings, and attendees independently while maintaining complete control over their data and branding.

                Whether you're organizing conferences, corporate meetings, workshops, or social gatherings, our platform provides a seamless experience with real-time booking management, automated notifications, capacity tracking, and role-based access control.
                
                With custom domains for each tenant, built-in analytics, and secure payment integrations, our solution is perfect for event organizers who want a powerful yet user-friendly tool.</p>
                
                <p class="mt-3">🚀 Join us today and simplify event management like never before!</p>
        </div>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const text = "Empowering Event Management with Multi-Tenancy.";
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
