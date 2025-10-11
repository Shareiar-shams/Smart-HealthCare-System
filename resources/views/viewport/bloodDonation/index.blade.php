@extends('layouts.viewport.app')

@section('viewport_title')
    Save Lives
@endsection
@section('viewport_meta')
@endsection

@section('viewport_vendor_css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('viewport_page_css')

@endsection

@section('content')
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-red-400 to-pink-500 bg-clip-text text-transparent mb-4">
            Donate Blood, Save Lives
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto">
            Join our community of heroes. Your single donation can save up to 3 lives. 
            Register as a donor or request blood when in need.
        </p>
    </div>

    <!-- Statistics - Updated with dynamic data -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-gradient-to-br from-red-500/10 to-pink-600/10 border border-red-500/20 rounded-2xl p-6 text-center backdrop-blur-lg">
            <i class="fas fa-users text-3xl text-red-400 mb-3"></i>
            <h3 class="text-2xl font-bold text-white" data-stat="total_donors">{{ number_format($stats['total_donors']) }}+</h3>
            <p class="text-gray-300">Registered Donors</p>
        </div>
        <div class="bg-gradient-to-br from-purple-500/10 to-blue-600/10 border border-purple-500/20 rounded-2xl p-6 text-center backdrop-blur-lg">
            <i class="fas fa-heartbeat text-3xl text-purple-400 mb-3"></i>
            <h3 class="text-2xl font-bold text-white" data-stat="active_donors">{{ number_format($stats['active_donors']) }}+</h3>
            <p class="text-gray-300">Active Donors</p>
        </div>
        <div class="bg-gradient-to-br from-green-500/10 to-emerald-600/10 border border-green-500/20 rounded-2xl p-6 text-center backdrop-blur-lg">
            <i class="fas fa-hand-holding-heart text-3xl text-green-400 mb-3"></i>
            <h3 class="text-2xl font-bold text-white" data-stat="blood_requests">{{ number_format($stats['blood_requests']) }}+</h3>
            <p class="text-gray-300">Requests Fulfilled</p>
        </div>
        <div class="bg-gradient-to-br from-cyan-500/10 to-blue-600/10 border border-cyan-500/20 rounded-2xl p-6 text-center backdrop-blur-lg">
            <i class="fas fa-life-ring text-3xl text-cyan-400 mb-3"></i>
            <h3 class="text-2xl font-bold text-white" data-stat="lives_saved">{{ number_format($stats['lives_saved']) }}+</h3>
            <p class="text-gray-300">Lives Saved</p>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Register as Donor -->
        <div class="bg-gradient-to-br from-red-500/10 to-pink-600/10 border border-red-500/20 rounded-2xl p-8 backdrop-blur-lg">
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-r from-red-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-3xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-white mb-2">Become a Hero</h3>
                <p class="text-gray-300">Register as a blood donor and save lives in your community</p>
            </div>
            <button onclick="openModal('donor')" class="w-full bg-gradient-to-r from-red-500 to-pink-600 text-white py-4 rounded-2xl font-semibold text-lg hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-red-500/25">
                Register as Donor
            </button>
        </div>

        <!-- Request Blood -->
        <div class="bg-gradient-to-br from-purple-500/10 to-blue-600/10 border border-purple-500/20 rounded-2xl p-8 backdrop-blur-lg">
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-medical text-3xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-white mb-2">Need Blood?</h3>
                <p class="text-gray-300">Request blood for patients with gratitude fee for donors</p>
            </div>
            <button onclick="openModal('request')" class="w-full bg-gradient-to-r from-purple-500 to-blue-600 text-white py-4 rounded-2xl font-semibold text-lg hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-purple-500/25">
                Request Blood
            </button>
        </div>
    </div>

    <!-- Division-wise Donors - Updated with dynamic data -->
    <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl p-8 mb-8">
        <h2 class="text-3xl font-bold text-white mb-6 text-center">Donors by Division</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($divisions as $key => $division)
            <div class="text-center p-4 bg-slate-800/50 rounded-xl hover:bg-slate-700/50 transition-colors cursor-pointer" onclick="filterDivision('{{ $key }}')">
                <div class="text-2xl font-bold text-white mb-1" data-division="{{ $division }}">
                    {{ $divisionStats[$division] ?? 0 }}
                </div>
                <div class="text-gray-300 text-sm">{{ $division }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Blood Group Availability - Updated with dynamic data -->
    <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl p-8">
        <h2 class="text-3xl font-bold text-white mb-6 text-center">Blood Group Availability</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($bloodGroups as $group)
            <div class="text-center p-6 bg-gradient-to-br from-red-500/20 to-pink-600/20 border border-red-500/30 rounded-xl">
                <div class="text-3xl font-bold text-white mb-2">{{ $group }}</div>
                <div class="text-green-400 font-semibold" data-blood-group="{{ $group }}">
                    {{ $bloodGroupStats[$group] ?? 0 }} Donors Available
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Donor Registration Modal -->
    <div id="donorModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden z-50 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
            <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-red-500/30 rounded-2xl shadow-2xl">
                    <!-- Header -->
                    <div class="border-b border-red-500/20 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-user-plus text-xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">Register as Blood Donor</h3>
                                    <p class="text-gray-400">Join our life-saving community</p>
                                </div>
                            </div>
                            <button onclick="closeModal('donor')" class="text-gray-400 hover:text-white text-2xl">
                                &times;
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form id="donorForm" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-white mb-2">Full Name *</label>
                                <input type="text" name="name" required class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-white mb-2">Email *</label>
                                <input type="email" name="email" required class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-white mb-2">Phone Number *</label>
                                <input type="tel" name="phone" required class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-white mb-2">Blood Group *</label>
                                <select name="blood_group" required class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                                    <option value="">Select Blood Group</option>
                                    @foreach($bloodGroups as $group)
                                    <option value="{{ $group }}">{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-white mb-2">Division *</label>
                                <select name="division" required class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                                    <option value="">Select Division</option>
                                    @foreach($divisions as $key => $division)
                                    <option value="{{ $key }}">{{ $division }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-white mb-2">District *</label>
                                <input type="text" name="district" required class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-white mb-2">Last Donation Date (if any)</label>
                                <input type="date" name="last_donation" class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-white mb-2">Any Health Conditions?</label>
                                <textarea name="health_conditions" rows="2" class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500"></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="availability" value="1" class="rounded bg-slate-700 border-gray-600 text-red-500 focus:ring-red-500">
                                    <span class="ml-2 text-white">I'm currently available for donation</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700">
                            <button type="button" onclick="closeModal('donor')" class="px-6 py-3 border border-gray-600 text-gray-300 rounded-xl hover:bg-gray-700 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-red-500/25 transition-all flex items-center justify-center min-w-32">
                                <span id="donorSubmitText">Register as Donor</span>
                                <div id="donorLoading" class="hidden ml-2 w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Blood Request Modal with Donor Search -->
    <div id="requestModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden z-50 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
            <div class="inline-block w-full max-w-6xl my-8 overflow-hidden text-left align-middle">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-purple-500/30 rounded-2xl shadow-2xl">
                    <!-- Header -->
                    <div class="border-b border-purple-500/20 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-blue-600 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-hand-holding-medical text-xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">Request Blood & Find Donors</h3>
                                    <p class="text-gray-400">Submit your request and find matching donors instantly</p>
                                </div>
                            </div>
                            <button onclick="closeModal('request')" class="text-gray-400 hover:text-white text-2xl">
                                &times;
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row">
                        <!-- Request Form Section -->
                        <div class="lg:w-1/2 p-6 border-r border-gray-700">
                            <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <i class="fas fa-edit mr-2 text-purple-400"></i>
                                Blood Request Details
                            </h4>
                            
                            <form id="requestForm">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Patient Name *</label>
                                        <input type="text" name="patient_name" required 
                                               class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Contact Person *</label>
                                        <input type="text" name="contact_person" required 
                                               class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Phone Number *</label>
                                        <input type="tel" name="phone" required 
                                               class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Hospital *</label>
                                        <input type="text" name="hospital" required 
                                               class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Blood Group Needed *</label>
                                        <select name="blood_group" required 
                                                class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                            <option value="">Select Blood Group</option>
                                            @foreach($bloodGroups as $group)
                                            <option value="{{ $group }}">{{ $group }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Units Required *</label>
                                        <input type="number" name="units_required" min="1" max="10" required 
                                               class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Urgency Level *</label>
                                        <select name="urgency" required 
                                                class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Gratitude Fee (BDT)</label>
                                        <input type="number" name="gratitude_fee" min="0" 
                                               class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm"
                                               placeholder="Optional">
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">Division *</label>
                                        <select name="division" required 
                                                class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                            <option value="">Select Division</option>
                                            @foreach($divisions as $key => $division)
                                            <option value="{{ $key }}">{{ $division }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-white mb-2 text-sm">District *</label>
                                        <input type="text" name="district" required 
                                               class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-white mb-2 text-sm">Required Date *</label>
                                        <input type="date" name="required_date" required 
                                               class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-white mb-2 text-sm">Additional Information</label>
                                        <textarea name="additional_info" rows="2"
                                                  class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm" 
                                                  placeholder="Any special requirements or notes..."></textarea>
                                    </div>
                                </div>
                                
                                <!-- Search Filters -->
                                <div class="mt-6 pt-4 border-t border-gray-700">
                                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                                        <i class="fas fa-search mr-2 text-blue-400"></i>
                                        Donor Search Filters
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <label class="block text-white mb-2 text-sm">Location Filter</label>
                                            <select name="search_division" 
                                                    class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                                                <option value="">All Divisions</option>
                                                @foreach($divisions as $key => $division)
                                                <option value="{{ $key }}">{{ $division }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-white mb-2 text-sm">Blood Group</label>
                                            <select name="search_blood_group" 
                                                    class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                                                <option value="">All Blood Groups</option>
                                                @foreach($bloodGroups as $group)
                                                <option value="{{ $group }}">{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-white mb-2 text-sm">Max Gratitude Fee</label>
                                            <input type="number" name="max_gratitude_fee" min="0" 
                                                   class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-3 py-2 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                                                   placeholder="No limit">
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4">
                                        <button type="button" onclick="searchDonors()" 
                                                class="bg-gradient-to-r from-blue-500 to-cyan-600 text-white px-6 py-2 rounded-xl font-semibold hover:shadow-lg transition-all flex items-center">
                                            <i class="fas fa-search mr-2"></i>
                                            Search Donors
                                        </button>
                                        <button type="button" onclick="clearSearch()" 
                                                class="border border-gray-600 text-gray-300 px-4 py-2 rounded-xl hover:bg-gray-700 transition-colors">
                                            Clear Filters
                                        </button>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-4 mt-6 pt-6 border-t border-gray-700">
                                    <button type="button" onclick="closeModal('request')" 
                                            class="px-6 py-3 border border-gray-600 text-gray-300 rounded-xl hover:bg-gray-700 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            class="px-6 py-3 bg-gradient-to-r from-purple-500 to-blue-600 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-purple-500/25 transition-all flex items-center justify-center min-w-32">
                                        <span id="requestSubmitText">Submit Request</span>
                                        <div id="requestLoading" class="hidden ml-2 w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Donor Search Results Section -->
                        <div class="lg:w-1/2 p-6">
                            <h4 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <i class="fas fa-users mr-2 text-green-400"></i>
                                Matching Donors
                                <span id="matchCount" class="ml-2 px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">0 found</span>
                            </h4>
                            
                            <!-- Search Status -->
                            <div id="searchStatus" class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-search text-4xl mb-3"></i>
                                    <p>Fill the request form and use filters to find matching donors</p>
                                </div>
                            </div>
                            
                            <!-- Donor Results Container -->
                            <div id="donorResults" class="space-y-4 max-h-96 overflow-y-auto hidden">
                                <!-- Donor cards will be dynamically inserted here -->
                            </div>
                            
                            <!-- Loading State -->
                            <div id="searchLoading" class="hidden text-center py-8">
                                <div class="w-8 h-8 border-2 border-white border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                                <p class="text-gray-400">Searching for matching donors...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-24 right-4 z-50 space-y-2"></div>

@endsection

@section('viewport_vendor_js')
@endsection

@section('viewport_page_js')
    <script>
        // Modal functions
        function openModal(type) {
            document.getElementById(type + 'Modal').classList.remove('hidden');
        }

        function closeModal(type) {
            document.getElementById(type + 'Modal').classList.add('hidden');
        }

        // Form submissions with loading states
        document.getElementById('donorForm').addEventListener('submit', function(e) {
            e.preventDefault();
            registerDonor();
        });

        document.getElementById('requestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            requestBlood();
        });

        async function registerDonor() {
            const submitBtn = document.querySelector('#donorForm button[type="submit"]');
            const submitText = document.getElementById('donorSubmitText');
            const loadingSpinner = document.getElementById('donorLoading');
            
            // Show loading state
            submitText.textContent = 'Registering...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;

            const formData = new FormData(document.getElementById('donorForm'));
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch('{{ route("register.donor") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                
                if (result.success) {
                    showNotification('success', result.message);
                    closeModal('donor');
                    document.getElementById('donorForm').reset();
                    // Refresh live stats
                    updateLiveStats();
                } else {
                    showNotification('error', result.message || 'Error registering donor.');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'Error registering donor. Please try again.');
            } finally {
                // Reset button state
                submitText.textContent = 'Register as Donor';
                loadingSpinner.classList.add('hidden');
                submitBtn.disabled = false;
            }
        }

        async function requestBlood() {
            const submitBtn = document.querySelector('#requestForm button[type="submit"]');
            const submitText = document.getElementById('requestSubmitText');
            const loadingSpinner = document.getElementById('requestLoading');
            
            // Show loading state
            submitText.textContent = 'Processing...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;

            const formData = new FormData(document.getElementById('requestForm'));
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch('{{ route("request.blood") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                
                if (result.success) {
                    const message = `${result.message} Matched with ${result.matched_donors} donors.`;
                    showNotification('success', message);
                    closeModal('request');
                    document.getElementById('requestForm').reset();
                    // Refresh live stats
                    updateLiveStats();
                } else {
                    showNotification('error', result.message || 'Error submitting request.');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'Error submitting blood request. Please try again.');
            } finally {
                // Reset button state
                submitText.textContent = 'Submit Request';
                loadingSpinner.classList.add('hidden');
                submitBtn.disabled = false;
            }
        }

        async function updateLiveStats() {
            try {
                const response = await fetch('{{ route("donor.stats") }}');
                const stats = await response.json();
                
                // Update statistic elements
                document.querySelector('[data-stat="total_donors"]').textContent = stats.total_donors + '+';
                document.querySelector('[data-stat="active_donors"]').textContent = stats.active_donors + '+';
                document.querySelector('[data-stat="blood_requests"]').textContent = stats.blood_requests + '+';
                document.querySelector('[data-stat="lives_saved"]').textContent = stats.lives_saved + '+';
                
                // Update division stats
                Object.keys(stats.divisions).forEach(division => {
                    const element = document.querySelector(`[data-division="${division}"]`);
                    if (element) {
                        element.textContent = stats.divisions[division];
                    }
                });
                
                // Update blood group stats
                Object.keys(stats.blood_groups).forEach(group => {
                    const element = document.querySelector(`[data-blood-group="${group}"]`);
                    if (element) {
                        element.textContent = stats.blood_groups[group] + ' Donors Available';
                    }
                });
                
            } catch (error) {
                console.error('Error updating stats:', error);
            }
        }

        function showNotification(type, message) {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            
            notification.className = `p-4 rounded-xl shadow-lg transform transition-all duration-300 ${
                type === 'success' 
                    ? 'bg-green-500/90 border border-green-400' 
                    : 'bg-red-500/90 border border-red-400'
            } text-white max-w-sm`;
            
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.add('translate-x-0', 'opacity-100');
            }, 100);
            
            // Remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        }

        function filterDivision(division) {
            const divisionName = document.querySelector(`option[value="${division}"]`).textContent;
            showNotification('info', `Filtering donors from: ${divisionName}`);
            // In real app, you'd filter the donor list or make an API call
        }

        // Donor Search Functions
        async function searchDonors() {
            const searchForm = document.getElementById('requestForm');
            const formData = new FormData(searchForm);
            const searchData = {
                division: formData.get('search_division'),
                blood_group: formData.get('search_blood_group'),
                max_gratitude_fee: formData.get('max_gratitude_fee')
            };

            // Show loading state
            document.getElementById('searchStatus').classList.add('hidden');
            document.getElementById('donorResults').classList.add('hidden');
            document.getElementById('searchLoading').classList.remove('hidden');

            try {
                const response = await fetch('/search-donors', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(searchData)
                });

                const result = await response.json();
                
                if (result.success) {
                    displayDonorResults(result.donors);
                    document.getElementById('matchCount').textContent = `${result.donors.length} found`;
                } else {
                    showNotification('error', 'Error searching donors.');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'Error searching donors. Please try again.');
            } finally {
                document.getElementById('searchLoading').classList.add('hidden');
            }
        }

        function displayDonorResults(donors) {
            const resultsContainer = document.getElementById('donorResults');
            const searchStatus = document.getElementById('searchStatus');
            
            resultsContainer.innerHTML = '';
            
            if (donors.length === 0) {
                searchStatus.classList.remove('hidden');
                searchStatus.innerHTML = `
                    <div class="text-yellow-400">
                        <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                        <p>No donors found matching your criteria</p>
                        <p class="text-sm text-gray-400 mt-2">Try adjusting your search filters</p>
                    </div>
                `;
                resultsContainer.classList.add('hidden');
                return;
            }
            
            searchStatus.classList.add('hidden');
            resultsContainer.classList.remove('hidden');
            
            donors.forEach(donor => {
                const donorCard = createDonorCard(donor);
                resultsContainer.appendChild(donorCard);
            });
        }

        function createDonorCard(donor) {
            const card = document.createElement('div');
            card.className = 'bg-[rgba(255,255,255,0.05)] backdrop-blur-[20px] border border-[rgba(255,255,255,0.1)] shadow-[0_8px_32px_0_rgba(0,0,0,0.36)] rounded-xl p-4 border border-green-500/20 hover:border-green-500/40 transition-all';
            
            const lastDonation = donor.last_donation ? new Date(donor.last_donation).toLocaleDateString() : 'Never';
            const statusColor = donor.availability ? 'text-green-400' : 'text-yellow-400';
            const statusText = donor.availability ? 'Available' : 'Not Available';
            
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h5 class="font-semibold text-white text-lg">${donor.name}</h5>
                        <p class="text-gray-300 text-sm">${donor.blood_group} • ${donor.district}, ${donor.division}</p>
                    </div>
                    <span class="px-2 py-1 ${statusColor} bg-green-500/10 rounded-full text-xs">${statusText}</span>
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                    <div class="text-gray-400">
                        <i class="fas fa-phone mr-1"></i>
                        ${donor.phone}
                    </div>
                    <div class="text-gray-400">
                        <i class="fas fa-envelope mr-1"></i>
                        ${donor.email}
                    </div>
                </div>
                
                <div class="flex justify-between items-center text-xs text-gray-400">
                    <span>Last donation: ${lastDonation}</span>
                    <span class="flex items-center">
                        <i class="fas fa-shield-alt mr-1 ${donor.is_verified ? 'text-green-400' : 'text-yellow-400'}"></i>
                        ${donor.is_verified ? 'Verified' : 'Pending'}
                    </span>
                </div>
                
                <div class="mt-3 flex space-x-2">
                    <button onclick="contactDonor('${donor.phone}', '${donor.name}')" 
                            class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-2 rounded-lg text-sm font-semibold hover:shadow-lg transition-all">
                        <i class="fas fa-phone mr-1"></i>Contact
                    </button>
                    <button onclick="viewDonorProfile(${donor.id})" 
                            class="px-3 bg-slate-700 text-gray-300 py-2 rounded-lg text-sm hover:bg-slate-600 transition-colors">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            `;
            
            return card;
        }

        function clearSearch() {
            document.getElementById('requestForm').reset();
            document.getElementById('donorResults').classList.add('hidden');
            document.getElementById('searchLoading').classList.add('hidden');
            document.getElementById('searchStatus').classList.remove('hidden');
            document.getElementById('matchCount').textContent = '0 found';
            
            // Reset search status to initial state
            document.getElementById('searchStatus').innerHTML = `
                <div class="text-gray-400">
                    <i class="fas fa-search text-4xl mb-3"></i>
                    <p>Fill the request form and use filters to find matching donors</p>
                </div>
            `;
        }

        function contactDonor(phone, name) {
            showNotification('info', `Contacting ${name} at ${phone}`);
            // In real app, this would initiate a call or show contact options
        }

        function viewDonorProfile(donorId) {
            showNotification('info', `Viewing donor profile #${donorId}`);
            // In real app, this would open a donor profile modal
        }

        // Close modals on outside click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed')) {
                e.target.classList.add('hidden');
            }
        });

        // Auto-refresh stats every 30 seconds
        setInterval(updateLiveStats, 30000);
    </script>
@endsection