const { task, series, watch, src, dest, parallel } = require('gulp');
const gulp_rename = require('gulp-rename');
const gulp_sass = require('gulp-sass');
const gulp_autoprefixer = require('gulp-autoprefixer');
const gulp_sourcemaps = require('gulp-sourcemaps');
const gulp_browserify = require('browserify');
const babelify = require('babelify');
const vinyl_source_stream = require('vinyl-source-stream');
const vinyl_buffer = require('vinyl-buffer');
const gulp_uglify = require('gulp-uglify');
const browser_sync = require('browser-sync').create();
const plumber = require('gulp-plumber');

const styleSRC = 'src/scss/styles.scss';
const formStyleSrc = 'src/scss/form.scss';
const styleASSESTS = './assets/sass/';
const stylesToWatch = 'src/scss/**/*.scss';

const scriptSRC = 'script.js';
const formScriptSRC = 'form.js';
const scriptFolder = 'src/js/';
const scriptASSESTS = './assets/js/';
const scriptsToWatch = 'src/js/**/*.js';
const scriptURL = './assets/js/';
const scriptFiles = [scriptSRC, formScriptSRC];

const htmlSRC = './src/**/*.html';
const htmlURL = './assets/';
const htmlToWatch = './src/**/*.html';


function CSSstyle(cb) {
    src([styleSRC, formStyleSrc])
        .pipe(gulp_sourcemaps.init())
        .pipe(gulp_sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        }))
        .on('error', console.error.bind(console))
        .pipe(gulp_rename({
            suffix: '.min'
        }))
        .pipe(gulp_autoprefixer({
            overrideBrowserslist: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp_sourcemaps.write('./'))
        .pipe(dest(styleASSESTS));

    cb();
};

function JSscript(cb) {
    scriptFiles.map(function(entry) {
        return gulp_browserify({
                entries: [scriptFolder + entry]
            }).transform(babelify, {
                presets: ['@babel/preset-env']
            }).bundle()
            .pipe(vinyl_source_stream(entry))
            .pipe(gulp_rename({
                extname: '.min.js'
            }))
            .pipe(vinyl_buffer())
            .pipe(gulp_sourcemaps.init({ loadMaps: true }))
            .pipe(gulp_uglify())
            .pipe(gulp_sourcemaps.write('./'))
            .pipe(dest(scriptASSESTS))
    });

    cb();
};

function triggerPlumber(source, url_link) {
    return src(source)
        .pipe(plumber())
        .pipe(dest(url_link));
}

// function phpFiles() {

//     return triggerPlumber(phpFileSRC, phpURL);

// };

function htmlFiles() {

    return triggerPlumber(htmlSRC, htmlURL);

}

function browserSync() {
    browser_sync.init({
        server: {
            baseDir: "./assets/",
            open: false,
            injectChanges: true
        }
    });
};

function reload(cb) {
    browser_sync.reload();
    cb();
};

function watchFiles() {
    watch(stylesToWatch, series(CSSstyle, reload));
    watch(scriptsToWatch, series(JSscript, reload));
    watch(htmlToWatch, series(htmlFiles, reload));
    // watch(phpToWatch, series(phpFiles, reload));
};

task('CSSstyle', CSSstyle);
task('htmlFiles', htmlFiles);
task('JSscript', JSscript);

task('default', parallel(CSSstyle, JSscript, htmlFiles));
task("watch", parallel(browserSync, watchFiles));