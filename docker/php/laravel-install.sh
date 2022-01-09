echo "<-- start install laravel -->"
composer create-project --prefer-dist laravel/laravel . "8.*" --prefer-dist
echo "<-- finish install laravel -->"
php artisan -V

# Laravelのデバッガーツール
echo "<-- start install debugbar -->"
composer require barryvdh/laravel-debugbar
echo "<-- finish install debugbar -->"

# Laravel UIツール
echo "<-- start install Laravel Breeze -->"
composer require laravel/breeze "1.*" --dev
php artisan breeze:install
echo "<-- finish install Laravel Breeze -->"

echo "<-- start install npm -->"
npm install
echo "<-- finish install npm -->"

echo "<-- start npm compile -->"
npm run dev
echo "<-- finish npm compile -->"
