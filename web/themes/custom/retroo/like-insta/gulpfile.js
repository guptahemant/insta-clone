const gulp = require('gulp');
// const autoPrefixer = require('gulp-autoprefixer');
var sass = require('gulp-sass')(require('sass'));
// const imagemin = require('gulp-imagemin');

// Task 1 : Coverting SASS to CSS
gulp.task('sass', async function() {
   return gulp.src('main.scss')
   .pipe(sass())
   .pipe(gulp.dest('css'));
});

// Task 2 : Watch Task
gulp.task('watch', async function() {
   gulp.watch('./sass/*.scss', gulp.series('sass'));
})

// Task 3 : Feature - imagemin
// gulp.task('image', async function()
// {
//    return gulp.src('../images/*')
//    .pipe(imagemin())
//    .pipe(gulp.dest('../images/compressed/'))
// })

// // Task 4 : Feature - autofixer
// gulp.task('autofixer', () =>{
//    gulp.src('./css/main.css')
//    .pipe(autoPrefixer({
//        browsers:['last 99 versions'],
//        cascade:false
//    }))
//    .pipe(gulp.dest('./css/autofixer/'))
// })