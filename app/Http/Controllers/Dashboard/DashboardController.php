<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(
                PermissionMiddleware::using('dashboard index'),
                only: ['index']
            ),
        ];
    }

    /**
     * Menampilkan dashboard.
     */
    public function index()
    {
        return view('dashboard.index');
    }

    public function create()
    {
        //
    }

    public function store(\Illuminate\Http\Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
