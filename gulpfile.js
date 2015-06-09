var gulp  = require('gulp'),
    livereload = require('gulp-livereload'),
    compass = require('gulp-compass');


gulp.task('sass', function() {
   return gulp.src('web/sass/*.scss')
       .pipe(compass())
       .pipe(gulp.dest('web/css'))
       .pipe(livereload());
});

gulp.task('reload', function() {
    return gulp.src(['src/**'])
        .pipe(livereload());
});

gulp.task('watch', function() {
    livereload.listen();
    gulp.watch(['web/sass/*.scss', 'web/css/*.css'], ['sass']);
    gulp.watch(['src/**'], ['reload']);
});

gulp.task('default', ['sass', 'reload', 'watch']);