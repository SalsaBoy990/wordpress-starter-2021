// eslint-disable-next-line no-undef
const gulp = require('gulp');
// eslint-disable-next-line no-undef
const zip = require('gulp-zip');

function bundle() {
  return gulp
    .src([
      '**/*',
      '!node_modules/**',
      '!src/**',
      '!bundled/**',
      '!gulpfile.js',
      '!package.json',
      '!package-lock.json',
      '!webpack.config.js',
      '!postcss.config.js',
      '!.gitignore',
    ])
    .pipe(zip('reactwp-blocks.zip'))
    .pipe(gulp.dest('bundled'));
}

// eslint-disable-next-line no-undef
exports.bundle = bundle;
