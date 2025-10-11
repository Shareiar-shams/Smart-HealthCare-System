@extends('layouts.viewport.app')

@section('viewport_title')
    Medical Learning Hub
@endsection
@section('viewport_meta')
@endsection
@section('viewport_vendor_css')
@endsection

@section('viewport_page_css')
    <style>
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
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }
        @keyframes pulse-glow {
            from { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            to { box-shadow: 0 0 30px rgba(59, 130, 246, 0.8), 0 0 40px rgba(59, 130, 246, 0.6); }
        }

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
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <div class="inline-block mb-6">
            <div class="hologram-effect rounded-2xl p-1">
                <h1 class="text-6xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-4">
                    Medical Learning Revolution
                </h1>
            </div>
        </div>
        <p class="text-xl text-gray-300 max-w-4xl mx-auto mb-8 leading-relaxed">
            Immerse yourself in the future of medical education. Experience <span class="text-cyan-400 font-semibold">3D anatomy</span>, 
            <span class="text-purple-400 font-semibold">live surgical simulations</span>, and learn from <span class="text-pink-400 font-semibold">world-renowned experts</span> 
            through cutting-edge interactive platforms.
        </p>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto mb-12">
            <div class="neuro-glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-3xl font-bold text-cyan-400 mb-2">{{ $stats['total_modules'] }}+</div>
                <div class="text-gray-300">Learning Modules</div>
            </div>
            <div class="neuro-glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-3xl font-bold text-purple-400 mb-2">{{ $stats['expert_sessions'] }}+</div>
                <div class="text-gray-300">Expert Sessions</div>
            </div>
            <div class="neuro-glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-3xl font-bold text-pink-400 mb-2">{{ $stats['surgical_sims'] }}+</div>
                <div class="text-gray-300">Surgical Sims</div>
            </div>
            <div class="neuro-glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-3xl font-bold text-green-400 mb-2">{{ $stats['success_rate'] }}%</div>
                <div class="text-gray-300">Success Rate</div>
            </div>
        </div>
    </div>

    <!-- Learning Modules Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-16">
        @foreach($modules as $module)
        <div class="neuro-glass rounded-3xl overflow-hidden transform hover:scale-105 transition-all duration-500 hover:shadow-2xl">
            <!-- Module Header -->
            <div class="bg-gradient-to-r {{ $module['color'] }} p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class="{{ $module['icon'] }} text-2xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-white/80 text-sm">Progress</div>
                        <div class="text-2xl font-bold text-white">{{ $module['progress'] }}%</div>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">{{ $module['title'] }}</h3>
                <p class="text-white/80 text-sm">{{ $module['description'] }}</p>
            </div>

            <!-- Progress Bar -->
            <div class="px-6 pt-4">
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r {{ $module['color'] }} h-2 rounded-full" style="width: {{ $module['progress'] }}%"></div>
                </div>
            </div>

            <!-- Module Content -->
            <div class="p-6">
                <!-- Features -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($module['features'] as $feature)
                    <span class="px-3 py-1 bg-gray-700/50 text-gray-300 rounded-full text-sm border {{ $module['border'] }}">
                        {{ $feature }}
                    </span>
                    @endforeach
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="text-center">
                        <div class="text-lg font-bold text-cyan-400">{{ $module['topics'] }}</div>
                        <div class="text-xs text-gray-400">Topics</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold text-purple-400">{{ $module['duration'] }}</div>
                        <div class="text-xs text-gray-400">Duration</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold text-pink-400">{{ $module['resources'] }}</div>
                        <div class="text-xs text-gray-400">Resources</div>
                    </div>
                </div>

                <!-- Expert -->
                <div class="flex items-center space-x-3 p-3 bg-gray-800/50 rounded-xl mb-4">
                    <div class="w-10 h-10 bg-gradient-to-r {{ $module['color'] }} rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-white text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white">{{ $module['expert'] }}</div>
                        <div class="text-xs text-gray-400">Lead Instructor</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button onclick="openModule('{{ $module['id'] }}')" 
                            class="flex-1 bg-gradient-to-r {{ $module['color'] }} text-white py-3 rounded-xl font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        Enter Module
                    </button>
                    <button onclick="openVideoLibrary('{{ $module['youtube_playlist'] }}')" 
                            class="px-4 bg-gray-700 text-white rounded-xl hover:bg-gray-600 transition-all duration-300">
                        <i class="fab fa-youtube"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Advanced Features Section -->
    <div class="neuro-glass rounded-3xl p-8 mb-16">
        <h2 class="text-4xl font-bold text-center text-white mb-12">🚀 Advanced Learning Technologies</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Feature 1 -->
            <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-cyan-500/10 to-blue-600/10 border border-cyan-500/20 hover:border-cyan-500/40 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                    <i class="fas fa-cube text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">3D Holographic Anatomy</h3>
                <p class="text-gray-300 text-sm">Interactive 3D models with augmented reality integration</p>
            </div>

            <!-- Feature 2 -->
            <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-purple-500/10 to-pink-600/10 border border-purple-500/20 hover:border-purple-500/40 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                    <i class="fas fa-vr-cardboard text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">VR Surgical Simulation</h3>
                <p class="text-gray-300 text-sm">Immersive virtual reality operating room experiences</p>
            </div>

            <!-- Feature 3 -->
            <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-green-500/10 to-emerald-600/10 border border-green-500/20 hover:border-green-500/40 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                    <i class="fas fa-robot text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">AI-Powered Tutoring</h3>
                <p class="text-gray-300 text-sm">Personalized learning paths with adaptive AI mentors</p>
            </div>

            <!-- Feature 4 -->
            <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-orange-500/10 to-red-600/10 border border-orange-500/20 hover:border-orange-500/40 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 pulse-glow">
                    <i class="fas fa-globe-americas text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Global Expert Network</h3>
                <p class="text-gray-300 text-sm">Live sessions with specialists from top institutions worldwide</p>
            </div>
        </div>
    </div>

    <!-- Live Sessions Section -->
    <div class="neuro-glass rounded-3xl p-8">
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

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8 z-20">
        <button class="w-14 h-14 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-full flex items-center justify-center text-white shadow-2xl pulse-glow hover:scale-110 transition-all duration-300">
            <i class="fas fa-robot text-xl"></i>
        </button>
    </div>
@endsection

@section('viewport_vendor_js')
@endsection

@section('viewport_page_js')
    <script>
        function openModule(moduleId) {
            alert(`Opening ${moduleId} module...`);
            // window.location.href = `/learning-module/${moduleId}`;
        }

        function openVideoLibrary(playlistId) {
            window.open(`https://www.youtube.com/playlist?list=${playlistId}`, '_blank');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Hover effect for cards
            const modules = document.querySelectorAll('.neuro-glass');
            modules.forEach(module => {
                module.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                module.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Typing effect on hero title
            const heroText = "Medical Learning Revolution";
            let i = 0;
            const typingEffect = setInterval(() => {
                const h1 = document.querySelector('h1');
                if (!h1) { clearInterval(typingEffect); return; }
                h1.textContent = heroText.slice(0, i);
                i++;
                if (i > heroText.length) clearInterval(typingEffect);
            }, 100);
        });
    </script>
@endsection
