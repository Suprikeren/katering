<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $merchant = Merchant::take(3)->get();

        return view('customer.home', compact('merchant'));
    }

    public function caterings(Request $request)
    {
        $merchant = Merchant::query()
            ->search($request->search)
            ->filterLocation($request->location)
            ->latest()
            ->paginate(9);

        $locations = Merchant::query()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        return view('customer.caterings', compact('merchant', 'locations'));
    }

    public function detailCatering($id)
    {
        $merchant = Merchant::with('menus')->findOrFail($id);
        $menus = $merchant->menus()->paginate(9);

        return view('customer.detail-catering', compact('merchant','menus'));
    }

    // public function cart()
    // {
    //     return view('customer.cart');
    // }
}
