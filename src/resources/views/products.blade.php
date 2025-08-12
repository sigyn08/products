@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="product-edit-container">
    {{-- パンくず --}}
    <div class="breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a> &gt; {{ $product->name }}
    </div>

    {{-- 画像 & フォーム --}}
    <div class="product-edit-layout">
        <div class="product-image">
            @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @endif
            <input type="file" name="image" id="image" class="file-input" accept=".png,.jpeg">
            <label for="image" class="file-label">{{ $product->image ?? '画像を選択してください' }}</label>
            @error('image')
            <p class="error-message" style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="product-form">
            @csrf
            @method('PUT')

            {{-- 商品名 --}}
            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}">
                @error('name')
                <p class="error-message" style="color:red;">{{ $message }}</p>
                @enderror
            </div>

            {{-- 値段 --}}
            <div class="form-group">
                <label for="price">値段</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}">
                @error('price')
                <p class="error-message" style="color:red;">{{ $message }}</p>
                @enderror
            </div>

            {{-- 季節（複数選択対応） --}}
            <div class="form-group">
                <label>季節</label>
                @php
                $selectedSeasons = old('seasons', $product->seasons->pluck('id')->toArray());
                @endphp

                @if(!isset($seasons) || $seasons->isEmpty())
                <div class="no-season">季節データがありません。</div>
                @else
                @foreach($seasons as $season)
                <label class="season-label">
                    <input type="checkbox" name="season[]" value="{{ $season->id }}"
                        {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}>
                    <span class="season-circle {{ in_array($season->id, $selectedSeasons) ? 'active' : '' }}"></span>
                    <span class="season-name">{{ $season->name }}</span>
                </label>
                @endforeach
                @endif
            </div>
            @error('seasons')
            <p class="error-message" style="color:red;">{{ $message }}</p>
            @enderror
    </div>


    {{-- 商品説明 --}}
    <div class="form-group">
        <label for="description">商品説明</label>
        <textarea name="description" id="description">{{ old('description', $product->description) }}</textarea>
        @error('description')
        <p class="error-message" style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    {{-- ボタン --}}
    <div class="form-buttons">
        <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
        <button type="submit" class="btn-save">変更を保存</button>
    </div>
    </form>

    {{-- 削除フォームは別に分けて配置 --}}
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" onsubmit="return confirm('本当に削除しますか？')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete">削除</button>
    </form>
</div>
</div>
@endsection