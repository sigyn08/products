<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Seasons;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Products::query();

        // 検索処理（商品名）
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 並び替え（価格順）
        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        }

        // ページネーション（1ページに6件表示）
        $products = $query->paginate(6);

        return view('index', compact('products'));
    }

    public function create()
    {
        $seasons = Seasons::all();
        return view('register', compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'seasons' => 'array'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $dir = storage_path('app/public/products');
            if (!file_exists($dir)) {
                mkdir($dir, 0775, true);
                chmod($dir, 0775);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Products::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // チェック外しても保持する仕様
        if ($request->filled('seasons')) {
            $seasonIds = Seasons::whereIn('id', $request->seasons)->pluck('id')->toArray();
            $product->seasons()->syncWithoutDetaching($seasonIds);
        }
        return redirect()->route('products.index')->with('success', '商品を登録しました。');
    }

    public function show($id)
    {
        $product = Products::with('seasons')->findOrFail($id);

        // ここで $seasons にしておく（ビューで $seasons を使うなら）
        $seasons = Seasons::all();

        $selectedSeasonIds = $product->seasons->pluck('id')->toArray();

        return view('products', compact('product', 'seasons', 'selectedSeasonIds'));
    }


    public function edit($id)
    {
        $product = Products::with('seasons')->findOrFail($id);
        $seasons = Seasons::all();
        return view('products.edit', compact('product', 'seasons'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Products::findOrFail($id);

        if ($request->hasFile('image')) {
            $dir = storage_path('app/public/products');
            if (!file_exists($dir)) {
                mkdir($dir, 0775, true);
                chmod($dir, 0775);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        $product->seasons()->sync($request->input('seasons', []));

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->seasons()->detach();

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}
