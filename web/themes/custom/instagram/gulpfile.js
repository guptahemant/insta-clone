var gulp = require('gulp');
var sass = require('gulp-sass');
const minify= require('gulp-minify');
var uglifycss = require('gulp-uglifycss');
gulp.task('sass', function() {
        return gulp.src('scss/*/*.scss')
            .pipe(sass())
            .pipe(gulp.dest('css/'));
    });
    gulp.task('css', async function () {
        gulp.src('css/*/*.css')
          .pipe(uglifycss({
            "maxLineLen": 80,
            "uglyComments": true
          }))
          .pipe(gulp.dest('./css/'));
      });
      gulp.task('compress', async function() {
        gulp.src(['js/instagram.js'])
          .pipe(minify())
          .pipe(gulp.dest('js'))
      });
      gulp.task('watch', function() {
            gulp.watch(['scss/all/*.scss'],gulp.series('sass'));
          });
