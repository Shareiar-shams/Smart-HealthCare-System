<?php

namespace App\Http\Controllers\Viewport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicalLearningController extends Controller
{
    public function index()
    {
        $modules = $this->getLearningModules();
        $stats = $this->getLearningStats();
        
        return view('viewport.medicalLearning.index', [
            'modules' => $modules,
            'stats' => $stats
        ]);
    }

    public function showModule($id)
    {
        $module = $this->getModuleById($id);
        return view('viewport.medicalLearning.learning-module', ['module' => $module]);
    }

    private function getLearningModules()
    {
        return [
            'anatomy' => [
                'id' => 'anatomy',
                'title' => '3D Anatomy Mastery',
                'icon' => 'fas fa-brain',
                'color' => 'from-purple-500 to-blue-600',
                'border' => 'border-purple-500/30',
                'progress' => 65,
                'topics' => 24,
                'duration' => '48 hours',
                'resources' => 156,
                'description' => 'Interactive 3D anatomy with layer-by-layer dissection',
                'features' => ['3D Models', 'Virtual Dissection', 'Clinical Correlations', 'Spot Tests'],
                'expert' => 'Dr. Sarah Chen - Harvard Medical School',
                'youtube_playlist' => 'PL6gx4Cwl9DGBtNcOfCHF7dwb0n4q7mQl1'
            ],
            'surgery' => [
                'id' => 'surgery',
                'title' => 'Surgical Simulation',
                'icon' => 'fas fa-scalpel',
                'color' => 'from-red-500 to-pink-600',
                'border' => 'border-red-500/30',
                'progress' => 30,
                'topics' => 18,
                'duration' => '36 hours',
                'resources' => 89,
                'description' => 'Real surgical procedures with step-by-step guidance',
                'features' => ['Live Surgeries', 'Procedure Sims', 'Instrument Training', 'Suture Practice'],
                'expert' => 'Dr. Michael Rodriguez - Johns Hopkins',
                'youtube_playlist' => 'PL6gx4Cwl9DGBb3dC3d6d1q9c7Yx4mQl1'
            ],
            'pharmacology' => [
                'id' => 'pharmacology',
                'title' => 'Drug Mechanism Visualizer',
                'icon' => 'fas fa-pills',
                'color' => 'from-green-500 to-emerald-600',
                'border' => 'border-green-500/30',
                'progress' => 45,
                'topics' => 32,
                'duration' => '42 hours',
                'resources' => 203,
                'description' => 'Animated drug mechanisms and interactions',
                'features' => ['Mechanism Animations', 'Interaction Sims', 'Dosing Calculators', 'Side Effects'],
                'expert' => 'Dr. Emily Watson - Stanford Medicine',
                'youtube_playlist' => 'PL6gx4Cwl9DGBc3dC3d6d1q9c7Yx4mQl2'
            ],
            'pathology' => [
                'id' => 'pathology',
                'title' => 'Digital Pathology Lab',
                'icon' => 'fas fa-microscope',
                'color' => 'from-orange-500 to-red-600',
                'border' => 'border-orange-500/30',
                'progress' => 20,
                'topics' => 28,
                'duration' => '52 hours',
                'resources' => 167,
                'description' => 'Virtual microscopy and disease progression',
                'features' => ['Virtual Microscopy', 'Case Studies', 'Differential DX', 'Histology Slides'],
                'expert' => 'Dr. James Kim - Mayo Clinic',
                'youtube_playlist' => 'PL6gx4Cwl9DGBd3dC3d6d1q9c7Yx4mQl3'
            ],
            'clinical' => [
                'id' => 'clinical',
                'title' => 'Clinical Skills Center',
                'icon' => 'fas fa-stethoscope',
                'color' => 'from-cyan-500 to-blue-600',
                'border' => 'border-cyan-500/30',
                'progress' => 75,
                'topics' => 45,
                'duration' => '60 hours',
                'resources' => 234,
                'description' => 'Patient examination and diagnostic reasoning',
                'features' => ['Patient Sims', 'Exam Techniques', 'Diagnostic Logic', 'Procedural Skills'],
                'expert' => 'Dr. Amanda Lee - Cleveland Clinic',
                'youtube_playlist' => 'PL6gx4Cwl9DGBf3dC3d6d1q9c7Yx4mQl4'
            ],
            'imaging' => [
                'id' => 'imaging',
                'title' => 'Medical Imaging Academy',
                'icon' => 'fas fa-x-ray',
                'color' => 'from-yellow-500 to-orange-600',
                'border' => 'border-yellow-500/30',
                'progress' => 55,
                'topics' => 22,
                'duration' => '38 hours',
                'resources' => 145,
                'description' => 'Radiology interpretation and diagnostic imaging',
                'features' => ['X-ray Reading', 'CT/MRI Analysis', 'Ultrasound Sims', 'Pathology Correlation'],
                'expert' => 'Dr. Robert Chen - Mass General',
                'youtube_playlist' => 'PL6gx4Cwl9DGBg3dC3d6d1q9c7Yx4mQl5'
            ]
        ];
    }

    private function getLearningStats()
    {
        return [
            'total_modules' => 6,
            'completed' => 2,
            'in_progress' => 3,
            'total_hours' => 276,
            'expert_sessions' => 45,
            'surgical_sims' => 28,
            'success_rate' => 87
        ];
    }

    private function getModuleById($id)
    {
        $modules = $this->getLearningModules();
        return $modules[$id] ?? null;
    }

    public function completeModule(Request $request)
    {
        // In real app, save progress to database
        return response()->json([
            'success' => true,
            'message' => 'Module progress updated successfully!',
            'progress' => $request->progress
        ]);
    }
}