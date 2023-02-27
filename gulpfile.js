const { src, dest, watch , series, parallel } = require('gulp');

//CSS
const sass          = require('gulp-sass')(require('sass'));
const autoprefixer  = require('autoprefixer');
const cssnano       = require('cssnano');
const postcss       = require('gulp-postcss')
const sourcemaps    = require('gulp-sourcemaps')

// Imagenes
const cache         = require('gulp-cache');
const imagemin      = require('gulp-imagemin');
const webp          = require('gulp-webp');

//Javascript
const terser        = require('gulp-terser-js');
const concat        = require('gulp-concat');
const rename        = require('gulp-rename');

// Notificaciòn
const notify        = require('gulp-notify');

// 
const clean         = require('gulp-clean');


const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    imagenes: 'src/img/**/*'
}

// css es una función que se puede llamar automaticamente
function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        // .pipe(postcss([autoprefixer()]))
        .pipe(sourcemaps.write('.'))
        .pipe( dest('public/build/css') );
}


function javascript() {
    return src(paths.js)
      .pipe(terser())
      .pipe(sourcemaps.write('.'))
      .pipe(dest('public/build/js'));
}

function imagenes() {
    return src(paths.imagenes)
        .pipe(cache(imagemin({ optimizationLevel: 3})))
        .pipe(dest('public/build/img'))
        .pipe(notify({ message: 'Imagen Completada'}));
}

function versionWebp() {
    return src(paths.imagenes)
        .pipe( webp() )
        .pipe(dest('public/build/img'))
        .pipe(notify({ message: 'Imagen Completada'}));
}

function imgmin() {
    return src(paths.imagenes)
        .pipe(changed(imgDest))
        .pipe(imagemin([
            imagemin.gifsicle({
                interlaced: true
            }),
            imagemin.mozjpeg({
                progressive: true
            }),
            imagemin.optipng({
                optimizationLevel: 5
            })
        ]))
        .pipe(gulp.dest(imgDest));
}



function watchArchivos() {
    watch( paths.scss, css );
    watch( paths.js, javascript );
    watch( paths.imagenes, imagenes );
    watch( paths.imagenes, versionWebp );
}
  
exports.css = css;
exports.watchArchivos = watchArchivos;
exports.default = parallel(css, javascript,  imagenes, versionWebp,  watchArchivos ); 