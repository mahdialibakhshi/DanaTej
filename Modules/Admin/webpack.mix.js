const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/Modules/Admin/admin.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/Modules/Admin/admin.css');

if (mix.inProduction()) {
    mix.version();
}
mix.setPublicPath('../../public');
mix.copy( __dirname + '/Assets/css/Slider.css', '../../public/css/Modules/Admin/slider.css');
mix.copy( __dirname + '/Assets/js/Slider.js', '../../public/js/Modules/Admin/slider.js');
mix.copy( __dirname + '/Assets/ckeditor', '../../public/js/Modules/Admin/ckeditor');
mix.copy( __dirname + '/Assets/admin', '../../public/admin');

