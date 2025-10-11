@extends('layouts.viewport.app')

@section('viewport_title')
    Medical Learning & Resources Hub
@endsection
@section('viewport_meta')
@endsection
@section('viewport_vendor_css')
@endsection

@section('viewport_page_css')
    <style>
        /* Fix for navbar overlap */
        nav {
            z-index: 9999 !important;
        }
        body {
            padding-top: 80px; /* Adjust based on your navbar height */
        }
        /* Ensure all content stays below navbar */
        .content-wrapper, .max-w-7xl, .container, main {
            position: relative;
            z-index: 1;
        }
        
        .neuro-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
        }
        .hologram-effect {
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            background-size: 200% 200%;
            animation: hologram 3s ease-in-out infinite;
        }
        @keyframes hologram {
            0% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }
        .resource-card {
            transition: all 0.3s ease;
        }
        .resource-card:hover {
            transform: translateY(-5px) scale(1.02);
        }
        .star-rating {
            color: #fbbf24;
        }
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }
        @keyframes pulse-glow {
            from { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            to { box-shadow: 0 0 30px rgba(59, 130, 246, 0.8), 0 0 40px rgba(59, 130, 246, 0.6); }
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .tab-button {
            transition: all 0.3s ease;
        }
        .tab-button.active {
            background: rgba(59, 130, 246, 0.2);
            border-color: rgba(59, 130, 246, 0.5);
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <div class="inline-block mb-6">
            <div class="hologram-effect rounded-2xl p-1">
                <h1 class="text-6xl font-bold bg-gradient-to-r from-emerald-400 via-cyan-400 to-blue-400 bg-clip-text text-transparent mb-4">
                    Medical Learning & Resources Hub
                </h1>
            </div>
        </div>
        <p class="text-xl text-gray-300 max-w-4xl mx-auto mb-8 leading-relaxed">
            Your ultimate destination for <span class="text-emerald-400 font-semibold">medical education</span>, 
            <span class="text-cyan-400 font-semibold">interactive learning</span>, 
            <span class="text-blue-400 font-semibold">3D anatomy exploration</span>, and 
            <span class="text-purple-400 font-semibold">curated resources</span>. 
            Empowering medical students and professionals worldwide.
        </p>

        <!-- Tab Navigation -->
        <div class="max-w-4xl mx-auto mb-12">
            <div class="flex justify-center space-x-4">
                <button id="learning-tab" class="tab-button neuro-glass text-white px-6 py-3 rounded-2xl font-semibold active flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>Learning Modules
                </button>
                <button id="resources-tab" class="tab-button neuro-glass text-white px-6 py-3 rounded-2xl font-semibold flex items-center">
                    <i class="fas fa-book-medical mr-2"></i>Medical Resources
                </button>
                <button id="anatomy-tab" class="tab-button neuro-glass text-white px-6 py-3 rounded-2xl font-semibold flex items-center">
                    <i class="fas fa-cube mr-2"></i>3D Anatomy
                </button>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="learning-content" class="tab-content active">
        <!-- Learning Modules Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-16">
            <!-- Module data would come from backend in real app -->
            <div class="neuro-glass rounded-3xl overflow-hidden transform hover:scale-105 transition-all duration-500 hover:shadow-2xl">
                <!-- Module Header -->
                <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-heartbeat text-2xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-white/80 text-sm">Progress</div>
                            <div class="text-2xl font-bold text-white">65%</div>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Cardiovascular System</h3>
                    <p class="text-white/80 text-sm">Master heart anatomy, physiology, and common pathologies</p>
                </div>

                <!-- Progress Bar -->
                <div class="px-6 pt-4">
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>

                <!-- Module Content -->
                <div class="p-6">
                    <!-- Features -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border border-cyan-500/20">
                            3D Heart Models
                        </span>
                        <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border border-cyan-500/20">
                            ECG Interpretation
                        </span>
                        <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border border-cyan-500/20">
                            Case Studies
                        </span>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-cyan-400">12</div>
                            <div class="text-xs text-gray-400">Topics</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-purple-400">8h</div>
                            <div class="text-xs text-gray-400">Duration</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-pink-400">24</div>
                            <div class="text-xs text-gray-400">Resources</div>
                        </div>
                    </div>

                    <!-- Expert -->
                    <div class="flex items-center space-x-3 p-3 bg-gray-800/50 rounded-xl mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-md text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">Dr. Sarah Chen</div>
                            <div class="text-xs text-gray-400">Cardiologist</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-gradient-to-r from-cyan-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            Enter Module
                        </button>
                        <button class="px-4 bg-gray-700 text-white rounded-xl hover:bg-gray-600 transition-all duration-300">
                            <i class="fab fa-youtube"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Additional modules would go here -->
            <div class="neuro-glass rounded-3xl overflow-hidden transform hover:scale-105 transition-all duration-500 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-brain text-2xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-white/80 text-sm">Progress</div>
                            <div class="text-2xl font-bold text-white">42%</div>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Neuroanatomy</h3>
                    <p class="text-white/80 text-sm">Explore brain structures and neurological pathways</p>
                </div>
                <div class="px-6 pt-4">
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 h-2 rounded-full" style="width: 42%"></div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border border-purple-500/20">
                            3D Brain Models
                        </span>
                        <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border border-purple-500/20">
                            Clinical Cases
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-cyan-400">15</div>
                            <div class="text-xs text-gray-400">Topics</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-purple-400">12h</div>
                            <div class="text-xs text-gray-400">Duration</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-pink-400">18</div>
                            <div class="text-xs text-gray-400">Resources</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-800/50 rounded-xl mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-md text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">Dr. Michael Rodriguez</div>
                            <div class="text-xs text-gray-400">Neurologist</div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-gradient-to-r from-purple-500 to-pink-600 text-white py-3 rounded-xl font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            Enter Module
                        </button>
                        <button class="px-4 bg-gray-700 text-white rounded-xl hover:bg-gray-600 transition-all duration-300">
                            <i class="fab fa-youtube"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="neuro-glass rounded-3xl overflow-hidden transform hover:scale-105 transition-all duration-500 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-lungs text-2xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-white/80 text-sm">Progress</div>
                            <div class="text-2xl font-bold text-white">28%</div>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Respiratory System</h3>
                    <p class="text-white/80 text-sm">Lung anatomy, gas exchange, and pulmonary diseases</p>
                </div>
                <div class="px-6 pt-4">
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-2 rounded-full" style="width: 28%"></div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border border-green-500/20">
                            3D Lung Models
                        </span>
                        <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border border-green-500/20">
                            Spirometry
                        </span>
                        <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border border-green-500/20">
                            X-Ray Reading
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-cyan-400">10</div>
                            <div class="text-xs text-gray-400">Topics</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-purple-400">6h</div>
                            <div class="text-xs text-gray-400">Duration</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-pink-400">16</div>
                            <div class="text-xs text-gray-400">Resources</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-800/50 rounded-xl mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-md text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">Dr. Emily Watson</div>
                            <div class="text-xs text-gray-400">Pulmonologist</div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            Enter Module
                        </button>
                        <button class="px-4 bg-gray-700 text-white rounded-xl hover:bg-gray-600 transition-all duration-300">
                            <i class="fab fa-youtube"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Sessions Section -->
        <div class="neuro-glass rounded-3xl p-8 mb-16">
            <h2 class="text-4xl font-bold text-center text-white mb-8">🎥 Live Expert Sessions</h2>
            <p class="text-gray-300 text-center mb-8 max-w-2xl mx-auto">
                Join real-time sessions with world-renowned medical professionals. Interactive Q&A, live demonstrations, and case discussions.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Session 1 -->
                <div class="bg-gradient-to-br from-purple-500/10 to-blue-600/10 border border-purple-500/20 rounded-2xl p-6 hover:border-purple-500/40 transition-all duration-300">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <div>
                            <div class="text-white font-semibold">Cardiac Surgery Live</div>
                            <div class="text-cyan-400 text-sm">Starts in 2:15:00</div>
                        </div>
                    </div>
                    <div class="text-gray-300 text-sm mb-4">Live coronary artery bypass graft demonstration with Dr. Sarah Chen</div>
                    <button class="w-full bg-gradient-to-r from-purple-500 to-blue-600 text-white py-2 rounded-xl font-semibold hover:shadow-lg transition-all">
                        Join Session
                    </button>
                </div>

                <!-- Session 2 -->
                <div class="bg-gradient-to-br from-green-500/10 to-emerald-600/10 border border-green-500/20 rounded-2xl p-6 hover:border-green-500/40 transition-all duration-300">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-brain text-white"></i>
                        </div>
                        <div>
                            <div class="text-white font-semibold">Neuroanatomy Masterclass</div>
                            <div class="text-cyan-400 text-sm">Tomorrow, 10:00 AM</div>
                        </div>
                    </div>
                    <div class="text-gray-300 text-sm mb-4">3D brain dissection and clinical correlations with Dr. Michael Rodriguez</div>
                    <button class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-2 rounded-xl font-semibold hover:shadow-lg transition-all">
                        Set Reminder
                    </button>
                </div>

                <!-- Session 3 -->
                <div class="bg-gradient-to-br from-orange-500/10 to-red-600/10 border border-orange-500/20 rounded-2xl p-6 hover:border-orange-500/40 transition-all duration-300">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-lungs text-white"></i>
                        </div>
                        <div>
                            <div class="text-white font-semibold">Pulmonary Case Review</div>
                            <div class="text-cyan-400 text-sm">Live Now</div>
                        </div>
                    </div>
                    <div class="text-gray-300 text-sm mb-4">Complex COPD management and ventilator settings with Dr. Emily Watson</div>
                    <button class="w-full bg-gradient-to-r from-orange-500 to-red-600 text-white py-2 rounded-xl font-semibold hover:shadow-lg transition-all pulse-glow">
                        Join Now 🔊
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="resources-content" class="tab-content">
        <!-- Featured Resources -->
        <div class="neuro-glass rounded-3xl p-8 mb-16">
            <h2 class="text-4xl font-bold text-center text-white mb-12">⭐ Featured Resources</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Featured resources would be populated here -->
                <div class="resource-card neuro-glass rounded-2xl p-6 border border-green-500/20 hover:border-green-500/40">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-stethoscope text-white text-lg"></i>
                            </div>
                            <div>
                                <div class="text-white font-semibold">Medscape - Free Medical Reference</div>
                                <div class="text-green-400 text-sm capitalize">website</div>
                            </div>
                        </div>
                        <div class="star-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm mb-4">Comprehensive medical information, news, and education</p>
                    <a href="https://www.medscape.com" target="_blank" 
                        class="block w-full bg-gradient-to-r from-green-500 to-green-600 text-white text-center py-2 rounded-xl font-semibold hover:shadow-lg transition-all">
                        Visit Resource
                    </a>
                </div>

                <div class="resource-card neuro-glass rounded-2xl p-6 border border-purple-500/20 hover:border-purple-500/40">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-heartbeat text-white text-lg"></i>
                            </div>
                            <div>
                                <div class="text-white font-semibold">Osmosis - Medical Education</div>
                                <div class="text-purple-400 text-sm capitalize">website</div>
                            </div>
                        </div>
                        <div class="star-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm mb-4">Video-based medical education platform</p>
                    <a href="https://www.osmosis.org" target="_blank" 
                        class="block w-full bg-gradient-to-r from-purple-500 to-purple-600 text-white text-center py-2 rounded-xl font-semibold hover:shadow-lg transition-all">
                        Visit Resource
                    </a>
                </div>

                <div class="resource-card neuro-glass rounded-2xl p-6 border border-blue-500/20 hover:border-blue-500/40">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white text-lg"></i>
                            </div>
                            <div>
                                <div class="text-white font-semibold">Khan Academy Medicine</div>
                                <div class="text-blue-400 text-sm capitalize">website</div>
                            </div>
                        </div>
                        <div class="star-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm mb-4">Free medical courses and tutorials</p>
                    <a href="https://www.khanacademy.org/science/health-and-medicine" target="_blank" 
                        class="block w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center py-2 rounded-xl font-semibold hover:shadow-lg transition-all">
                        Visit Resource
                    </a>
                </div>
            </div>
        </div>

        <!-- Resource Categories Grid -->
        <div class="mb-16">
            <h2 class="text-4xl font-bold text-center text-white mb-12">📂 Resource Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Categories would be populated here -->
                <div class="resource-card neuro-glass rounded-2xl p-6 text-center border border-white/10 hover:border-blue-600/40 cursor-pointer"
                        onclick="openTextbooksModal()">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                        <i class="fas fa-book-medical text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">📚 Medical Textbooks</h3>
                    <p class="text-gray-300 text-sm mb-3">Free medical textbooks and reference materials</p>
                    <div class="text-cyan-400 font-semibold">15 resources</div>
                </div>

                <div class="resource-card neuro-glass rounded-2xl p-6 text-center border border-white/10 hover:border-red-600/40 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                        <i class="fab fa-youtube text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">🎥 YouTube Channels</h3>
                    <p class="text-gray-300 text-sm mb-3">Top medical education YouTube channels</p>
                    <div class="text-cyan-400 font-semibold">32 resources</div>
                </div>

                <div class="resource-card neuro-glass rounded-2xl p-6 text-center border border-white/10 hover:border-green-600/40 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                        <i class="fas fa-globe text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">🌐 Medical Websites</h3>
                    <p class="text-gray-300 text-sm mb-3">Essential medical websites and portals</p>
                    <div class="text-cyan-400 font-semibold">28 resources</div>
                </div>

                <div class="resource-card neuro-glass rounded-2xl p-6 text-center border border-white/10 hover:border-purple-600/40 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                        <i class="fas fa-search text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">🔬 Research Databases</h3>
                    <p class="text-gray-300 text-sm mb-3">Medical research papers and journals</p>
                    <div class="text-cyan-400 font-semibold">15 resources</div>
                </div>
            </div>
        </div>
    </div>

    <div id="anatomy-content" class="tab-content">
        <!-- 3D Anatomy Section -->
        <div class="neuro-glass rounded-3xl p-8 mb-16">
            <h2 class="text-4xl font-bold text-center text-white mb-8">🧠 3D Anatomy Explorer</h2>
            <p class="text-gray-300 text-center mb-8 max-w-2xl mx-auto">
                Explore human anatomy with interactive 3D models. Rotate, zoom, and learn about different organs and systems.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Anatomy Cards -->
                <div class="resource-card neuro-glass rounded-2xl p-6 text-center border border-white/10 hover:border-cyan-500/40 cursor-pointer"
                        onclick="launchAnatomyExplorer()">
                    <div class="w-16 h-16 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                        <i class="fas fa-cube text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">3D Organ Explorer</h3>
                    <p class="text-gray-300 text-sm mb-3">Interactive 3D models of human organs</p>
                    <div class="text-cyan-400 font-semibold">Explore Now</div>
                </div>

                <div class="resource-card neuro-glass rounded-2xl p-6 text-center border border-white/10 hover:border-purple-500/40 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                        <i class="fas fa-vr-cardboard text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">VR Anatomy</h3>
                    <p class="text-gray-300 text-sm mb-3">Immersive virtual reality anatomy experiences</p>
                    <div class="text-cyan-400 font-semibold">Coming Soon</div>
                </div>

                <div class="resource-card neuro-glass rounded-2xl p-6 text-center border border-white/10 hover:border-green-500/40 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                        <i class="fas fa-brain text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Neuroanatomy</h3>
                    <p class="text-gray-300 text-sm mb-3">Detailed brain and nervous system models</p>
                    <div class="text-cyan-400 font-semibold">Explore Now</div>
                </div>
            </div>

            <!-- Anatomy Preview -->
            <div class="bg-gradient-to-br from-cyan-500/10 to-blue-600/10 border border-cyan-500/20 rounded-2xl p-8 text-center">
                <h3 class="text-2xl font-bold text-white mb-4">Try Our 3D Anatomy Explorer</h3>
                <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                    Click the button below to launch our interactive 3D anatomy explorer. Explore detailed models of human organs with educational information.
                </p>
                <button onclick="launchAnatomyExplorer()" 
                        class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-8 py-3 rounded-2xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105 pulse-glow">
                    <i class="fas fa-cube mr-2"></i>Launch 3D Explorer
                </button>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="neuro-glass rounded-3xl p-8 mt-16 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Stay Updated with New Resources</h2>
        <p class="text-gray-300 mb-6">Get weekly updates on new medical resources, learning modules, and expert sessions.</p>
        <div class="max-w-md mx-auto flex">
            <input type="email" placeholder="Enter your email" 
                    class="flex-1 neuro-glass text-white placeholder-gray-400 rounded-l-2xl px-4 py-3 focus:outline-none">
            <button class="bg-gradient-to-r from-emerald-500 to-cyan-600 text-white px-6 py-3 rounded-r-2xl font-semibold hover:shadow-lg transition-all">
                Subscribe
            </button>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8 z-20">
        <button class="w-14 h-14 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-full flex items-center justify-center text-white shadow-2xl pulse-glow hover:scale-110 transition-all duration-300">
            <i class="fas fa-robot text-xl"></i>
        </button>
    </div>
@endsection

@section('viewport_vendor_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aframe-animation-component@5.1.2/dist/aframe-animation-component.min.js"></script>
@endsection

@section('viewport_page_js')
    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabs = document.querySelectorAll('.tab-button');
            const contents = document.querySelectorAll('.tab-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Show corresponding content
                    const tabId = this.id.replace('-tab', '-content');
                    document.getElementById(tabId).classList.add('active');
                });
            });

            // Add hover effects to cards
            const cards = document.querySelectorAll('.resource-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // AI Assistant button
            document.getElementById('ai-assistant-btn').addEventListener('click', function() {
                alert('AI Medical Assistant activated! How can I help you with your medical learning today?');
            });
        });

        // Medical Textbooks Data
        const medicalTextbooks = [
            {
                'id': 1,
                'title': "Anatomy & Physiology",
                'author': "OpenStax College",
                'category': "Anatomy",
                'level': "All Levels",
                'pages': 1280,
                'rating': 4.7,
                'year': 2023,
                'description': "Comprehensive free anatomy textbook with illustrations and clinical correlations",
                'coverColor': "#ef4444",
                'pdfUrl': "https://openstax.org/details/books/anatomy-and-physiology-2e",
                'downloadable': true,
                'legal': true,
                'featured': true
            },
            {
                'id': 2,
                'title': "Microbiology - OpenStax",
                'author': "OpenStax",
                'category': "Microbiology",
                'level': "Intermediate",
                'pages': 1300,
                'rating': 4.6,
                'year': 2023,
                'description': "Free microbiology textbook covering pathogens, immunology, and laboratory techniques",
                'coverColor': "#06b6d4",
                'pdfUrl': "https://openstax.org/details/books/microbiology",
                'downloadable': true,
                'legal': true
            },
            // Additional textbook data would go here
        ];

        // Textbooks Modal Functions
        function openTextbooksModal() {
            const modalHTML = `
            <div id="textbooks-modal" style="position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.95); z-index:99999; padding:20px; overflow-y:auto;">
                <div style="max-w-6xl mx-auto">
                    <!-- Header -->
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; padding:20px; background:rgba(30,41,59,0.8); border-radius:15px;">
                        <div>
                            <h2 style="color:#06b6d4; font-size:2rem; margin:0;">📚 Medical Textbooks</h2>
                            <p style="color:#94a3b8; margin:5px 0 0 0;">${medicalTextbooks.length} Resources Available</p>
                        </div>
                        <button onclick="closeTextbooksModal()" style="background:#ef4444; color:white; border:none; padding:12px 24px; border-radius:10px; cursor:pointer; font-weight:bold;">
                            ✕ Close
                        </button>
                    </div>

                    <!-- Search and Filters -->
                    <div style="display:flex; gap:15px; margin-bottom:25px; flex-wrap:wrap;">
                        <input type="text" id="textbook-search" placeholder="🔍 Search textbooks..." 
                               style="flex:1; min-width:300px; padding:12px 20px; border-radius:10px; border:1px solid rgba(6,182,212,0.3); background:rgba(30,41,59,0.8); color:white;">
                        
                        <select id="category-filter" style="padding:12px 20px; border-radius:10px; border:1px solid rgba(6,182,212,0.3); background:rgba(30,41,59,0.8); color:white;">
                            <option value="all">All Categories</option>
                            <option value="Anatomy">Anatomy</option>
                            <option value="Microbiology">Microbiology</option>
                            <option value="Biochemistry">Biochemistry</option>
                            <option value="Clinical Medicine">Clinical Medicine</option>
                            <option value="Statistics">Statistics</option>
                            <option value="Pathology">Pathology</option>
                            <option value="Pharmacology">Pharmacology</option>
                            <option value="Public Health">Public Health</option>
                            <option value="Neurology">Neurology</option>
                            <option value="Emergency Medicine">Emergency Medicine</option>
                            <option value="Ethics">Ethics</option>
                            <option value="Epidemiology">Epidemiology</option>
                            <option value="Laboratory Medicine">Laboratory Medicine</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Terminology">Terminology</option>
                        </select>

                        <select id="level-filter" style="padding:12px 20px; border-radius:10px; border:1px solid rgba(6,182,212,0.3); background:rgba(30,41,59,0.8); color:white;">
                            <option value="all">All Levels</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>

                    <!-- Books Grid -->
                    <div id="textbooks-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(350px, 1fr)); gap:20px;">
                        <!-- Books will be loaded here -->
                    </div>
                </div>
            </div>`;

            document.body.insertAdjacentHTML('beforeend', modalHTML);
            renderTextbooks(medicalTextbooks);
            setupTextbookFilters();
        }

        function renderTextbooks(books) {
            const grid = document.getElementById('textbooks-grid');
            
            if (!grid) return;
            
            grid.innerHTML = books.map(book => `
                <div class="textbook-card" style="background:rgba(30,41,59,0.8); border-radius:15px; padding:20px; border:1px solid rgba(6,182,212,0.2); transition:all 0.3s ease;">
                    <!-- Book Header -->
                    <div style="display:flex; gap:15px; margin-bottom:15px;">
                        <div style="width:60px; height:80px; background:${book.coverColor}; border-radius:8px; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold; font-size:12px; text-align:center; padding:5px;">
                            ${book.title.split(' ').map(word => word[0]).join('')}
                        </div>
                        <div style="flex:1;">
                            <h3 style="color:white; margin:0 0 5px 0; font-size:1.1rem;">${book.title}</h3>
                            <p style="color:#94a3b8; margin:0; font-size:0.9rem;">By ${book.author}</p>
                            <div style="display:flex; gap:10px; margin-top:8px;">
                                <span style="background:rgba(6,182,212,0.2); color:#06b6d4; padding:2px 8px; border-radius:12px; font-size:0.8rem;">${book.category}</span>
                                <span style="background:rgba(245,158,11,0.2); color:#f59e0b; padding:2px 8px; border-radius:12px; font-size:0.8rem;">${book.level}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Book Details -->
                    <div style="color:#94a3b8; font-size:0.9rem; margin-bottom:15px;">
                        <p style="margin:0 0 8px 0;">${book.description}</p>
                        <div style="display:flex; justify-content:space-between; font-size:0.8rem;">
                            <span>📖 ${book.pages} pages</span>
                            <span>⭐ ${book.rating}/5</span>
                            <span>📅 ${book.year}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display:flex; gap:10px;">
                        <button onclick="openTextbook(${book.id})" 
                                style="flex:1; background:linear-gradient(135deg, #06b6d4, #3b82f6); color:white; border:none; padding:10px; border-radius:8px; cursor:pointer; font-weight:500;">
                            📖 Read Online
                        </button>
                        <button onclick="downloadTextbook(${book.id})" 
                                style="background:rgba(34,197,94,0.2); color:#22c55e; border:1px solid #22c55e; padding:10px 15px; border-radius:8px; cursor:pointer;">
                            ⬇️
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function setupTextbookFilters() {
            const searchInput = document.getElementById('textbook-search');
            const categoryFilter = document.getElementById('category-filter');
            const levelFilter = document.getElementById('level-filter');

            function filterTextbooks() {
                const searchTerm = searchInput.value.toLowerCase();
                const category = categoryFilter.value;
                const level = levelFilter.value;

                const filtered = medicalTextbooks.filter(book => {
                    const matchesSearch = book.title.toLowerCase().includes(searchTerm) || 
                                        book.author.toLowerCase().includes(searchTerm) ||
                                        book.description.toLowerCase().includes(searchTerm);
                    const matchesCategory = category === 'all' || book.category === category;
                    const matchesLevel = level === 'all' || book.level === level;

                    return matchesSearch && matchesCategory && matchesLevel;
                });

                renderTextbooks(filtered);
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterTextbooks);
                categoryFilter.addEventListener('change', filterTextbooks);
                levelFilter.addEventListener('change', filterTextbooks);
            }
        }

        function openTextbook(bookId) {
            const book = medicalTextbooks.find(b => b.id === bookId);
            if (book) {
                // Open the book URL in new tab
                window.open(book.pdfUrl, '_blank');
            }
        }

        function downloadTextbook(bookId) {
            const book = medicalTextbooks.find(b => b.id === bookId);
            if (book) {
                if (book.downloadable && book.legal) {
                    // Open the legal download link in new tab
                    window.open(book.pdfUrl, '_blank');
                } else {
                    alert(`📚 ${book.title}\n\nThis book is available through the provided link. Click "Read Online" to access the free legal version.`);
                }
            }
        }

        function closeTextbooksModal() {
            const modal = document.getElementById('textbooks-modal');
            if (modal) {
                modal.remove();
            }
        }

        // 3D Anatomy Explorer
        function launchAnatomyExplorer() {
            const explorerHTML = `
            <div id="anatomy-explorer" style="position:fixed; top:0; left:0; width:100vw; height:100vh; background: #0f172a; z-index:99999; font-family: system-ui;">
                <!-- Header -->
                <div style="padding: 20px; background: rgba(15, 23, 42, 0.95); border-bottom: 1px solid rgba(6, 182, 212, 0.3); display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="color: #06b6d4; font-size: 1.5rem; font-weight: bold;">🧠 3D Human Anatomy Explorer</h2>
                    <button onclick="closeAnatomyExplorer()" style="padding: 10px 20px; background: #ef4444; color: white; border: none; border-radius: 10px; cursor: pointer;">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>

                <!-- Main Content -->
                <div style="display: flex; height: calc(100vh - 80px);">
                    <!-- Organ Selection Sidebar -->
                    <div style="width: 300px; background: rgba(30, 41, 59, 0.8); padding: 20px; overflow-y: auto; border-right: 1px solid rgba(6, 182, 212, 0.2);">
                        <h3 style="color: white; margin-bottom: 20px;">Organs</h3>
                        <div id="organ-list" style="display: flex; flex-direction: column; gap: 10px;">
                            <!-- Organs will be loaded here -->
                        </div>
                    </div>

                    <!-- 3D Viewer -->
                    <div style="flex: 1; position: relative;">
                        <a-scene embedded style="width: 100%; height: 100%;">
                            <!-- 3D Model will load here -->
                            <a-entity id="current-organ" position="0 1.5 -3"></a-entity>
                            
                            <!-- Camera Controls -->
                            <a-entity camera look-controls wasd-controls position="0 1.5 5">
                                <a-cursor></a-cursor>
                            </a-entity>
                            
                            <!-- Lighting -->
                            <a-entity light="type: ambient; color: #888; intensity: 0.5"></a-entity>
                            <a-entity light="type: directional; color: #fff; intensity: 0.8" position="-5 5 5"></a-entity>
                        </a-scene>

                        <!-- Mobile Controls Notice -->
                        <div style="position:absolute; bottom:10px; left:10px; color:#94a3b8; font-size:12px; background: rgba(0,0,0,0.7); padding: 8px 12px; border-radius: 8px;">
                            🖱️ <strong>Desktop:</strong> Drag to rotate • Scroll to zoom
                            <br>📱 <strong>Mobile:</strong> Touch & drag to rotate • Pinch to zoom
                        </div>
                    </div>

                    <!-- Information Panel -->
                    <div id="info-panel" style="width: 350px; background: rgba(30, 41, 59, 0.9); padding: 20px; overflow-y: auto; border-left: 1px solid rgba(6, 182, 212, 0.2);">
                        <h3 style="color: #06b6d4; margin-bottom: 20px;">Organ Information</h3>
                        <div id="organ-info">
                            <p style="color: #94a3b8;">Select an organ to view 3D model and details</p>
                        </div>
                    </div>
                </div>
            </div>`;

            document.body.insertAdjacentHTML('beforeend', explorerHTML);
            loadOrgansList();
            
            // Load first organ by default
            setTimeout(() => {
                loadOrgan(organsData[0]);
            }, 500);
        }

        // Organ Data with SIMPLE SHAPES that work 100%
        const organsData = [
            {
                id: 'heart',
                name: 'Heart',
                shape: 'dodecahedron',
                scale: '0.8 0.8 0.8',
                color: '#ef4444',
                position: '0 1.5 -3',
                animation: 'property: rotation; to: 0 360 0; loop: true; dur: 15000'
            },
            {
                id: 'brain',
                name: 'Brain', 
                shape: 'sphere',
                scale: '1 1 1',
                color: '#8b5cf6',
                position: '0 1.5 -3',
                animation: 'property: rotation; to: 360 360 0; loop: true; dur: 20000'
            },
            {
                id: 'lungs',
                name: 'Lungs',
                shape: 'box',
                scale: '1.2 0.8 0.6',
                color: '#06b6d4',
                position: '0 1.5 -3',
                animation: 'property: scale; to: 1.3 0.9 0.7; loop: true; dir: alternate; dur: 2000'
            },
            {
                id: 'liver',
                name: 'Liver',
                shape: 'cylinder',
                scale: '1 0.4 1',
                color: '#22c55e',
                position: '0 1.5 -3',
                animation: 'property: rotation; to: 0 360 0; loop: true; dur: 18000'
            },
            {
                id: 'kidneys',
                name: 'Kidneys',
                shape: 'sphere',
                scale: '0.6 0.6 0.6',
                color: '#f59e0b',
                position: '-0.8 1.5 -3',
                animation: 'property: position; to: -0.8 1.7 -3; loop: true; dir: alternate; dur: 1500'
            },
            {
                id: 'stomach',
                name: 'Stomach',
                shape: 'cone',
                scale: '1 1 1',
                color: '#ec4899',
                position: '0 1.5 -3',
                animation: 'property: rotation; to: 0 360 0; loop: true; dur: 22000'
            }
        ];

        // Organ Information Database
        const organInfo = {
            heart: {
                function: "Pumps blood throughout the body, delivering oxygen and nutrients to tissues while removing waste products.",
                facts: ["Beats ~100,000 times daily", "Pumps ~7,500 liters of blood per day", "Size of a clenched fist", "Has its own electrical system"],
                diseases: ["Coronary Artery Disease", "Heart Attack", "Arrhythmia", "Heart Failure", "Cardiomyopathy"],
                protection: ["Regular aerobic exercise", "Healthy diet low in saturated fats", "Avoid smoking and limit alcohol", "Manage stress and blood pressure", "Regular health checkups"]
            },
            brain: {
                function: "Controls thought, memory, emotion, touch, motor skills, vision, breathing, temperature, hunger and every process that regulates our body.",
                facts: ["Contains ~86 billion neurons", "Uses 20% of body's oxygen and calories", "Weighs about 1.4 kg (3 pounds)", "75% water", "Can generate 23 watts of power"],
                diseases: ["Stroke", "Alzheimer's Disease", "Epilepsy", "Brain Tumors", "Parkinson's Disease", "Multiple Sclerosis"],
                protection: ["Mental exercises and continuous learning", "Adequate sleep (7-9 hours nightly)", "Protect from head injuries", "Healthy diet rich in omega-3s", "Social interaction and stress management"]
            },
            lungs: {
                function: "Facilitate gas exchange - oxygen enters bloodstream and carbon dioxide is removed through the process of breathing.",
                facts: ["Surface area of a tennis court (70-100 m²)", "Breathe ~11,000 liters of air daily", "Right lung has 3 lobes, left has 2", "Contain ~300 million alveoli", "Weigh about 1 kg total"],
                diseases: ["Pneumonia", "COPD (Chronic Obstructive Pulmonary Disease)", "Lung Cancer", "Asthma", "Pulmonary Fibrosis", "Tuberculosis"],
                protection: ["Avoid smoking and secondhand smoke", "Regular cardiovascular exercise", "Get flu and pneumonia vaccines", "Avoid air pollution and occupational hazards", "Practice deep breathing exercises"]
            },
            liver: {
                function: "Detoxifies chemicals, metabolizes drugs, produces bile for digestion, makes proteins for blood clotting, and stores vitamins and minerals.",
                facts: ["Largest internal organ", "Can regenerate itself (grow back)", "Performs 500+ vital functions", "Processes 1.5 liters of blood per minute", "Stores vitamins A, D, E, K, B12"],
                diseases: ["Hepatitis A, B, C", "Cirrhosis", "Liver Cancer", "Fatty Liver Disease", "Liver Failure", "Jaundice"],
                protection: ["Limit alcohol consumption", "Maintain healthy weight", "Get vaccinated for Hepatitis", "Practice safe medication use", "Eat balanced diet with limited processed foods"]
            },
            kidneys: {
                function: "Filter blood to remove waste products and excess fluids, regulate electrolyte balance, produce urine, and control blood pressure.",
                facts: ["Filter ~180 liters of blood daily", "Produce 1-2 liters of urine per day", "Contain ~1 million nephrons each", "Size of a computer mouse", "Located in lower back on either side of spine"],
                diseases: ["Kidney Stones", "Kidney Failure", "Nephritis", "Kidney Cancer", "Polycystic Kidney Disease", "Urinary Tract Infections"],
                protection: ["Stay well-hydrated (8 glasses water daily)", "Control blood pressure and diabetes", "Limit salt and protein intake", "Avoid NSAID overuse", "Regular kidney function tests"]
            },
            stomach: {
                function: "Digests food using gastric acids and enzymes, breaks down proteins, kills bacteria, and regulates the passage of food to the small intestine.",
                facts: ["Can hold ~1 liter of food", "pH of 1.5-3.5 (highly acidic)", "Produces 2-3 liters of gastric juice daily", "Has three muscle layers for churning", "Replaces lining every 3 days"],
                diseases: ["Gastritis", "Peptic Ulcers", "Stomach Cancer", "GERD (Acid Reflux)", "Hiatal Hernia", "Stomach Flu"],
                protection: ["Balanced diet with adequate fiber", "Avoid excessive NSAIDs and alcohol", "Manage stress through relaxation techniques", "Practice food safety and hygiene", "Eat smaller, more frequent meals"]
            }
        };

        function loadOrgansList() {
            const organList = document.getElementById('organ-list');
            organList.innerHTML = '';
            
            organsData.forEach(organ => {
                const button = document.createElement('button');
                button.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: rgba(6, 182, 212, 0.1); border: 1px solid ${organ.color}; border-radius: 10px; color: white; text-align: left; width: 100%; cursor: pointer; transition: all 0.3s ease;" 
                         onmouseover="this.style.transform='translateX(5px)'; this.style.background='rgba(6, 182, 212, 0.2)'" 
                         onmouseout="this.style.transform='translateX(0)'; this.style.background='rgba(6, 182, 212, 0.1)'">
                        <div style="width: 12px; height: 12px; border-radius: 50%; background: ${organ.color};"></div>
                        <span style="font-weight: 500;">${organ.name}</span>
                    </div>
                `;
                button.onclick = () => loadOrgan(organ);
                organList.appendChild(button);
            });
        }

        function loadOrgan(organ) {
            const currentOrgan = document.getElementById('current-organ');
            
            // Clear previous organ
            currentOrgan.innerHTML = '';
            
            // Create new organ shape
            const shape = document.createElement('a-entity');
            shape.setAttribute('geometry', `primitive: ${organ.shape}`);
            shape.setAttribute('material', `color: ${organ.color}; metalness: 0.3; roughness: 0.4`);
            shape.setAttribute('scale', organ.scale);
            shape.setAttribute('position', organ.position);
            
            // Add animation
            if (organ.animation) {
                shape.setAttribute('animation', organ.animation);
            }
            
            // Add hover effect
            shape.setAttribute('class', 'clickable');
            shape.setAttribute('animation__hover', 'property: scale; to: 1.1 1.1 1.1; dur: 300; startEvents: mouseenter');
            shape.setAttribute('animation__hoverreset', 'property: scale; to: ' + organ.scale + '; dur: 300; startEvents: mouseleave');
            
            currentOrgan.appendChild(shape);
            
            // Show organ information
            showOrganInfo(organ.id);
            
            console.log('✅ Loaded:', organ.name, 'as', organ.shape);
        }

        function showOrganInfo(organId) {
            const info = organInfo[organId];
            const infoPanel = document.getElementById('organ-info');
            
            infoPanel.innerHTML = `
                <div style="color: white;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <div style="width: 20px; height: 20px; border-radius: 50%; background: ${organsData.find(o => o.id === organId)?.color || '#06b6d4'};"></div>
                        <h4 style="color: #06b6d4; font-size: 1.3rem; margin: 0;">${organId.charAt(0).toUpperCase() + organId.slice(1)}</h4>
                    </div>
                    
                    <div style="margin-bottom: 20px; background: rgba(6, 182, 212, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #06b6d4;">
                        <h5 style="color: #f59e0b; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-cogs"></i> Function
                        </h5>
                        <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5; margin: 0;">${info.function}</p>
                    </div>
                    
                    <div style="margin-bottom: 20px; background: rgba(16, 185, 129, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #10b981;">
                        <h5 style="color: #10b981; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-microscope"></i> Amazing Facts
                        </h5>
                        <ul style="color: #94a3b8; font-size: 0.9rem; padding-left: 20px; line-height: 1.5; margin: 0;">
                            ${info.facts.map(fact => `<li style="margin-bottom: 8px;">${fact}</li>`).join('')}
                        </ul>
                    </div>
                    
                    <div style="margin-bottom: 20px; background: rgba(239, 68, 68, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ef4444;">
                        <h5 style="color: #ef4444; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-exclamation-triangle"></i> Common Diseases
                        </h5>
                        <ul style="color: #94a3b8; font-size: 0.9rem; padding-left: 20px; line-height: 1.5; margin: 0;">
                            ${info.diseases.map(disease => `<li style="margin-bottom: 8px;">${disease}</li>`).join('')}
                        </ul>
                    </div>
                    
                    <div style="background: rgba(6, 182, 212, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #06b6d4;">
                        <h5 style="color: #06b6d4; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-shield-alt"></i> Protection Tips
                        </h5>
                        <ul style="color: #94a3b8; font-size: 0.9rem; padding-left: 20px; line-height: 1.5; margin: 0;">
                            ${info.protection.map(tip => `<li style="margin-bottom: 8px;">${tip}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;
        }

        function closeAnatomyExplorer() {
            const explorer = document.getElementById('anatomy-explorer');
            if (explorer) {
                explorer.remove();
            }
        }
    </script>
@endsection