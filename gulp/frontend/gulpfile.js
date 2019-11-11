var gulp         = require('gulp'),
	pug            = require('gulp-pug'),
	stylus         = require('gulp-stylus'),
	autoprefixer   = require('gulp-autoprefixer'),
	minifyCSS      = require('gulp-clean-css'),
	watch          = require('gulp-watch'),
	bundle         = require('gulp-bundle-assets'),
	webserver      = require('gulp-webserver'),
  SelfReloadJSON = require('self-reload-json'),
  gcallback      = require('gulp-callback'),
  rimraf         = require('gulp-rimraf'),
  gutil          = require('gulp-util');


gulp.task('css', function() {
  gulp.src('dev/styl/*.styl')
      .pipe(stylus({compress: true, paths: ['dev/styl']}))
      .pipe(autoprefixer())
      .pipe(minifyCSS())
      .pipe(gulp.dest('dev/css'));
});


gulp.task('bundle', function() {
  gulp.src('./bundle.config.js')
        .pipe(bundle())
        .pipe(gulp.dest('./public/assets'));
});

gulp.task('html', function() {
  gulp.src('dev/pug/*.pug')
    .pipe(pug({pretty:true}))
    .pipe(gulp.dest('public'));
});

gulp.task('webserver', function() {
	// gulp.src('./public')
	// 	.pipe(webserver({
	// 		// livereload: true,
  //     open: true,
	// 		directoryListing: false
	// 	}));
});

gulp.task('clean', function() {
  return gulp.src('./public/assets', { read: false })
    .pipe(rimraf());
});

gulp.task('watch', function () {
  gulp.watch(['bundle.config.js'], ['bundle']);
  gulp.watch(['dev/styl/*.styl', 'dev/styl/*/*.styl'], ['css']);
  gulp.watch(['dev/css/*.css'], ['bundle']);
  gulp.watch(['dev/js/*.js', 'dev/js/*/*.js'], ['bundle']);
  gulp.watch(['dev/*/*.jpg', 'dev/*/*.png',], ['bundle']);
  gulp.watch(['dev/*/*.eot', 'dev/*/*.svg', 'dev/*/*.ttf', 'dev/*/*.woff', 'dev/*/*.woff2', 'dev/*/*.otf'], ['bundle']);
  gulp.watch(['dev/pug/*.pug', 'dev/pug/*/*.pug'], ['html']);
});

gulp.task('default', ['css', 'html', 'bundle', 'webserver', 'watch']);
