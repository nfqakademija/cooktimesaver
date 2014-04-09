var gulp = require('gulp');

var bower = require('gulp-bower');
var sass = require('gulp-sass');
var watch = require('gulp-watch');

//var paths = {
//   scripts: ['client/js/**/*.coffee', '!client/external/**/*.coffee'],
//   images: 'client/img/**/*'
//};

// gulp.task('scripts', function() {
//   // Minify and copy all JavaScript (except vendor scripts)
//   return gulp.src(paths.scripts)
//     .pipe(coffee())
//     .pipe(uglify())
//     .pipe(concat('all.min.js'))
//     .pipe(gulp.dest('build/js'));
// });

// // Copy all static images
// gulp.task('images', function() {
//  return gulp.src(paths.images)
//     // Pass in options to the task
//     .pipe(imagemin({optimizationLevel: 5}))
//     .pipe(gulp.dest('build/img'));
// });


gulp.task('watch', function () {
    gulp.src('app/Resources/styles/*')
        .pipe(watch(function() {
            return gulp.src('app/Resources/styles/main.scss')
                .pipe(sass())
                .pipe(gulp.dest('web/assets/css/'));
        }));
});
// Copy all static images
gulp.task('bootstrap', function() {
    // Pass in options to the task
    bower()
        .pipe(gulp.dest('app/Resources/lib/'));
});

gulp.task('sass', function () {
    gulp.src('app/Resources/styles/main.scss')
        .pipe(sass())
        .pipe(gulp.dest('web/assets/css/'));
});



// // The default task (called when you run `gulp` from cli)
gulp.task('default', ['bootstrap', 'sass']);
