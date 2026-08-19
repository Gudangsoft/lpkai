@php $loginProfile = \App\Models\Profile::first(); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - {{ $loginProfile->singkatan ?? 'LPPSP' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    @if($loginProfile && $loginProfile->favicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($loginProfile->favicon) }}">
        <link rel="shortcut icon" href="{{ Storage::url($loginProfile->favicon) }}">
        <link rel="apple-touch-icon" href="{{ Storage::url($loginProfile->favicon) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='6' fill='%231e3a8a'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' fill='white' font-size='14' font-weight='bold' font-family='Arial'%3EL%3C/text%3E%3C/svg%3E">
    @endif
</head>
<body>
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            @if($loginProfile && $loginProfile->logo)
                <img src="{{ Storage::url($loginProfile->logo) }}" alt="Logo" style="height:64px;object-fit:contain;margin-bottom:8px;">
            @else
                <i class="fas fa-building" style="font-size:2.5rem;color:#1e3a8a;display:block;margin-bottom:8px;"></i>
            @endif
            <h1 style="font-size:1.5rem;font-weight:800;color:#0d2b5e;margin:0 0 4px;">{{ $loginProfile->singkatan ?? 'LPPSP' }}</h1>
            <p>Panel Administrasi</p>
        </div>
        @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@lppsp.com">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <div class="form-check" style="margin-bottom:20px;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="font-size:.88rem;color:#718096;">Ingat saya</label>
            </div>
            <button type="submit" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Masuk</button>
        </form>
    </div>
</div>
</body>
</html>
