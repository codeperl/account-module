const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/account.js')
    .js(__dirname + '/Resources/assets/js/generate-resources.js', 'js/generate-resources.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/account.css');

if (mix.inProduction()) {
    mix.version();
}