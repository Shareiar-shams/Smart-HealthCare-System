@extends('layouts.viewport.app')

@section('viewport_title')
    Your Health Companion
@endsection
@section('viewport_meta')
@endsection
@section('viewport_vendor_css')
    
@endsection

@section('viewport_page_css')
    <style>
        .animate-gradient-x {
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animate-blob {
            animation: blob 7s infinite;
        }
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen py-20 bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
    
        <!-- Hero Section -->
        <section class="relative py-20 overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-10 left-10 w-72 h-72 bg-purple-500/30 rounded-full mix-blend-screen filter blur-xl opacity-40 animate-blob"></div>
                <div class="absolute top-10 right-10 w-72 h-72 bg-cyan-500/30 rounded-full mix-blend-screen filter blur-xl opacity-40 animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-10 left-20 w-72 h-72 bg-emerald-500/30 rounded-full mix-blend-screen filter blur-xl opacity-40 animate-blob animation-delay-4000"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center" data-aos="fade-down" data-aos-duration="1000">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-400">MediFuture</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-slate-300 mb-8 max-w-3xl mx-auto font-light">
                        Where cutting-edge technology meets compassionate healthcare
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        @auth
                        
                        @else
                            <a href="{{ route('register') }}" 
                            class="group relative bg-gradient-to-r from-cyan-500 to-purple-600 text-white px-8 py-4 rounded-2xl font-semibold hover:scale-105 transition-all duration-500 shadow-2xl hover:shadow-cyan-500/25">
                                <span class="relative z-10">Begin Journey</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-cyan-500 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </a>
                            <a href="{{ route('login') }}" 
                            class="group relative border-2 border-cyan-400 text-cyan-400 px-8 py-4 rounded-2xl font-semibold hover:bg-cyan-400 hover:text-slate-900 transition-all duration-500 backdrop-blur-sm">
                                <span>Sign In</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Grid -->
        <section class="py-20 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl font-bold text-white mb-4">Revolutionary Healthcare Experience</h2>
                    <p class="text-lg text-slate-400">Designed for the future of medicine</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative bg-slate-800/80 backdrop-blur-xl rounded-xl p-8 text-center border border-slate-700/50 hover-lift">
                            <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-robot text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent mb-4">AI Diagnostics</h3>
                            <p class="text-slate-300 leading-relaxed">Advanced neural networks analyze your health data with unprecedented accuracy and speed.</p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative bg-slate-800/80 backdrop-blur-xl rounded-xl p-8 text-center border border-slate-700/50 hover-lift">
                            <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-heart-pulse text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent mb-4">Live Monitoring</h3>
                            <p class="text-slate-300 leading-relaxed">Real-time health tracking with smart alerts and predictive analytics.</p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group relative" data-aos="fade-up" data-aos-delay="300">
                        <div class="absolute -inset-1 bg-gradient-to-r from-rose-500 to-pink-600 rounded-2xl blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative bg-slate-800/80 backdrop-blur-xl rounded-xl p-8 text-center border border-slate-700/50 hover-lift">
                            <div class="w-20 h-20 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-rose-400 to-pink-400 bg-clip-text text-transparent mb-4">Blood Network</h3>
                            <p class="text-slate-300 leading-relaxed">Join our global community of life-savers with intelligent matching technology.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Health Metrics Preview -->
    

        <!-- AI Predictions -->
        <section class="py-20 relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl font-bold text-white mb-4">Predictive Health Intelligence</h2>
                    <p class="text-lg text-slate-400">AI-powered risk assessment and prevention</p>
                </div>

                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-8 shadow-2xl border border-slate-700" data-aos="zoom-in">
                    <div class="flex items-center justify-between mb-12">
                        <h2 class="text-3xl font-bold text-white">Neural Health Analysis</h2>
                        <div class="flex items-center space-x-3 bg-cyan-500/20 px-4 py-2 rounded-full border border-cyan-500/30">
                            <div class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-cyan-300">Deep Learning Active</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php
                        $predictions = [
                            ['risk' => '8%', 'disease' => 'Cardiac Health', 'icon' => '💓', 'color' => 'from-emerald-400 to-cyan-500', 'bg' => 'bg-gradient-to-br'],
                            ['risk' => '22%', 'disease' => 'Metabolic', 'icon' => '🩸', 'color' => 'from-amber-400 to-orange-500', 'bg' => 'bg-gradient-to-br'],
                            ['risk' => '5%', 'disease' => 'Respiratory', 'icon' => '🫁', 'color' => 'from-teal-400 to-blue-500', 'bg' => 'bg-gradient-to-br'],
                            ['risk' => '15%', 'disease' => 'Neurological', 'icon' => '🧠', 'color' => 'from-purple-400 to-pink-500', 'bg' => 'bg-gradient-to-br']
                        ];
                        ?>
                        
                        @foreach($predictions as $prediction)
                        <div class="group {{ $prediction['bg'] }} {{ $prediction['color'] }} rounded-2xl p-6 text-center text-white hover-scale transform hover:rotate-1 transition-all duration-500 shadow-lg border border-white/10">
                            <div class="text-3xl mb-3 transform group-hover:scale-110 transition-transform duration-300">{{ $prediction['icon'] }}</div>
                            <div class="text-2xl font-bold mb-1">{{ $prediction['risk'] }}</div>
                            <div class="text-xs opacity-90 font-light">{{ $prediction['disease'] }}</div>
                            <div class="w-full bg-white/20 rounded-full h-1 mt-3">
                                <div class="bg-white h-1 rounded-full transition-all duration-1000" style="width: {{ str_replace('%', '', $prediction['risk']) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Learning Center -->
        <section class="py-20 bg-gradient-to-br from-purple-900/30 to-fuchsia-900/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl font-bold text-white mb-4">Medical Intelligence Hub</h2>
                    <p class="text-lg text-slate-400">Master healthcare with immersive learning</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group" data-aos="fade-up" data-aos-delay="100">
                        <div class="bg-slate-800/80 backdrop-blur-lg rounded-2xl p-8 text-center border border-slate-700/40 hover-lift shadow-xl hover:shadow-2xl">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-fuchsia-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-brain text-white text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-3">Anatomy Master</h4>
                            <p class="text-slate-300 leading-relaxed">Interactive 3D exploration of human anatomy with AR integration.</p>
                        </div>
                    </div>
                    <div class="group" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-slate-800/80 backdrop-blur-lg rounded-2xl p-8 text-center border border-slate-700/40 hover-lift shadow-xl hover:shadow-2xl">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-syringe text-white text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-3">Surgery Sim</h4>
                            <p class="text-slate-300 leading-relaxed">Virtual reality surgical training with real-time feedback.</p>
                        </div>
                    </div>
                    <div class="group" data-aos="fade-up" data-aos-delay="300">
                        <div class="bg-slate-800/80 backdrop-blur-lg rounded-2xl p-8 text-center border border-slate-700/40 hover-lift shadow-xl hover:shadow-2xl">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-stethoscope text-white text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-3">Diagnosis AI</h4>
                            <p class="text-slate-300 leading-relaxed">AI-powered diagnostic challenges with expert analysis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Emergency Section -->
        <section class="py-20 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl font-bold text-white mb-4">Emergency Response Network</h2>
                    <p class="text-lg text-slate-400">Instant access when every second counts</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="group" data-aos="zoom-in" data-aos-delay="100">
                        <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl p-8 text-center text-white shadow-2xl hover:shadow-red-500/25 transition-all duration-500 hover:scale-105 border border-red-400/20">
                            <i class="fas fa-ambulance text-white text-4xl mb-4 transform group-hover:scale-110 transition-transform duration-300"></i>
                            <h3 class="text-2xl font-bold mb-2">Emergency Rescue</h3>
                            <div class="text-3xl font-bold mb-3">911</div>
                            <p class="text-red-100 text-sm">24/7 emergency medical response team</p>
                        </div>
                    </div>
                    
                    <div class="group" data-aos="zoom-in" data-aos-delay="200">
                        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-8 text-center text-white shadow-2xl hover:shadow-blue-500/25 transition-all duration-500 hover:scale-105 border border-blue-400/20">
                            <i class="fas fa-hospital text-white text-4xl mb-4 transform group-hover:scale-110 transition-transform duration-300"></i>
                            <h3 class="text-2xl font-bold mb-2">Medical Centers</h3>
                            <div class="text-3xl font-bold mb-3">112</div>
                            <p class="text-blue-100 text-sm">Nearest healthcare facilities locator</p>
                        </div>
                    </div>
                    
                    <div class="group" data-aos="zoom-in" data-aos-delay="300">
                        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-8 text-center text-white shadow-2xl hover:shadow-emerald-500/25 transition-all duration-500 hover:scale-105 border border-emerald-400/20">
                            <i class="fas fa-hand-holding-medical text-white text-4xl mb-4 transform group-hover:scale-110 transition-transform duration-300"></i>
                            <h3 class="text-2xl font-bold mb-2">Crisis Support</h3>
                            <div class="text-3xl font-bold mb-3">108</div>
                            <p class="text-emerald-100 text-sm">Mental health and crisis intervention</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden border-t border-slate-700">
            <!-- Animated stars -->
            <div class="absolute inset-0">
                <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-cyan-300 rounded-full animate-pulse"></div>
                <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-purple-300 rounded-full animate-pulse animation-delay-1000"></div>
                <div class="absolute bottom-1/3 left-1/3 w-1 h-1 bg-emerald-300 rounded-full animate-pulse animation-delay-2000"></div>
            </div>
            
            <div class="relative max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    Begin Your Health Revolution
                </h2>
                <p class="text-xl text-cyan-100 mb-8 max-w-2xl mx-auto">
                    Join the future of personalized healthcare today
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                        class="group relative bg-gradient-to-r from-cyan-500 to-purple-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:scale-105 transition-all duration-500 shadow-2xl hover:shadow-cyan-500/25 border border-cyan-400/20">
                            <span class="relative z-10">Launch Dashboard</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-cyan-500 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                        class="group relative bg-gradient-to-r from-cyan-500 to-purple-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:scale-105 transition-all duration-500 shadow-2xl hover:shadow-cyan-500/25 border border-cyan-400/20">
                            <span class="relative z-10">Start Free Trial</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-cyan-500 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        </a>
                        <a href="{{ route('login') }}" 
                        class="group border-2 border-cyan-400 text-cyan-400 px-10 py-4 rounded-2xl font-bold text-lg hover:bg-cyan-400 hover:text-slate-900 transition-all duration-500 backdrop-blur-sm">
                            <span>Existing User</span>
                        </a>
                    @endauth
                </div>
                <p class="text-cyan-200/60 text-sm mt-6">No credit card required • 30-day free experience</p>
            </div>
        </section>
    </div>
@endsection

@section('viewport_vendor_js')
    
@endsection

@section('viewport_page_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100
            });
        });
    </script>
@endsection