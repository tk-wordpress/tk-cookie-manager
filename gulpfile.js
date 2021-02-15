'use strict';

var gulp = require('gulp'),
	autoprefixer = require('gulp-autoprefixer'),
	rename = require('gulp-rename'),
	sass = require('gulp-sass'),
	sourcemaps = require('gulp-sourcemaps'),
	uglify = require('gulp-uglify');

// Task to compile SCSS files to CSS files
gulp.task('styles', function() {
	return gulp.src('public/css/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
		.pipe(autoprefixer())
		.pipe(sourcemaps.write('.', {includeContent: false}))
		.pipe(gulp.dest('public/css'));
});

// Task to compress javascript files
gulp.task('scripts', function() {
	return gulp.src('public/js/!(*.min)*.js')
		.pipe(sourcemaps.init())
		.pipe(uglify({output: {comments: '/^!/'}}))
		.pipe(rename({suffix: '.min'}))
		.pipe(sourcemaps.write('.', {includeContent: false}))
		.pipe(gulp.dest('public/js'));
});

gulp.task('watch', function() {
	gulp.watch('public/css/**/*.scss', gulp.series('styles'));
	gulp.watch('public/js/!(*.min)*.js', gulp.series('scripts'));
});

gulp.task('default', gulp.series('styles', 'scripts', 'watch'));
