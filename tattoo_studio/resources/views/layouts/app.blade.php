<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ink Studio - Sistema de Gestão para Studio de Tatuagem">
    <title>@yield('title', 'Ink Studio') | Ink Studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Outfit', sans-serif; }
        body { background-color: #0a0a0f; color: #e8e8f0; }

        /* Sidebar */
        .sidebar { background: linear-gradient(180deg, #12121a 0%, #0a0a0f 100%); border-right: 1px solid rgba(212,168,83,0.15); }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 20px; border-radius: 10px; transition: all 0.2s; color: #9898b8; font-weight: 500; text-decoration: none; margin-bottom: 4px; }
        .nav-link:hover { background: rgba(212,168,83,0.08); color: #d4a853; }
        .nav-link.active { background: linear-gradient(135deg, rgba(212,168,83,0.2), rgba(212,168,83,0.08)); color: #d4a853; border: 1px solid rgba(212,168,83,0.3); }
        .nav-link svg { width: 20px; height: 20px; flex-shrink: 0; }

        /* Cards */
        .card { background: #12121a; border: 1px solid rgba(212,168,83,0.1); border-radius: 16px; }
        .card-gold { background: linear-gradient(135deg, rgba(212,168,83,0.15), rgba(212,168,83,0.05)); border: 1px solid rgba(212,168,83,0.3); border-radius: 16px; }

        /* Stat cards */
        .stat-card { background: #12121a; border: 1px solid #252535; border-radius: 16px; padding: 24px; transition: transform 0.2s, border-color 0.2s; }
        .stat-card:hover { transform: translateY(-2px); border-color: rgba(212,168,83,0.3); }

        /* Buttons */
        .btn-primary { background: linear-gradient(135deg, #d4a853, #b8902e); color: #0a0a0f; font-weight: 600; padding: 10px 24px; border-radius: 10px; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; }
        .btn-primary:hover { background: linear-gradient(135deg, #e0bc6e, #d4a853); transform: translateY(-1px); box-shadow: 0 4px 20px rgba(212,168,83,0.3); }
        .btn-secondary { background: transparent; border: 1px solid #252535; color: #9898b8; padding: 10px 24px; border-radius: 10px; transition: all 0.2s; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { border-color: rgba(212,168,83,0.4); color: #d4a853; }
        .btn-danger { background: rgba(192,57,43,0.15); border: 1px solid rgba(192,57,43,0.3); color: #e74c3c; padding: 10px 24px; border-radius: 10px; transition: all 0.2s; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-danger:hover { background: rgba(192,57,43,0.25); }
        .btn-sm { padding: 6px 14px; font-size: 0.85rem; }

        /* Forms */
        .form-input { background: #1a1a28; border: 1px solid #252535; color: #e8e8f0; padding: 12px 16px; border-radius: 10px; width: 100%; transition: border-color 0.2s; font-size: 0.95rem; }
        .form-input:focus { outline: none; border-color: rgba(212,168,83,0.5); box-shadow: 0 0 0 3px rgba(212,168,83,0.1); }
        .form-input::placeholder { color: #4a4a6a; }
        .form-label { display: block; font-weight: 500; color: #c4c4d8; margin-bottom: 6px; font-size: 0.9rem; }
        .form-select { background: #1a1a28; border: 1px solid #252535; color: #e8e8f0; padding: 12px 16px; border-radius: 10px; width: 100%; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239898b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; }
        .form-select:focus { outline: none; border-color: rgba(212,168,83,0.5); }
        .form-group { margin-bottom: 20px; }

        /* Tables */
        .table-container { overflow-x: auto; border-radius: 16px; border: 1px solid #252535; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #1a1a28; color: #9898b8; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 14px 20px; text-align: left; }
        tbody td { padding: 16px 20px; border-top: 1px solid #1a1a28; color: #c4c4d8; font-size: 0.9rem; }
        tbody tr:hover { background: #12121a; }

        /* Badges */
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-yellow { background: rgba(234,179,8,0.15); color: #eab308; border: 1px solid rgba(234,179,8,0.3); }
        .badge-blue { background: rgba(59,130,246,0.15); color: #60a5fa; border: 1px solid rgba(59,130,246,0.3); }
        .badge-green { background: rgba(34,197,94,0.15); color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }
        .badge-red { background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }
        .badge-gold { background: rgba(212,168,83,0.15); color: #d4a853; border: 1px solid rgba(212,168,83,0.3); }

        /* Stars */
        .star { color: #252535; font-size: 1.1rem; }
        .star.filled { color: #d4a853; }

        /* Avatar */
        .avatar { border-radius: 50%; object-fit: cover; background: #1a1a28; border: 2px solid #252535; }
        .avatar-placeholder { display: flex; align-items: center; justify-content: center; border-radius: 50%; background: linear-gradient(135deg, #252535, #1a1a28); color: #9898b8; font-weight: 700; }

        /* Page header */
        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-size: 1.75rem; font-weight: 700; color: #e8e8f0; }
        .page-header p { color: #6b6b8f; margin-top: 4px; }

        /* Section divider */
        .divider { border: none; border-top: 1px solid #252535; margin: 24px 0; }

        /* Alerts */
        .alert { padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: start; gap: 12px; font-size: 0.9rem; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; }
        .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
        .alert-warning { background: rgba(234,179,8,0.1); border: 1px solid rgba(234,179,8,0.3); color: #eab308; }

        /* Gallery grid */
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
        .gallery-card { position: relative; border-radius: 16px; overflow: hidden; border: 1px solid #252535; transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s; }
        .gallery-card:hover { transform: translateY(-6px); border-color: rgba(212,168,83,0.4); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .gallery-card img { width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s; }
        .gallery-card:hover img { transform: scale(1.05); }
        .gallery-card-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.9)); padding: 24px 16px 16px; }

        /* Logo */
        .logo-text { font-size: 1.4rem; font-weight: 800; background: linear-gradient(135deg, #d4a853, #ecce8a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Breadcrumb */
        .breadcrumb { display: flex; align-items: center; gap: 8px; color: #6b6b8f; font-size: 0.85rem; margin-bottom: 24px; }
        .breadcrumb a { color: #6b6b8f; text-decoration: none; transition: color 0.2s; }
        .breadcrumb a:hover { color: #d4a853; }

        /* Profile image upload */
        .upload-area { border: 2px dashed #252535; border-radius: 12px; padding: 32px; text-align: center; cursor: pointer; transition: border-color 0.2s; }
        .upload-area:hover { border-color: rgba(212,168,83,0.4); }

        /* Rating stars input */
        .rating-input { display: flex; flex-direction: row-reverse; gap: 6px; }
        .rating-input input { display: none; }
        .rating-input label { cursor: pointer; font-size: 1.8rem; color: #252535; transition: color 0.1s; }
        .rating-input label:hover, .rating-input label:hover ~ label,
        .rating-input input:checked ~ label { color: #d4a853; }

        /* Scroll */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0a0a0f; }
        ::-webkit-scrollbar-thumb { background: #252535; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #32324a; }

        /* Animations */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.3s ease; }

        /* Pagination */
        .pagination { display: flex; gap: 6px; justify-content: center; margin-top: 32px; }
        .pagination a, .pagination span { padding: 8px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: all 0.2s; }
        .pagination a { background: #1a1a28; border: 1px solid #252535; color: #9898b8; }
        .pagination a:hover { border-color: rgba(212,168,83,0.4); color: #d4a853; }
        .pagination span.active-page { background: linear-gradient(135deg, #d4a853, #b8902e); color: #0a0a0f; border: none; }
        .pagination span.disabled { background: #12121a; border: 1px solid #1a1a28; color: #4a4a6a; cursor: not-allowed; }
    </style>
</head>
<body class="h-full flex">

    <!-- Sidebar -->
    <aside class="sidebar w-64 min-h-screen flex flex-col fixed left-0 top-0 z-30">
        <!-- Logo -->
        <div class="p-6 border-b border-yellow-900/20">
            <div class="flex items-center gap-3">
                <div style="width:40px;height:40px;background:linear-gradient(135deg,#d4a853,#b8902e);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0a0a0f" stroke-width="2.5">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <div>
                    <div class="logo-text">Ink Studio</div>
                    <div style="font-size:0.7rem;color:#4a4a6a;font-weight:500;margin-top:-2px;">Sistema de Gestão</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4">
            <div style="font-size:0.7rem;color:#4a4a6a;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;padding: 0 8px;margin-bottom:12px;">Menu Principal</div>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('agendamentos.index') }}" class="nav-link {{ request()->routeIs('agendamentos.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Agendamentos
            </a>

            <a href="{{ route('galerias.index') }}" class="nav-link {{ request()->routeIs('galerias.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                </svg>
                Galeria
            </a>

            <a href="{{ route('funcionarios.index') }}" class="nav-link {{ request()->routeIs('funcionarios.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Funcionários
            </a>

            <div style="font-size:0.7rem;color:#4a4a6a;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;padding: 0 8px;margin: 20px 0 12px;">Atalhos</div>

            <a href="{{ route('agendamentos.create') }}" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Novo Agendamento
            </a>

            <a href="{{ route('funcionarios.create') }}" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Novo Funcionário
            </a>
        </nav>

        <!-- Footer info -->
        <div class="p-4 border-t border-yellow-900/20">
            <div style="font-size:0.75rem;color:#4a4a6a;text-align:center;">
                Ink Studio &copy; {{ date('Y') }}<br>
                <span style="color:#252535">v1.0.0</span>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 ml-64 min-h-screen">
        <!-- Top bar -->
        <header style="background:#0a0a0f;border-bottom:1px solid #1a1a28;padding:16px 32px;position:sticky;top:0;z-index:20;">
            <div class="flex items-center justify-between">
                <div>
                    @hasSection('breadcrumb')
                        <div class="breadcrumb">@yield('breadcrumb')</div>
                    @endif
                    <h1 style="font-size:1.2rem;font-weight:600;color:#e8e8f0;">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div style="font-size:0.85rem;color:#6b6b8f;">
                        {{ now()->format('d/m/Y') }}
                    </div>
                    <div style="width:1px;height:28px;background:#1a1a28;"></div>
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#d4a853,#b8902e);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0a0a0f" stroke-width="2.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="p-8 fade-in">
            <!-- Flash messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        <strong>Erro de validação:</strong>
                        <ul style="margin-top:6px;padding-left:20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Auto-hide alerts after 5s
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);

        // Image preview on file input
        document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
            input.addEventListener('change', function() {
                const preview = document.getElementById(this.dataset.preview);
                if (preview && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => preview.src = e.target.result;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
