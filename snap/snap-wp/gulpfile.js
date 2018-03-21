//Build Plugins
var gulp = require('gulp');
var pipe = require('gulp-pipe');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var uglifyES = require('gulp-uglify-es').default;
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var stripStyleComments = require('gulp-strip-css-comments');
var stripComments = require('gulp-strip-comments');
var cssmin = require('gulp-cssmin');
var clean = require('gulp-clean');
var gutil  = require('gulp-util');
var fancyLog = require('fancy-log');

//Helper Functions
module.exports = function pipe(stream, tubes) {
    tubes = tubes || stream.slice(1);
    return tubes.reduce(function(stream, tube) { return stream.pipe(tube); }, Array.isArray(stream) ? stream[0] : stream);
};

var getDependentTasks = function (taskName) {
    var tasks = gulp.tasks;
    var deps = [];
    var task = null;
    for (task in tasks) {

        if (task.startsWith(taskName + ':')) {
            deps.push(task);
        }
    }
    return deps;
};

var throwError = function (taskName, msg) {
    throw new gutil.PluginError({
        plugin: taskName,
        message: msg
    });
};

//File Arrays
var paths = {
    js: {
        vendor: [
            './js/vendor/popper/popper.js',
            './js/vendor/bootstrap/bootstrap.bundle.js'
        ],
        src:[
            './js/src/scripts.js'
        ]
    },
    scss: {
        src: [
            './scss/styles.scss'
        ]
    },
    clean: [
        './js/vendor',
        './scss/vendor',
        './css/dist',
        './js/dist'
    ]
};

gulp.task('vendor:jquery', function () {
    return pipe(gulp.src('./node_modules/jquery/dist/**/*.*'),
        [gulp.dest('./js/vendor/jquery')]
    ).on('error', function(error) {
        fancyLog.error(error);
    });
});

gulp.task('vendor:popper', function () {
    return pipe(gulp.src(['./node_modules/popper.js/dist/umd/popper.js']),
        [gulp.dest('./js/vendor/popper')]
    ).on('error', function(error) {
        fancyLog.error(error);
    });
});

gulp.task('vendor:bootstrap:js', function() {
    return pipe(gulp.src(['./node_modules/bootstrap/dist/js/**/*.*']),
        [gulp.dest('./js/vendor/bootstrap')]
    ).on('error', function(error) {
        fancyLog.error(error);
    });
});

gulp.task('vendor:bootstrap:scss', function() {
    return pipe(gulp.src(['./node_modules/bootstrap/scss/**/*.*']),
        [gulp.dest('./scss/vendor/bootstrap')]
    ).on('error', function(error) {
        fancyLog.error(error);
    });
});

gulp.task('scss', ['move'], function () {
    return pipe(gulp.src(paths.scss.src),
        [
            sourcemaps.init(),
            sass().on('error', gutil.log),
            autoprefixer(),
            concat('all.css'),
            stripStyleComments({preserve: false}),
            cssmin(),
            sourcemaps.write('./'),
            gulp.dest('./css/dist')
        ]
    ).on('error', function(error) {
        fancyLog.error(error);
    });
});

gulp.task('js', ['move'], function () {
    return pipe(gulp.src(paths.js.vendor.concat(paths.js.src)),
        [
            sourcemaps.init(),
            concat('all.js'),
            stripComments(),
            uglifyES(),
            sourcemaps.write('./'),
            gulp.dest('./js/dist')
        ]
    ).on('error', function(error) {
        fancyLog.error(error);
    });
});

// Build Tasks
gulp.task('clean', function () {
    return pipe(gulp.src(paths.clean, {read: false}),
        [
            // clean()
        ]
    ).on('error', function(error) {
        fancyLog.error(error);
    });
});

//Watch Tasks
gulp.task("watch", function () {
    gulp.watch(paths.js.src, ["build"]);
    gulp.watch(paths.scss.src, ["build"]);
});

//General Tasks
gulp.task('move:vendor', getDependentTasks('vendor'));
gulp.task('move', getDependentTasks('move'));
gulp.task('build', ['clean', 'scss', 'js']);
gulp.task('default', ['build', 'watch']);