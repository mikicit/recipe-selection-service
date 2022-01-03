'use strict';

const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const gcmq = require('gulp-group-css-media-queries');
const babel = require('gulp-babel');
const cssnano = require('gulp-cssnano');
const uglify = require('gulp-uglify');

// Prod
gulp.task('buildCss', () => {
  return gulp.src('./src/scss/main.scss')
  .pipe(sass().on('error', sass.logError))
  .pipe(gcmq())
  .pipe(autoprefixer())
  .pipe(cssnano())
  .pipe(gulp.dest('./public/css'));
});

gulp.task('buildJs', () => {
  return gulp.src('./src/js/main.js')
  .pipe(babel({
    presets: ['@babel/env']
  }))
  .pipe(uglify())
  .pipe(gulp.dest('./public/js'));
});


// Dev
gulp.task('processCss', () => {
  return gulp.src('./src/scss/main.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./public/css'));
});

gulp.task('processJs', () => {
  return gulp.src('./src/js/main.js')
  .pipe(gulp.dest('./public/js'));
});

gulp.task('watch', () => {
  gulp.watch('src/scss/**/*.scss', gulp.series(['processCss']));
  gulp.watch('src/js/**/*.js', gulp.series(['processJs']));
});

gulp.task('build', gulp.series('buildCss', 'buildJs'));