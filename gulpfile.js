'use strict';

const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');

gulp.task('processCss', () => {
  return gulp.src('./src/scss/main.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
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