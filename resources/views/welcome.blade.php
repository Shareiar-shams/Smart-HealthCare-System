<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset(config('app.favicon')) }}" type="image/x-icon">
    <title>Smart Healthcare Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/landing.css') }}">
    
</head>
<body>
    <div class="landing-container">
        <div class="content-wrapper">
            <div class="text-content">
                <div class="logo">
                    {{-- <div class="logo-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div> --}}
                    <div class="logo-text"><img src="{{ asset(config('app.logo')) }}" alt="logo"></div>
                </div>
                
                <h1>Smart Healthcare Management System</h1>
                <p class="subtitle">
                    Streamline your healthcare operations with our intelligent, integrated platform designed for modern medical facilities.
                </p>

                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Patient Records Management</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Appointment Scheduling</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Real-time Analytics & Reports</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Secure & HIPAA Compliant</span>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="cta-button">
                    Get Started
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="image-content">
                <div class="healthcare-image">
                    <div class="image-placeholder">
                        <div class="medical-icon-group">
                            <div class="medical-icon">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <div class="medical-icon">
                                <i class="fas fa-hospital"></i>
                            </div>
                            <div class="medical-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="medical-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="medical-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <div class="medical-icon">
                                <i class="fas fa-notes-medical"></i>
                            </div>
                        </div>

                        <div class="stats-overlay">
                            <div class="stat-item">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Support</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">10K+</div>
                                <div class="stat-label">Patients</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">99.9%</div>
                                <div class="stat-label">Uptime</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>