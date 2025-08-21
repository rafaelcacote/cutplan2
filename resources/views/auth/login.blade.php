@extends('layouts.guest')

@section('content')
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
            <div class="container container-tight my-5 px-lg-5">
                <div class="text-center mb-4">
                    <!-- BEGIN NAVBAR LOGO -->
                    <a href="/" aria-label="Tabler" class="navbar-brand navbar-brand-autodark">
                        <!-- SVG LOGO -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="110" height="32" viewBox="0 0 232 68"
                            class="navbar-brand-image">
                            <path
                                d="M64.6 16.2C63 9.9 58.1 5 51.8 3.4 40 1.5 28 1.5 16.2 3.4 9.9 5 5 9.9 3.4 16.2 1.5 28 1.5 40 3.4 51.8 5 58.1 9.9 63 16.2 64.6c11.8 1.9 23.8 1.9 35.6 0C58.1 63 63 58.1 64.6 51.8c1.9-11.8 1.9-23.8 0-35.6zM33.3 36.3c-2.8 4.4-6.6 8.2-11.1 11-1.5.9-3.3.9-4.8.1s-2.4-2.3-2.5-4c0-1.7.9-3.3 2.4-4.1 2.3-1.4 4.4-3.2 6.1-5.3-1.8-2.1-3.8-3.8-6.1-5.3-2.3-1.3-3-4.2-1.7-6.4s4.3-2.9 6.5-1.6c4.5 2.8 8.2 6.5 11.1 10.9 1 1.4 1 3.3.1 4.7zM49.2 46H37.8c-2.1 0-3.8-1-3.8-3s1.7-3 3.8-3h11.4c2.1 0 3.8 1 3.8 3s-1.7 3-3.8 3z"
                                fill="#066fd1" style="fill: var(--tblr-primary, #066fd1)"></path>
                            <path
                                d="M105.8 46.1c.4 0 .9.2 1.2.6s.6 1 .6 1.7c0 .9-.5 1.6-1.4 2.2s-2 .9-3.2.9c-2 0-3.7-.4-5-1.3s-2-2.6-2-5.4V31.6h-2.2c-.8 0-1.4-.3-1.9-.8s-.9-1.1-.9-1.9c0-.7.3-1.4.8-1.8s1.2-.7 1.9-.7h2.2v-3.1c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v3.1h3.4c.8 0 1.4.3 1.9.8s.8 1.2.8 1.9-.3 1.4-.8 1.8-1.2.7-1.9.7h-3.4v13c0 .7.2 1.2.5 1.5s.8.5 1.4.5c.3 0 .6-.1 1.1-.2.5-.2.8-.3 1.2-.3zm28-20.7c.8 0 1.5.3 2.1.8.5.5.8 1.2.8 2.1v20.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2-.8-.8-1.2-.8-2.1c-.8.9-1.9 1.7-3.2 2.4-1.3.7-2.8 1-4.3 1-2.2 0-4.2-.6-6-1.7-1.8-1.1-3.2-2.7-4.2-4.7s-1.6-4.3-1.6-6.9c0-2.6.5-4.9 1.5-6.9s2.4-3.6 4.2-4.8c1.8-1.1 3.7-1.7 5.9-1.7 1.5 0 3 .3 4.3.8 1.3.6 2.5 1.3 3.4 2.1 0-.8.3-1.5.8-2.1.5-.5 1.2-.7 2-.7zm-9.7 21.3c2.1 0 3.8-.8 5.1-2.3s2-3.4 2-5.7-.7-4.2-2-5.8c-1.3-1.5-3-2.3-5.1-2.3-2 0-3.7.8-5 2.3-1.3 1.5-2 3.5-2 5.8s.6 4.2 1.9 5.7 3 2.3 5.1 2.3zm32.1-21.3c2.2 0 4.2.6 6 1.7 1.8 1.1 3.2 2.7 4.2 4.7s1.6 4.3 1.6 6.9-.5 4.9-1.5 6.9-2.4 3.6-4.2 4.8c-1.8 1.1-3.7 1.7-5.9 1.7-1.5 0-3-.3-4.3-.9s-2.5-1.4-3.4-2.3v.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.5-.8-1.2-.8-2.1V18.9c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v10c.8-1 1.8-1.8 3.2-2.5 1.3-.7 2.8-1 4.3-1zm-.7 21.3c2 0 3.7-.8 5-2.3s2-3.5 2-5.8-.6-4.2-1.9-5.7-3-2.3-5.1-2.3-3.8.8-5.1 2.3-2 3.4-2 5.7.7 4.2 2 5.8c1.3 1.6 3 2.3 5.1 2.3zm23.6 1.9c0 .8-.3 1.5-.8 2.1s-1.3.8-2.1.8-1.5-.3-2-.8-.8-1.3-.8-2.1V18.9c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v29.7zm29.3-10.5c0 .8-.3 1.4-.9 1.9-.6.5-1.2.7-2 .7h-15.8c.4 1.9 1.3 3.4 2.6 4.4 1.4 1.1 2.9 1.6 4.7 1.6 1.3 0 2.3-.1 3.1-.4.7-.2 1.3-.5 1.8-.8.4-.3.7-.5.9-.6.6-.3 1.1-.4 1.6-.4.7 0 1.2.2 1.7.7s.7 1 .7 1.7c0 .9-.4 1.6-1.3 2.4-.9.7-2.1 1.4-3.6 1.9s-3 .8-4.6.8c-2.7 0-5-.6-7-1.7s-3.5-2.7-4.6-4.6-1.6-4.2-1.6-6.6c0-2.8.6-5.2 1.7-7.2s2.7-3.7 4.6-4.8 3.9-1.7 6-1.7 4.1.6 6 1.7 3.4 2.7 4.5 4.7c.9 1.9 1.5 4.1 1.5 6.3zm-12.2-7.5c-3.7 0-5.9 1.7-6.6 5.2h12.6v-.3c-.1-1.3-.8-2.5-2-3.5s-2.5-1.4-4-1.4zm30.3-5.2c1 0 1.8.3 2.4.8.7.5 1 1.2 1 1.9 0 1-.3 1.7-.8 2.2-.5.5-1.1.8-1.8.7-.5 0-1-.1-1.6-.3-.2-.1-.4-.1-.6-.2-.4-.1-.7-.1-1.1-.1-.8 0-1.6.3-2.4.8s-1.4 1.3-1.9 2.3-.7 2.3-.7 3.7v11.4c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.6-.8-1.3-.8-2.1V28.8c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v.6c.7-1.3 1.8-2.3 3.2-3 1.3-.7 2.8-1 4.3-1z"
                                fill-rule="evenodd" clip-rule="evenodd" fill="#4a4a4a"></path>
                        </svg>
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
                                required autocomplete="current-password">
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
            <div class="bg-cover h-100 min-vh-100" style="background-image: url('{{ asset('tabler/img/login.jpg') }}')">
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
            if (form && submitBtn && loadingBtn) {
                form.addEventListener('submit', function(e) {
                    submitBtn.disabled = true;
                    submitBtn.style.display = 'none';
                    loadingBtn.style.display = '';
                    loadingBtn.disabled = true;
                });
                // Garante submit ao pressionar Enter em qualquer campo
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
