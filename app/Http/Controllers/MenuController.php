<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuService;
    protected $product;
    protected $cartService;

    public function __construct(MenuService $menuService ,ProductService $product,CartService $cartService)
    {
        $this->menuService=$menuService;
        $this->product= $product;
        $this->cartService= $cartService;
    }

    public function index(Request $request, $id, $slug = '')
    {
        $menu = $this->menuService->getId($id);
        $products = $this->menuService->getProduct($menu, $request);

        return view('menu', [
            'title' => $menu->name,
            'products' => $products,
            'menu'  => $menu
        ]);
    }

    public function showShop()
    {
       
        return view('shop', [
            'title' => 'KStyle Shop',
            'products' => $this->product->getAll()
        ]);
    }

    
}
