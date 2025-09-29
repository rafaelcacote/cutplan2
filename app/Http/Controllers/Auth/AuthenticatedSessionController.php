<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Get user company information for display during login
     */
    public function getUserCompany(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::with('tenant')->where('email', $request->email)->first();

        if (!$user || !$user->tenant) {
            return response()->json([
                'found' => false,
                'message' => 'Usuário não encontrado ou sem empresa vinculada'
            ], 404);
        }

        return response()->json([
            'found' => true,
            'company' => [
                'id' => $user->tenant->id,
                'nome' => $user->tenant->nome,
                'cnpj' => $user->tenant->formatted_cnpj,
                'logo' => $user->tenant->logo ? asset('storage/' . $user->tenant->logo) : null,
            ],
            'user' => [
                'name' => $user->name
            ]
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

    return redirect()->route('login');
    }
}
