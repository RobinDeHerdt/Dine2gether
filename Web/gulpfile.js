var gulp = require("gulp");
var concat = require("gulp-concat");
var uglify = require("gulp-uglify");
var batch = require("gulp-batch");
var plumber = require("gulp-plumber");
var ngAnnotate = require("gulp-ng-annotate");
var sourcemaps = require("gulp-sourcemaps");
var cssnano = require("gulp-cssnano");


// --------------------------------------------------------------- //
// This task bundles your application scripts into dist/scripts.js //
// --------------------------------------------------------------- //
gulp.task("js", function() {

  	gulp.src(["app/app.js", "app/config.js", "app/routes.js", "app/controllers/*.js", "app/services/*.js", "app/directives/*/*.js"])
	  	.pipe(plumber({
	        handleError: function (err) {
	            console.log(err);
	            this.emit('end');
	        }
	    }))
	    .pipe(sourcemaps.init())
		    .pipe(ngAnnotate())
		    .pipe(concat("scripts.js"))
		    .pipe(uglify())
		.pipe(sourcemaps.write())
	    .pipe(gulp.dest("dist"))

  	// 	gulp.src(["assets/js/*"])
  	//   	.pipe(plumber({
  	//     		handleError: function (err) {
    //         		console.log(err);
    //         		this.emit('end');
    //     		}
    // 		}))
  	//   	.pipe(sourcemaps.init())
  	//   	.pipe(concat("vendor.js"))
	// 		.pipe(uglify())
	// 	.pipe(sourcemaps.write())
	// 	.pipe(gulp.dest("dist"))
});


// ------------------------------------------------------------- //
// This task bundles your application styles into dist/styles.js //
// ------------------------------------------------------------- //
gulp.task("css", function() {

	gulp.src(["assets/css/*.css"])
		.pipe(sourcemaps.init())
			.pipe(concat("styles.css"))
			.pipe(cssnano())
		.pipe(sourcemaps.write())
		.pipe(gulp.dest("dist"))
});


// ----------------------------------------- //
// This task bundles your scripts and styles //
// ----------------------------------------- //
gulp.task("build", function() {

	gulp.start("css");
	gulp.start("js");
});


// ----------------------------------------------------------------------------------------- //
// This task watches your scripts and styles and automatically builds when changes are saved //
// ----------------------------------------------------------------------------------------- //
gulp.task("watch", function() {

  	gulp.watch(["app/config.js", "app/app.js", "app/routes.js", "app/controllers/*.js", "app/services/*.js", "app/directives/*/*.js"], batch(function(events, done) {
  		gulp.start("js", done);
	}));

	gulp.watch(["assets/css/*.css"], batch(function(events, done) {
		gulp.start("css", done);
	}));
});


// ------------------------------------------------------------ //
// This task bundles your scripts and styles and start watching //
// ------------------------------------------------------------ //
gulp.task("init", function() {
	
	gulp.start("css");
	gulp.start("js");
	gulp.start("watch");	
});