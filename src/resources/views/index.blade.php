@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="product-container">
    <h1 class="product-title">商品一覧</h1>

    <div class="product-layout">
        {{-- 左サイドバー --}}
        <aside class="sidebar">
            {{-- 検索フォーム --}}
            <form method="GET" action="{{ route('products.index') }}">
                <input type="text" name="search" placeholder="商品名で検索" value="{{ request('search') }}"
                    class="search-input">
                <button type="submit" class="search-button">検索</button>
            </form>

            {{-- 並び替え --}}
            <form method="GET" action="{{ route('products.index') }}">
                <label class="sort-label">価格順で表示</label>
                <select name="sort" onchange="this.form.submit()" class="sort-select">
                    <option value="">価格で並べ替え</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>価格が安い順</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>価格が高い順</option>
                </select>
            </form>
        </aside>

        {{-- メインコンテンツ --}}
        <main class="main-content">
            <div class="add-button-wrapper">
                <a href="{{ route('products.create') }}" class="add-product-button">
                    + 商品を追加
                </a>
            </div>

            <div class="product-grid">
                @foreach ($products as $product)
                <div class="product-card-wrapper">
                    {{-- 詳細リンク --}}
                    <a href="{{ route('products.show', $product->id) }}" class="product-card-link">
                        <div class="product-card">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                            <div class="product-info">
                                <h2 class="product-name">{{ $product->name }}</h2>
                                <p class="product-price">¥{{ number_format($product->price) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </main>
    </div>
</div>
@endsection