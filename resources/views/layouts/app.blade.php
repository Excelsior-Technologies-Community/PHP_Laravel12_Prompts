<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
        .badge-danger { background: #ef4444; color: white; }
        .badge-warning { background: #f59e0b; color: white; }
        .badge-success { background: #10b981; color: white; }
        .badge-primary { background: #3b82f6; color: white; }
        .badge-secondary { background: #6b7280; color: white; }
        .btn-custom {
            border-radius: 25px;
            padding: 8px 20px;
        }
        .task-card {
            transition: transform 0.2s;
        }
        .task-card:hover {
            transform: translateY(-2px);
        }
        .featured-star {
            color: #fbbf24;
            cursor: pointer;
        }
        .search-bar {
            background: white;
            border-radius: 50px;
            padding: 5px 15px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-custom">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>