<nav class="fixed top-0 left-0 right-0 z-50 bg-[rgba(255,255,255,0.05)] backdrop-blur-[20px] border border-[rgba(255,255,255,0.1)] shadow-[0_8px_32px_0_rgba(0,0,0,0.36)]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="{{ url('/') }}" class="text-2xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-cyan-400 bg-clip-text text-transparent animate-pulse">
                🧠 {{config('app.name')}}
            </a>
            <div class="flex items-center space-x-6">
                <a href="{{ url('/') }}" 
                    class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 flex items-center group">
                    <i class="fas fa-home mr-2 group-hover:text-cyan-400"></i>Home
                </a>
                <a href="{{ route('predictions') }}" 
                    class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 flex items-center group">
                    <i class="fas fa-brain mr-2 group-hover:text-purple-400"></i>Predictions
                </a>
                <a href="{{ route('blood.donation') }}" 
                    class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 flex items-center group">
                    <i class="fas fa-tint mr-2 group-hover:text-red-400"></i>Blood Donation
                </a>
                {{-- <a href="{{ route('medical.learning') }}" 
                    class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 flex items-center group">
                    <i class="fas fa-graduation-cap mr-2 group-hover:text-green-400"></i>Learning
                </a> --}}
                <a href="{{ route('resources') }}" 
                    class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 flex items-center group">
                    <i class="fas fa-book-medical mr-2 group-hover:text-blue-400"></i>Resources
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" 
                        class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 flex items-center group">
                        <i class="fas fa-tachometer-alt mr-2 group-hover:text-yellow-400"></i>Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 flex items-center group">
                            <i class="fas fa-sign-out-alt mr-2 group-hover:text-orange-400"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                        class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 flex items-center group">
                        <i class="fas fa-sign-in-alt mr-2 group-hover:text-green-400"></i>Login
                    </a>
                    <a href="{{ route('register') }}" 
                        class="bg-gradient-to-r from-cyan-500 to-purple-600 text-white px-4 py-2 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">
                        Sign Up
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>