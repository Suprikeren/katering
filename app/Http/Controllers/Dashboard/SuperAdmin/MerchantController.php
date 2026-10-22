<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class MerchantController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(
                PermissionMiddleware::using('merchants index'),
                only: ['index']
            ),
        ];
    }

    public function index(Request $request)
    {
        $merchants = Merchant::with('user')
            ->search($request->search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'dashboard.super-admin.merchants.index',
            compact('merchants')
        );
    }
}
