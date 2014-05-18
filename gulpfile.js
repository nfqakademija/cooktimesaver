var gulp = require('gulp');

var bower = require('gulp-bower');
var sass = require('gulp-sass');
var watch = require('gulp-watch');

gulp.task('bootstrap', function() {
    // Pass in options to the task
    bower()
        .pipe(gulp.dest('app/Resources/lib/'));
});


gulp.task('watch', function () {
    gulp.watch('app/Resources/styles/*', ['sass']);
});


gulp.task('sass', function () {
    gulp.src('app/Resources/styles/main.scss')
        .pipe(sass())
        .pipe(gulp.dest('web/assets/css/'));
});

gulp.task('default', ['watch']);