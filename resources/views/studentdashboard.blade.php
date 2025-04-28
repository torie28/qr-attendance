@extends('layouts.app')

@section('content')
<!-- Include Animate.css for nice entry animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- Particle.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<style>
    body {
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        min-height: 100vh;
        overflow-x: hidden;
        position: relative;
    }

    /* Particle container */
    #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 0;
        top: 0;
        left: 0;
    }

    /* Put content above particles */
    .content-container {
        position: relative;
        z-index: 1;
    }

    .card {
        border-radius: 20px;
        transition: transform 0.4s, box-shadow 0.4s;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
    }

    h2, .badge {
        color: #ffffff;
        text-shadow: 0 0 10px #00e6e6;
    }

    /* Progress Circle Base */
    .progress-circle-wrapper {
        width: 150px;
        height: 150px;
    }

    .progress-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: conic-gradient(#00e6e6 0% 0%, rgba(255, 255, 255, 0.1) 0% 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 0 20px #00e6e6;
        animation: pulse 2s infinite;
    }

    .attendance-text {
        font-size: 24px;
        font-weight: bold;
        color: #00e6e6;
        text-shadow: 0 0 8px #00e6e6;
    }

    /* Spinning Ring */
    .spinning-ring {
        position: absolute;
        top: -10px;
        left: -10px;
        width: 170px;
        height: 170px;
        border: 3px dashed #00e6e6;
        border-radius: 50%;
        animation: spin 8s linear infinite;
        opacity: 0.4;
    }

    /* Animations */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 20px #00e6e6; }
        50% { box-shadow: 0 0 40px #00e6e6; }
    }
</style>

<!-- Particle Background -->
<div id="particles-js"></div>

<!-- Main Content -->
<div class="container py-4 content-container animate__animated animate__fadeIn">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>👩‍🎓 Student Dashboard</h2>
                {{-- <span class="badge bg-primary fs-5">Welcome, {{ $user->name }}</span> --}}
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm animate__animated animate__zoomIn">
                <div class="card-header bg-success text-white">
                    Your Profile
                </div>
                <div class="card-body">
                    <p><strong>Course:</strong> {{ $user->course }}</p>
                    <p><strong>Admission No:</strong> {{ $user->admission_number }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm animate__animated animate__zoomIn animate__delay-1s">
                <div class="card-header bg-info text-white">
                    Attendance Summary
                </div>
                <div class="card-body text-center">
                    <div class="progress-circle-wrapper position-relative d-inline-block">
                        <div class="progress-circle" data-percentage="{{ $attendancePercentage }}">
                            <span class="attendance-text">{{ number_format($attendancePercentage, 0) }}%</span>
                        </div>
                        <div class="spinning-ring"></div>
                    </div>
                    <p class="text-muted mt-3">Overall Attendance</p>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-2s">
                <div class="card-header bg-dark text-white">
                    Attendance Records
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->time)->format('h:i A') }}</td>
                                    <td><span class="badge bg-secondary">{{ $attendance->course->name }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No attendance records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Particle.js Settings -->
<script>
particlesJS('particles-js',
  {
    "particles": {
      "number": {
        "value": 90,
        "density": {
          "enable": true,
          "value_area": 800
        }
      },
      "color": {
        "value": "#ffffff"
      },
      "shape": {
        "type": "circle",
        "stroke": {
          "width": 0,
          "color": "#000000"
        }
      },
      "opacity": {
        "value": 0.5,
        "random": false
      },
      "size": {
        "value": 3,
        "random": true
      },
      "line_linked": {
        "enable": true,
        "distance": 150,
        "color": "#00e6e6",
        "opacity": 0.4,
        "width": 1
      },
      "move": {
        "enable": true,
        "speed": 4,
        "direction": "none",
        "out_mode": "out"
      }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": {
          "enable": true,
          "mode": "repulse"
        },
        "onclick": {
          "enable": true,
          "mode": "push"
        }
      },
      "modes": {
        "repulse": {
          "distance": 100
        },
        "push": {
          "particles_nb": 4
        }
      }
    },
    "retina_detect": true
  }
);

// Progress Circle Update
document.addEventListener('DOMContentLoaded', function () {
    const progressCircles = document.querySelectorAll('.progress-circle');

    progressCircles.forEach(circle => {
        const percentage = parseFloat(circle.getAttribute('data-percentage')) || 0;
        const degrees = (percentage / 100) * 360;
        circle.style.background = `conic-gradient(#6400E6FF ${degrees}deg, rgba(255, 255, 255, 0.1) ${degrees}deg 360deg)`;
    });
});
</script>
@endsection
