const mix = require('laravel-mix');

// Compilează fișierul JavaScript
mix.js('resources/js/app.js', 'public/js')

// Compilează fișierul CSS
   .sass('resources/sass/app.scss', 'public/css')

// Generează un fișier manifest pentru cache-busting
   .version(); // Opțional: Folosește .version() pentru a genera fișiere cu hash pentru cache-busting
