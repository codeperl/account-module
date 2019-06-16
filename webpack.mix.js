const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/account.js')
    .js(__dirname + '/Resources/assets/js/account/resources.js', 'js/resources.js')
    .js(__dirname + '/Resources/assets/js/account/roles.js', 'js/roles.js')
    .js(__dirname + '/Resources/assets/js/account/permissions.js', 'js/permissions.js')
    .js(__dirname + '/Resources/assets/js/account/assignroletouser.js', 'js/assignroletouser.js')
    .js(__dirname + '/Resources/assets/js/account/assignresourcetopermission.js', 'js/assignresourcetopermission.js')
    .js(__dirname + '/Resources/assets/js/account/assignpermissiontouser.js', 'js/assignpermissiontouser.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/account.css');

if (mix.inProduction()) {
    mix.version();
}