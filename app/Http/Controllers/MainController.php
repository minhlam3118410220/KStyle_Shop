<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;
use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;

class MainController extends Controller
{

    protected $slider;
    protected $menu;
    protected $product;
    protected $cartService;

    public function __construct(SliderService $slider ,MenuService $menu ,ProductService $product,CartService $cartService)
    {
        $this->slider=$slider;
        $this->menu= $menu;
        $this->product= $product;
        $this->cartService = $cartService;
    }


    public function index()
    {
        return view('home',[
            'title' => 'KStyle Shop',
            'sliders' => $this->slider->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->get()
        ]);
    }

    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->product->get($page);
        if (count($result) != 0) {
            $html = view('products.list', ['products' => $result ])->render();

            return response()->json([ 'html' => $html ]);
        }

        return response()->json(['html' => '' ]);
    }

    public function showContact()
    {
        $products = $this->cartService->getProduct();
        return view('contact',[
            'title' => 'KStyle Shop',
            'products' => $products
        ]);
    }

    

    public function showAbout()
    {
        $products = $this->cartService->getProduct();
        return view('about',[
            'title' => 'KStyle Shop',
            'products' => $products
        ]);
    }
}
