var gulp         = require('gulp'),
	sass         = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	browserSync  = require('browser-sync').create(),
	cleanCSS	 = require('gulp-clean-css'),
	notify 		 = require("gulp-notify"),
	plumber 	 = require('gulp-plumber'),
	sourcemaps 	 = require('gulp-sourcemaps'),
	uglify 		 = require('gulp-uglify');


// Static Server + watching scss/html files

gulp.task('serve', ['sass' , 'scripts'], function() {
	browserSync.init({
		// server: {
		//     baseDir: "./"
		// }
		
		proxy: {
			target: "http://localhost:8888", // can be [virtual host, sub-directory, localhost with port]
			ws: true // enables websockets
		}
	});
});


// JS

gulp.task('scripts', function(){
	gulp.src('./assets/js/*.js')
		.pipe(plumber())
		//.pipe(uglify())
		.pipe(gulp.dest('./js'))
		.pipe(browserSync.stream());
});


// Styles

gulp.task('sass', function() {
	return gulp
		.src("./assets/sass/**/*.scss")
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass())
		.on('error', onError)
		.pipe(cleanCSS())
		.pipe(autoprefixer({
			browsers: ['last 2 versions', 'ie 8', 'ie 9'],
			cascade: false
		}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest("./css"))
		.pipe(browserSync.stream({match: '**/*.css' }));
});


// Error notification

var onError = function (err) {
	notify({
		title: 'Sass Errorr',
		subtitle: '<%= error.relativePath %>:<%= error.line %>',
		message: '<%= error.messageOriginal %>',
		open: 'file://<%= error.file %>',
		icon: 'http://i.imgur.com/PURVsoA.png',
	}).write(err);

	console.log(err.toString());
     
	this.emit('end');
}


// Watch 

gulp.task('watch', function() {
	gulp.watch('assets/js/*.js', ['scripts']);
	gulp.watch("assets/sass/**/*.scss", ['sass']);
	//gulp.watch("*.php").on('change', browserSync.reload);
});


gulp.task('default', ['scripts', 'sass', 'serve', 'watch']);