@extends('layouts.guest')

@push('styles')
<style>
    /* Nova estrutura do layout de login */
    .login-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        max-width: 1000px;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 600px;
    }

    .login-left {
        background: linear-gradient(135deg, #066fd1 0%, #0ea5e9 100%);
        position: relative;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
        overflow: hidden;
    }

    .login-left::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: url("data:image/svg+xml,%3csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3e%3cdefs%3e%3cpattern id='grid' width='20' height='20' patternUnits='userSpaceOnUse'%3e%3cpath d='M 20 0 L 0 0 0 20' fill='none' stroke='rgba(255,255,255,0.1)' stroke-width='1'/%3e%3c/pattern%3e%3c/defs%3e%3crect width='100' height='100' fill='url(%23grid)' /%3e%3c/svg%3e") repeat;
        animation: gridMove 20s linear infinite;
    }

    @keyframes gridMove {
        0% { transform: translate(0, 0); }
        100% { transform: translate(20px, 20px); }
    }

    .login-left-content {
        position: relative;
        z-index: 2;
    }

    .system-logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .system-logo svg {
        width: 120px;
        height: auto;
        filter: brightness(0) invert(1);
    }

    .system-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .system-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        text-align: center;
        margin-bottom: 2rem;
    }

    .company-showcase {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s ease;
    }

    .company-showcase.show {
        opacity: 1;
        transform: translateY(0);
    }

    .company-showcase-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .company-logo-container {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .company-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .company-initial {
        color: #066fd1;
        font-weight: 700;
        font-size: 24px;
        text-transform: uppercase;
    }

    .company-info {
        flex: 1;
    }

    .company-name {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0 0 5px 0;
        line-height: 1.2;
    }

    .company-cnpj {
        font-size: 0.9rem;
        opacity: 0.8;
        margin: 0;
    }

    .welcome-message {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        font-size: 1.1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .welcome-message .user-name {
        font-weight: 600;
        font-size: 1.2rem;
    }

    .login-right {
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    .form-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .form-subtitle {
        color: #64748b;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #374151;
        font-size: 0.95rem;
    }

    .input-wrapper {
        position: relative;
    }

    .form-control-modern {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #066fd1;
        background: white;
        box-shadow: 0 0 0 3px rgba(6, 111, 209, 0.1);
    }

    .form-control-modern.loading {
        background-image: url("data:image/svg+xml,%3csvg width='20' height='20' viewBox='0 0 20 20' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cg%3e%3ccircle cx='10' cy='10' r='8' stroke='%23066fd1' stroke-opacity='0.25' stroke-width='2'%3e%3c/circle%3e%3cpath d='M18 10a8 8 0 00-8-8' stroke='%23066fd1' stroke-width='2' stroke-linecap='round'%3e%3canimateTransform attributeName='transform' type='rotate' dur='1s' repeatCount='indefinite' values='0 10 10;360 10 10'%3e%3c/animateTransform%3e%3c/path%3e%3c/g%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 20px 20px;
        padding-right: 50px;
    }

    .btn-modern {
        width: 100%;
        padding: 15px 25px;
        background: linear-gradient(135deg, #066fd1 0%, #0ea5e9 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(6, 111, 209, 0.3);
    }

    .btn-modern:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .success-indicator {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #10b981;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .success-indicator.show {
        opacity: 1;
        animation: successPulse 0.5s ease;
    }

    @keyframes successPulse {
        0% { transform: translateY(-50%) scale(0.5); }
        50% { transform: translateY(-50%) scale(1.2); }
        100% { transform: translateY(-50%) scale(1); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .login-card {
            grid-template-columns: 1fr;
            margin: 10px;
            border-radius: 15px;
        }

        .login-left {
            padding: 30px 20px;
            min-height: 300px;
        }

        .login-right {
            padding: 40px 30px;
        }

        .system-title {
            font-size: 2rem;
        }

        .form-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .login-container {
            padding: 10px;
        }
        
        .login-left {
            padding: 20px 15px;
        }

        .login-right {
            padding: 30px 20px;
        }
    }
</style>
@endpush

@section('content')
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
            <div class="container container-tight my-5 px-lg-5">
                <div class="text-center mb-4">
                    <!-- BEGIN NAVBAR LOGO -->
                    <a href="/" aria-label="Tabler" class="navbar-brand navbar-brand-autodark">
                        <!-- SVG LOGO -->
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="110" height="32" viewBox="0 0 232 68"
                            class="navbar-brand-image">
                            <path
                                d="M64.6 16.2C63 9.9 58.1 5 51.8 3.4 40 1.5 28 1.5 16.2 3.4 9.9 5 5 9.9 3.4 16.2 1.5 28 1.5 40 3.4 51.8 5 58.1 9.9 63 16.2 64.6c11.8 1.9 23.8 1.9 35.6 0C58.1 63 63 58.1 64.6 51.8c1.9-11.8 1.9-23.8 0-35.6zM33.3 36.3c-2.8 4.4-6.6 8.2-11.1 11-1.5.9-3.3.9-4.8.1s-2.4-2.3-2.5-4c0-1.7.9-3.3 2.4-4.1 2.3-1.4 4.4-3.2 6.1-5.3-1.8-2.1-3.8-3.8-6.1-5.3-2.3-1.3-3-4.2-1.7-6.4s4.3-2.9 6.5-1.6c4.5 2.8 8.2 6.5 11.1 10.9 1 1.4 1 3.3.1 4.7zM49.2 46H37.8c-2.1 0-3.8-1-3.8-3s1.7-3 3.8-3h11.4c2.1 0 3.8 1 3.8 3s-1.7 3-3.8 3z"
                                fill="#066fd1" style="fill: var(--tblr-primary, #066fd1)"></path>
                            <path
                                d="M105.8 46.1c.4 0 .9.2 1.2.6s.6 1 .6 1.7c0 .9-.5 1.6-1.4 2.2s-2 .9-3.2.9c-2 0-3.7-.4-5-1.3s-2-2.6-2-5.4V31.6h-2.2c-.8 0-1.4-.3-1.9-.8s-.9-1.1-.9-1.9c0-.7.3-1.4.8-1.8s1.2-.7 1.9-.7h2.2v-3.1c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v3.1h3.4c.8 0 1.4.3 1.9.8s.8 1.2.8 1.9-.3 1.4-.8 1.8-1.2.7-1.9.7h-3.4v13c0 .7.2 1.2.5 1.5s.8.5 1.4.5c.3 0 .6-.1 1.1-.2.5-.2.8-.3 1.2-.3zm28-20.7c.8 0 1.5.3 2.1.8.5.5.8 1.2.8 2.1v20.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2-.8-.8-1.2-.8-2.1c-.8.9-1.9 1.7-3.2 2.4-1.3.7-2.8 1-4.3 1-2.2 0-4.2-.6-6-1.7-1.8-1.1-3.2-2.7-4.2-4.7s-1.6-4.3-1.6-6.9c0-2.6.5-4.9 1.5-6.9s2.4-3.6 4.2-4.8c1.8-1.1 3.7-1.7 5.9-1.7 1.5 0 3 .3 4.3.8 1.3.6 2.5 1.3 3.4 2.1 0-.8.3-1.5.8-2.1.5-.5 1.2-.7 2-.7zm-9.7 21.3c2.1 0 3.8-.8 5.1-2.3s2-3.4 2-5.7-.7-4.2-2-5.8c-1.3-1.5-3-2.3-5.1-2.3-2 0-3.7.8-5 2.3-1.3 1.5-2 3.5-2 5.8s.6 4.2 1.9 5.7 3 2.3 5.1 2.3zm32.1-21.3c2.2 0 4.2.6 6 1.7 1.8 1.1 3.2 2.7 4.2 4.7s1.6 4.3 1.6 6.9-.5 4.9-1.5 6.9-2.4 3.6-4.2 4.8c-1.8 1.1-3.7 1.7-5.9 1.7-1.5 0-3-.3-4.3-.9s-2.5-1.4-3.4-2.3v.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.5-.8-1.2-.8-2.1V18.9c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v10c.8-1 1.8-1.8 3.2-2.5 1.3-.7 2.8-1 4.3-1zm-.7 21.3c2 0 3.7-.8 5-2.3s2-3.5 2-5.8-.6-4.2-1.9-5.7-3-2.3-5.1-2.3-3.8.8-5.1 2.3-2 3.4-2 5.7.7 4.2 2 5.8c1.3 1.6 3 2.3 5.1 2.3zm23.6 1.9c0 .8-.3 1.5-.8 2.1s-1.3.8-2.1.8-1.5-.3-2-.8-.8-1.3-.8-2.1V18.9c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v29.7zm29.3-10.5c0 .8-.3 1.4-.9 1.9-.6.5-1.2.7-2 .7h-15.8c.4 1.9 1.3 3.4 2.6 4.4 1.4 1.1 2.9 1.6 4.7 1.6 1.3 0 2.3-.1 3.1-.4.7-.2 1.3-.5 1.8-.8.4-.3.7-.5.9-.6.6-.3 1.1-.4 1.6-.4.7 0 1.2.2 1.7.7s.7 1 .7 1.7c0 .9-.4 1.6-1.3 2.4-.9.7-2.1 1.4-3.6 1.9s-3 .8-4.6.8c-2.7 0-5-.6-7-1.7s-3.5-2.7-4.6-4.6-1.6-4.2-1.6-6.6c0-2.8.6-5.2 1.7-7.2s2.7-3.7 4.6-4.8 3.9-1.7 6-1.7 4.1.6 6 1.7 3.4 2.7 4.5 4.7c.9 1.9 1.5 4.1 1.5 6.3zm-12.2-7.5c-3.7 0-5.9 1.7-6.6 5.2h12.6v-.3c-.1-1.3-.8-2.5-2-3.5s-2.5-1.4-4-1.4zm30.3-5.2c1 0 1.8.3 2.4.8.7.5 1 1.2 1 1.9 0 1-.3 1.7-.8 2.2-.5.5-1.1.8-1.8.7-.5 0-1-.1-1.6-.3-.2-.1-.4-.1-.6-.2-.4-.1-.7-.1-1.1-.1-.8 0-1.6.3-2.4.8s-1.4 1.3-1.9 2.3-.7 2.3-.7 3.7v11.4c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.6-.8-1.3-.8-2.1V28.8c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v.6c.7-1.3 1.8-2.3 3.2-3 1.3-.7 2.8-1 4.3-1z"
                                fill-rule="evenodd" clip-rule="evenodd" fill="#4a4a4a"></path>
                        </svg> -->
                    </a>
                    <!-- END NAVBAR LOGO -->
                </div>
                <div class="text-center mb-4">
                    <h1
                        style="font-size:2.1rem; font-weight:700; color:#066fd1; margin-bottom: 0.5rem; letter-spacing: 1px;">
                        Bem-vindo ao sistema</h1>
                    <span
                        style="font-size:1.25rem; color:#333; font-weight:500; display:block; margin-bottom: 0.7rem;">CutPlan
                        - Corte e Planejamento</span>
                    <h2
                        style="font-size:1.3rem; color:#555; font-weight:400; margin-top:1.2rem; margin-bottom:0; letter-spacing:0.5px;">
                        Acesse sua conta</h2>
                </div>
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-3">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}" autocomplete="off" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email">E-mail</label>
                        <div class="input-group input-group-flat">
                            <input id="email" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="seu@email.com"
                                value="{{ old('email') }}" required autofocus autocomplete="username">
                        </div>
                        @if ($errors->has('email'))
                            <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    
                    <!-- Company Display Section -->
                    <div id="company-info" class="company-info-container mb-3" style="display: none;">
                        <div class="company-card">
                            <div class="company-header">
                                <div class="company-avatar">
                                    <img id="company-logo" src="" alt="Logo" class="company-logo" style="display: none;">
                                    <div id="company-initial" class="company-initial"></div>
                                </div>
                                <div class="company-details">
                                    <h4 id="company-name" class="company-name"></h4>
                                    <p id="company-cnpj" class="company-cnpj"></p>
                                </div>
                                <div class="company-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="9,11 12,14 22,4"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="user-greeting">
                                <span>Olá, <strong id="user-name"></strong>! 👋</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="password">
                            Senha
                            {{-- <span class="form-label-description">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Esqueci minha senha</a>
                                @endif
                            </span> --}}
                        </label>
                        <div class="input-group input-group-flat">
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Sua senha"
                                required autocomplete="off">
                        </div>
                        @if ($errors->has('password'))
                            <div class="text-danger small mt-1">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    {{-- <div class="mb-2">
                        <label class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="form-check-label">Lembrar de mim neste dispositivo</span>
                        </label>
                    </div> --}}
                    <div class="form-footer">
                        <button id="login-btn" type="submit" class="btn btn-primary w-100" disabled style="display:none">
                            <span class="spinner-border spinner-border-sm align-middle me-2" role="status"
                                aria-hidden="true"></span>
                            Carregando...
                        </button>
                        <button id="submit-btn" type="submit" class="btn btn-primary w-100">Entrar</button>
                    </div>
                </form>
                {{-- <div class="text-center text-secondary mt-3">Ainda não tem conta? <a href="{{ route('register') }}"
                        tabindex="-1">Cadastre-se</a></div> --}}
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <!-- Photo -->
            <div class="bg-cover h-100 min-vh-100 position-relative" style="background-image: url('{{ asset('tabler/img/login.jpg') }}')">
                <div style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.45);"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('login') }}"]');
            const submitBtn = document.getElementById('submit-btn');
            const loadingBtn = document.getElementById('login-btn');
            const emailInput = document.getElementById('email');
            const companyInfo = document.getElementById('company-info');
            const companyName = document.getElementById('company-name');
            const companyCnpj = document.getElementById('company-cnpj');
            const companyLogo = document.getElementById('company-logo');
            const companyInitial = document.getElementById('company-initial');
            const userName = document.getElementById('user-name');
            
            let searchTimeout;
            let lastSearchedEmail = '';

            // Function to show company info
            function showCompanyInfo(data) {
                const company = data.company;
                const user = data.user;
                
                // Set company name
                companyName.textContent = company.nome;
                
                // Set CNPJ
                companyCnpj.textContent = company.cnpj ? `CNPJ: ${company.cnpj}` : '';
                
                // Set user name
                userName.textContent = user.name;
                
                // Handle logo or initial
                if (company.logo) {
                    companyLogo.src = company.logo;
                    companyLogo.style.display = 'block';
                    companyInitial.style.display = 'none';
                } else {
                    companyLogo.style.display = 'none';
                    companyInitial.style.display = 'flex';
                    companyInitial.textContent = company.nome.charAt(0);
                }
                
                // Show with animation
                companyInfo.style.display = 'block';
                setTimeout(() => {
                    companyInfo.classList.add('show');
                }, 10);
            }

            // Function to hide company info
            function hideCompanyInfo() {
                companyInfo.classList.remove('show');
                setTimeout(() => {
                    companyInfo.style.display = 'none';
                }, 300);
            }

            // Function to search for user company
            async function searchUserCompany(email) {
                if (!email || !isValidEmail(email) || email === lastSearchedEmail) {
                    return;
                }

                lastSearchedEmail = email;
                emailInput.classList.add('loading');

                try {
                    const response = await fetch('{{ route("auth.get-user-company") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: email })
                    });

                    const data = await response.json();

                    if (data.found) {
                        showCompanyInfo(data);
                    } else {
                        hideCompanyInfo();
                    }
                } catch (error) {
                    console.error('Erro ao buscar empresa:', error);
                    hideCompanyInfo();
                } finally {
                    emailInput.classList.remove('loading');
                }
            }

            // Email validation helper
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Email input event listener
            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    const email = this.value.trim();
                    
                    // Clear previous timeout
                    if (searchTimeout) {
                        clearTimeout(searchTimeout);
                    }

                    // Hide company info if email is being modified
                    if (email !== lastSearchedEmail) {
                        hideCompanyInfo();
                    }

                    // Search after user stops typing (500ms delay)
                    if (email) {
                        searchTimeout = setTimeout(() => {
                            searchUserCompany(email);
                        }, 500);
                    } else {
                        lastSearchedEmail = '';
                        hideCompanyInfo();
                    }
                });

                // Also search on blur (when user leaves the field)
                emailInput.addEventListener('blur', function() {
                    const email = this.value.trim();
                    if (email && email !== lastSearchedEmail) {
                        searchUserCompany(email);
                    }
                });
            }

            // Form submission handling
            if (form && submitBtn && loadingBtn) {
                form.addEventListener('submit', function(e) {
                    submitBtn.disabled = true;
                    submitBtn.style.display = 'none';
                    loadingBtn.style.display = '';
                    loadingBtn.disabled = true;
                });

                // Ensure submit on Enter key in any field
                form.querySelectorAll('input').forEach(function(input) {
                    input.addEventListener('keydown', function(ev) {
                        if (ev.key === 'Enter') {
                            form.requestSubmit();
                        }
                    });
                });
            }
        });
    </script>
@endpush
