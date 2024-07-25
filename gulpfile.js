'use strict';

const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const gcmq = require('gulp-group-css-media-queries');
const babel = require('gulp-babel');
const cssnano = require('gulp-cssnano');
const uglify = require('gulp-uglify');
const cleanDir = require('gulp-clean-dir');
var clean = require('gulp-clean');

// Prod
gulp.task('buildCss', () => {
  return gulp.src('./src/scss/*.scss')
  .pipe(sass().on('error', sass.logError))
  .pipe(gcmq())
  .pipe(autoprefixer())
  .pipe(cssnano())
  .pipe(gulp.dest('./app/public/css'));
});

gulp.task('buildJs', () => {
  return gulp.src('./src/js/main.js')
  .pipe(babel({
    presets: ['@babel/env']
  }))
  .pipe(uglify())
  .pipe(gulp.dest('./app/public/js'));
});

gulp.task('copyImages', () => {
    return gulp.src('./src/images/*')
    .pipe(gulp.dest('./app/public/images'));
});

gulp.task('clean', () => {
  return gulp.src('./app/public', {read: false, allowEmpty: true})
      .pipe(clean());
});

// Dev
gulp.task('processCss', () => {
  return gulp.src('./src/scss/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./app/public/css'));
});

gulp.task('processJs', () => {
  return gulp.src('./src/js/main.js')
  .pipe(gulp.dest('./app/public/js'));
});

gulp.task('watch', () => {
  gulp.watch('src/scss/**/*.scss', gulp.series(['processCss']));
  gulp.watch('src/js/**/*.js', gulp.series(['processJs']));
  gulp.watch('src/images/*', gulp.series(['copyImages']));
});

gulp.task('build', gulp.series('clean', gulp.parallel('buildCss', 'buildJs', 'copyImages')));