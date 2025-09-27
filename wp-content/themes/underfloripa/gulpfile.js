const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const gulpIf = require('gulp-if');

const isProd = process.env.NODE_ENV === 'production';

const paths = {
  scss: 'sass/**/*.scss',
  main: 'sass/main.scss',
  css: 'css'
};

function build() {
  return gulp.src(paths.main)
    .pipe(gulpIf(!isProd, sourcemaps.init()))
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer()]))
    .pipe(gulpIf(isProd, cleanCSS({ level: 2 })))
    .pipe(gulpIf(!isProd, sourcemaps.write('.')))
    .pipe(gulp.dest(paths.css));
}

function styles() {
  return gulp.src(paths.main)
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer()]))
    .pipe(cleanCSS({ level: 2 }))
    .pipe(gulp.dest(paths.css));
}

function watch() {
  gulp.watch(paths.scss, build);
}

exports.build = build;
exports.styles = styles;
exports.watch = watch;
exports.default = gulp.series(build, watch);
