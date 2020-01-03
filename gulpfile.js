var gulp = require('gulp');
var path = require('path');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var open = require('gulp-open');
var browsersync = require("browser-sync").create();

// BrowserSync
function browserSync(done) {
  browsersync.init({
    server: {
      baseDir: "./"
    },
    port: 3000
  });
  done();
}

// BrowserSync reload
function browserSyncReload(done) {
  browsersync.reload();
  done();
}

gulp.task('compile-scss', function() {
  return gulp.src('./assets/scss/**/**')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./assets/css/'));
});

gulp.task('watch-files', function() {
  gulp.watch('./assets/scss/**/**', gulp.series('compile-scss'));
  gulp.watch("./**/*.html", browserSyncReload);
});

gulp.task('watch', gulp.parallel('watch-files', browserSync));
