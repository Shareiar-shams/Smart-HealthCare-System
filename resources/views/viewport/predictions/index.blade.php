@extends('layouts.viewport.app')

@section('viewport_title')
    AI Disease Prediction
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
        <h1 class="text-5xl font-bold bg-gradient-to-r from-cyan-400 to-purple-500 bg-clip-text text-transparent mb-4">
            AI Health Predictions
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto">
            Get instant risk assessments for various health conditions using our advanced machine learning models. 
            Early detection saves lives.
        </p>
    </div>

    <!-- Prediction Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Heart Disease Prediction Card -->
        <div class="bg-gradient-to-br from-red-500/10 to-pink-600/10 border border-red-500/20 rounded-2xl p-6 backdrop-blur-lg hover:transform hover:scale-105 transition-all duration-300">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart-pulse text-2xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Heart Disease</h3>
                <p class="text-gray-300">Assess your cardiovascular health risk</p>
            </div>
            <button onclick="openModal('heart')" 
                    class="w-full bg-gradient-to-r from-red-500 to-pink-600 text-white py-3 rounded-xl font-semibold hover:shadow-2xl hover:shadow-red-500/25 transition-all duration-300">
                Check Heart Health
            </button>
        </div>

        <!-- Diabetes Prediction Card -->
        <div class="bg-gradient-to-br from-blue-500/10 to-cyan-600/10 border border-blue-500/20 rounded-2xl p-6 backdrop-blur-lg hover:transform hover:scale-105 transition-all duration-300">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-syringe text-2xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Diabetes</h3>
                <p class="text-gray-300">Evaluate your diabetes risk factors</p>
            </div>
            <button onclick="openModal('diabetes')" 
                    class="w-full bg-gradient-to-r from-blue-500 to-cyan-600 text-white py-3 rounded-xl font-semibold hover:shadow-2xl hover:shadow-blue-500/25 transition-all duration-300">
                Assess Diabetes Risk
            </button>
        </div>

        <!-- Liver Disease Prediction Card -->
        <div class="bg-gradient-to-br from-green-500/10 to-emerald-600/10 border border-green-500/20 rounded-2xl p-6 backdrop-blur-lg hover:transform hover:scale-105 transition-all duration-300">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-liver text-2xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Liver Health</h3>
                <p class="text-gray-300">Check your liver function indicators</p>
            </div>
            <button onclick="openModal('liver')" 
                    class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:shadow-2xl hover:shadow-green-500/25 transition-all duration-300">
                Analyze Liver Health
            </button>
        </div>

        <!-- kidney Disease Prediction Card -->
        <div class="bg-gradient-to-br from-green-500/10 to-emerald-600/10 border border-green-500/20 rounded-2xl p-6 backdrop-blur-lg hover:transform hover:scale-105 transition-all duration-300">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-liver text-2xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">kidney disease</h3>
                <p class="text-gray-300">Check your kidney function indicators</p>
            </div>
            <button onclick="openModal('kidney')" 
                    class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:shadow-2xl hover:shadow-green-500/25 transition-all duration-300">
                Analyze Kidney Health
            </button>
        </div>
        <!-- Kidney Disease Prediction Modal -->
        <div id="kidney-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto border border-green-500/30 shadow-2xl shadow-green-500/20">
                
                <!-- Header -->
                <div class="border-b border-green-500/20 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-kidney text-xl text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Kidney Health Analysis</h2>
                                <p class="text-green-400">Complete the form below for accurate prediction</p>
                            </div>
                        </div>
                        <button onclick="closeModal('kidney')" class="text-gray-400 hover:text-white text-2xl">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Progress Indicator -->
                <div class="px-6 pt-4">
                    <div class="flex items-center space-x-2 text-sm text-gray-400">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span>Step 1: Basic Information</span>
                        <div class="flex-1 h-0.5 bg-gray-700 mx-2"></div>
                        <div class="w-3 h-3 bg-gray-600 rounded-full"></div>
                        <span>Step 2: Test Results</span>
                        <div class="flex-1 h-0.5 bg-gray-700 mx-2"></div>
                        <div class="w-3 h-3 bg-gray-600 rounded-full"></div>
                        <span>Step 3: Medical History</span>
                    </div>
                </div>

                <!-- Form -->
                <form id="kidney-form" class="p-6 space-y-6">
                    <!-- Step 1: Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-green-400 mb-2">
                                <i class="fas fa-birthday-cake mr-2"></i>Age
                            </label>
                            <input type="number" name="age" min="1" max="120" required
                                    class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                    placeholder="Enter your age">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-400 mb-2">
                                <i class="fas fa-tachometer-alt mr-2"></i>Blood Pressure (mm/Hg)
                            </label>
                            <input type="number" name="bp" min="50" max="250" required
                                    class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                    placeholder="e.g., 120">
                        </div>
                    </div>

                    <!-- Step 2: Urine Test Results -->
                    <div class="border-t border-green-500/20 pt-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-flask mr-2 text-green-400"></i>Urine Test Results
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Specific Gravity</label>
                                <input type="number" step="0.001" name="sg" min="1.005" max="1.025" required
                                        class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                        placeholder="1.010 - 1.025">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Albumin Level</label>
                                <select name="al" required class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                    <option value="">Select Level</option>
                                    <option value="0">0 - Normal</option>
                                    <option value="1">1 - Trace</option>
                                    <option value="2">2 - Moderate</option>
                                    <option value="3">3 - Severe</option>
                                    <option value="4">4 - Very Severe</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Sugar Level</label>
                                <select name="su" required class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                    <option value="">Select Level</option>
                                    <option value="0">0 - Normal</option>
                                    <option value="1">1 - Trace</option>
                                    <option value="2">2 - Moderate</option>
                                    <option value="3">3 - Severe</option>
                                    <option value="4">4 - Very Severe</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Blood Test Results -->
                    <div class="border-t border-green-500/20 pt-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-tint mr-2 text-green-400"></i>Blood Test Results
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Blood Glucose (mg/dl)</label>
                                <input type="number" name="bgr" min="50" max="500" required
                                        class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                        placeholder="e.g., 100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Blood Urea (mg/dl)</label>
                                <input type="number" name="bu" min="10" max="200" required
                                        class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                        placeholder="e.g., 40">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Serum Creatinine (mg/dl)</label>
                                <input type="number" step="0.1" name="sc" min="0.5" max="15.0" required
                                        class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                        placeholder="e.g., 1.2">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Hemoglobin (g/dl)</label>
                                <input type="number" step="0.1" name="hemo" min="3.0" max="20.0" required
                                        class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                        placeholder="e.g., 14.5">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Packed Cell Volume (%)</label>
                                <input type="number" name="pcv" min="20" max="60" required
                                        class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                        placeholder="e.g., 45">
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Medical History & Microscopy -->
                    <div class="border-t border-green-500/20 pt-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-stethoscope mr-2 text-green-400"></i>Medical History & Microscopy
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Red Blood Cells</label>
                                <select name="rbc" required class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                    <option value="">Select</option>
                                    <option value="0">Normal</option>
                                    <option value="1">Abnormal</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Pus Cells</label>
                                <select name="pc" required class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                    <option value="">Select</option>
                                    <option value="0">Normal</option>
                                    <option value="1">Abnormal</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Hypertension</label>
                                <select name="htn" required class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                    <option value="">Select</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Diabetes</label>
                                <select name="dm" required class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                    <option value="">Select</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-400 mb-2">Appetite</label>
                                <select name="appet" required class="w-full bg-slate-800 border border-green-500/30 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                    <option value="">Select</option>
                                    <option value="1">Good</option>
                                    <option value="0">Poor</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-green-400 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-green-400 mb-1">Where to get these tests?</h4>
                                <p class="text-gray-300 text-sm">
                                    These are standard medical tests available at any clinic or diagnostic lab. 
                                    Ask for: <strong>Complete Blood Count, Kidney Function Test, and Urine Analysis</strong>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-4 pt-4">
                        <button type="button" onclick="closeModal('kidney')" 
                                class="flex-1 bg-gray-700 text-white py-4 rounded-xl font-semibold hover:bg-gray-600 transition-all duration-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-xl font-semibold hover:shadow-2xl hover:shadow-green-500/25 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-brain mr-2"></i>Analyze Kidney Health
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div id="resultsSection" class="hidden bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl p-8 mb-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-white mb-2" id="resultTitle">Prediction Results</h2>
            <p class="text-gray-300 mb-6" id="resultSubtitle">Your health assessment results</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Risk Score -->
                <div class="text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        <canvas id="riskGauge"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold text-white" id="riskPercentage">0%</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-white">Risk Score</h3>
                </div>

                <!-- Risk Level -->
                <div class="text-center">
                    <div id="riskLevelBadge" class="text-6xl mb-4">⚠️</div>
                    <h3 class="text-xl font-semibold text-white">Risk Level</h3>
                    <p class="text-2xl font-bold mt-2" id="riskLevelText">-</p>
                </div>

                <!-- Recommendations -->
                <div class="text-center">
                    <div class="text-4xl mb-4">💡</div>
                    <h3 class="text-xl font-semibold text-white">Recommendations</h3>
                    <ul class="mt-4 text-left text-gray-300" id="recommendationsList"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 text-center border border-white/10">
            <i class="fas fa-brain text-4xl text-cyan-400 mb-4"></i>
            <h3 class="text-2xl font-bold text-white">95%</h3>
            <p class="text-gray-300">Prediction Accuracy</p>
        </div>
        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 text-center border border-white/10">
            <i class="fas fa-database text-4xl text-purple-400 mb-4"></i>
            <h3 class="text-2xl font-bold text-white">10K+</h3>
            <p class="text-gray-300">Health Records Analyzed</p>
        </div>
        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 text-center border border-white/10">
            <i class="fas fa-shield-alt text-4xl text-green-400 mb-4"></i>
            <h3 class="text-2xl font-bold text-white">100%</h3>
            <p class="text-gray-300">Data Privacy</p>
        </div>
    </div>

    <!-- Heart Disease Modal -->
    <div id="heartModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden z-50 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
            <div class="inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-red-500/30 rounded-2xl shadow-2xl">
                    <!-- Header -->
                    <div class="border-b border-red-500/20 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-heart-pulse text-xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">Heart Disease Risk Assessment</h3>
                                    <p class="text-gray-400">Fill in your health parameters</p>
                                </div>
                            </div>
                            <button onclick="closeModal('heart')" class="text-gray-400 hover:text-white text-2xl">
                                &times;
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form id="heartForm" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-white mb-2">Age</label>
                                <input type="number" name="age" class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500" min="1" max="120" required>
                            </div>
                            <div>
                                <label class="block text-white mb-2">Gender</label>
                                <select name="gender" class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-white mb-2">Chest Pain Type (0-3)</label>
                                <input type="number" name="chest_pain" class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500" min="0" max="3" required>
                            </div>
                            <div>
                                <label class="block text-white mb-2">Blood Pressure</label>
                                <input type="number" name="blood_pressure" class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500" min="50" max="250" required>
                            </div>
                            <div>
                                <label class="block text-white mb-2">Cholesterol</label>
                                <input type="number" name="cholesterol" class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500" min="100" max="600" required>
                            </div>
                            <div>
                                <label class="block text-white mb-2">Fasting Blood Sugar > 120</label>
                                <select name="blood_sugar" class="w-full bg-slate-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <!-- Add more form fields for heart disease -->
                        </div>
                        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700">
                            <button type="button" onclick="closeModal('heart')" class="px-6 py-3 border border-gray-600 text-gray-300 rounded-xl hover:bg-gray-700 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-red-500/25 transition-all">
                                Analyze Risk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('viewport_vendor_js')
@endsection

@section('viewport_page_js')
    <script>
        // Modal functions
        function openModal(type) {
            if (type === 'kidney') {
                document.getElementById('kidney-modal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                document.getElementById(type + 'Modal').classList.remove('hidden');
            }
        }

        function closeModal(type) {
            if (type === 'kidney') {
                document.getElementById('kidney-modal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            } else {
                document.getElementById(type + 'Modal').classList.add('hidden');
            }
        }

        // Form submissions
        document.getElementById('heartForm').addEventListener('submit', function(e) {
            e.preventDefault();
            predictHeartDisease();
        });

        // Kidney form submission
        document.getElementById('kidney-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Analyzing...';
            submitBtn.disabled = true;
            
            // Send to backend (you'll implement this)
            fetch('/predict/kidney', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                // Show results (you'll implement this)
                showKidneyResults(result);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error analyzing kidney health. Please try again.');
            })
            .finally(() => {
                submitBtn.innerHTML = '<i class="fas fa-brain mr-2"></i>Analyze Kidney Health';
                submitBtn.disabled = false;
            });
        });

        async function predictHeartDisease() {
            const formData = new FormData(document.getElementById('heartForm'));
            const data = Object.fromEntries(formData);
            
            // Convert boolean strings to actual booleans
            data.blood_sugar = data.blood_sugar === '1';
            data.exercise_angina = data.exercise_angina === '1';

            try {
                const response = await fetch('{{ route("predict.heart") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                displayResults(result, 'Heart Disease');
                closeModal('heart');
            } catch (error) {
                console.error('Error:', error);
                alert('Error making prediction. Please try again.');
            }
        }

        function displayResults(result, disease) {
            const resultsSection = document.getElementById('resultsSection');
            const riskPercentage = document.getElementById('riskPercentage');
            const riskLevelText = document.getElementById('riskLevelText');
            const recommendationsList = document.getElementById('recommendationsList');
            const resultTitle = document.getElementById('resultTitle');
            const resultSubtitle = document.getElementById('resultSubtitle');

            resultTitle.textContent = `${disease} Risk Assessment`;
            resultSubtitle.textContent = 'Your personalized health analysis';
            riskPercentage.textContent = Math.round(result.risk_score * 100) + '%';
            riskLevelText.textContent = result.risk_level;
            
            // Update risk level badge
            const riskLevelBadge = document.getElementById('riskLevelBadge');
            if (result.risk_level === 'Low') {
                riskLevelBadge.innerHTML = '✅';
                riskLevelText.className = 'text-2xl font-bold mt-2 text-green-400';
            } else if (result.risk_level === 'Moderate') {
                riskLevelBadge.innerHTML = '⚠️';
                riskLevelText.className = 'text-2xl font-bold mt-2 text-yellow-400';
            } else {
                riskLevelBadge.innerHTML = '🚨';
                riskLevelText.className = 'text-2xl font-bold mt-2 text-red-400';
            }

            // Update recommendations
            recommendationsList.innerHTML = '';
            result.recommendations.forEach(rec => {
                const li = document.createElement('li');
                li.className = 'flex items-center mb-2';
                li.innerHTML = `<i class="fas fa-check text-green-400 mr-3"></i> ${rec}`;
                recommendationsList.appendChild(li);
            });

            // Update gauge chart
            updateRiskGauge(result.risk_score);
            
            resultsSection.classList.remove('hidden');
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }

        function updateRiskGauge(score) {
            const ctx = document.getElementById('riskGauge').getContext('2d');
            const percentage = score * 100;
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [percentage, 100 - percentage],
                        backgroundColor: [
                            getRiskColor(score),
                            '#374151'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '75%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        }

        function getRiskColor(score) {
            if (score < 0.3) return '#10B981'; // Green
            if (score < 0.7) return '#F59E0B'; // Yellow
            return '#EF4444'; // Red
        }

        function showKidneyResults(result) {
            // Close modal
            closeModal('kidney');
            
            // Show results in a new modal or page
            // You'll implement this based on your backend response
            alert('Prediction complete! Risk level: ' + result.risk_level);
        }

        // Close modals on outside click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed')) {
                e.target.classList.add('hidden');
            }
        });

        // Close kidney modal when clicking outside
        document.getElementById('kidney-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('kidney');
            }
        });
    </script>
@endsection