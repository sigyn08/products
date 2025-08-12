<h1>確認テスト_もぎたて</h1>
<h2>環境構築</h2>
<h3>Dockerビルド</h3>
<div>1.git@github.com:sigyn08/products.git</div>
<div>2.docker-compose up -d build</div>
<h3>Laravel環境構築</h3>
<div>1.docker-compose exec php bash</div>
<div>2.conposer install</div>
<div>3..env.exampleファイルの作成・編集</div>
<div>4.php artisan key:generate</div>
<div>5.php artisan migrate</div>
<div>6.php artisan db:seed</div>
<h2>使用技術</h2>
<div>PHP:8.4.7</div>
<div>Laravel:8.83.8</div>
<div>mysql:8.0.26</div>
<h2>ER図</h2>
<img width="883" height="660" alt="スクリーンショット 2025-08-13 023311" src="https://github.com/user-attachments/assets/df93e838-fee9-4e54-947b-130c74d7a897" />
<h2>URL</h2>
<div>開発環境:http://localhost/products</div>
<div>phpMyAdmin:http://localhost:8080/</div>

