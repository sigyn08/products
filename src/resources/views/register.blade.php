@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="register-container">
    <h2>商品登録</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">商品名 <span class="required">必須</span></label>
        <input type="text" id="name" name="name" placeholder="商品名を入力" required>

        <label for="price">値段 <span class="required">必須</span></label>
        <input type="number" id="price" name="price" placeholder="値段を入力" required>

        <label for="image">商品画像 <span class="required">必須</span></label>
        <input type="file" id="image" name="image" required>

        <label>季節 <span class="required">必須</span><span class="note">複数選択可</span></label>
        <div class="season-options">
            @foreach ($seasons as $season)
            <label>
                <input type="checkbox" name="seasons[]" value="{{ $season->id }}">
                {{ $season->name }}
            </label>
            @endforeach
        </div>


        <label for="description">商品説明 <span class="required">必須</span></label>
        <textarea id="description" name="description" placeholder="商品の説明を入力" required></textarea>

        <div class="btn-group">
            <button type="button" onclick="history.back()" class="btn back-btn">戻る</button>
            <button type="submit" class="btn submit-btn">登録</button>
        </div>
    </form>
</div>
@endsection