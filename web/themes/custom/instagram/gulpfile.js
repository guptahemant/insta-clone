import gulp from 'gulp' ;    
import gulpSass from 'gulp-sass';
import nodeSass from 'node-sass' ; 
const sass = gulpSass(nodeSass);

gulp.task('sass',async function() {
    return gulp.src('scss/*')
        .pipe(gulpSass().on('error', gulpSass.logError))
        .pipe(gulp.dest('css/'));
});


gulp.task('default', gulp.series('sass')); 

gulp.task('watch', function(){ 
   gulp.watch('sass/*',gulp.series('sass'));
});