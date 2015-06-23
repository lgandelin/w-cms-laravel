var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

var public_path = 'src/public/back';

gulp.task('sass', function () {
    gulp.src([
            'src/resources/assets/sass/*.scss'
        ])
        .pipe(sass())
        .pipe(concat('style.css'))
        .pipe(gulp.dest(public_path + '/css'));
});

gulp.task('sass_watch', function() {
    gulp.watch([
            'src/resources/assets/sass/*.scss'
        ],
        ['sass']
    );
});