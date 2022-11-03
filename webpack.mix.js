const mix = require('laravel-mix')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const path = require('path')
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
/**

 */
// @ts-ignore
// mix.setPublicPath('public')
// @ts-ignore
mix.webpackConfig({
  watchOptions: {
    ignored: /node_modules/
  },
  optimization: {
    splitChunks: {
      chunks: 'all',
      minSize: 50000,
      maxSize: 500000,
      minChunks: 1,
      maxAsyncRequests: 30,
      maxInitialRequests: 30,
      automaticNameDelimiter: '~',
      enforceSizeThreshold: 90000,
      cacheGroups: {
        defaultVendors: {
          test: /[\\/]node_modules[\\/]/,
          priority: -10
        },
        default: {
          minChunks: 2,
          priority: -20,
          reuseExistingChunk: true
        }
      }
    }
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: '/node_modules/',
        use: [
          // @ts-ignore
          {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
          }
        ]
      }
    ]
  },
  output: {
    // production
    path: path.resolve(__dirname, 'public'),
    filename: '[name].bundle.js'
    //    chunkFilename: 'js/chunks/[name].js',                   // development
  },
  plugins: [
    /**
         * All files inside webpack's output.path directory will be removed once, but the
         * directory itself will not be. If using webpack 4+'s default configuration,
         * everything under <PROJECT_DIR>/dist/ will be removed.
         * Use cleanOnceBeforeBuildPatterns to override this behavior.
         *
         * During rebuilds, all webpack assets that are not used anymore
         * will be removed automatically.
         *
         * See `Options and Defaults` for information
         */
    new CleanWebpackPlugin({
      cleanOnceBeforeBuildPatterns: [
        '**/*',
        '!index.php',
        '!.htaccess',
        '!vendor/**/**',
        '!css/styles.css',
        '!assets'
      ]
    }),
    new HtmlWebpackPlugin({
      template: path.resolve(__dirname, 'resources/views/templates/app.blade.php'),
      filename: path.resolve(__dirname, 'resources/views/layouts/app.blade.php'),
      inject: false
    }),
    new HtmlWebpackPlugin({
      template: path.resolve(__dirname, 'resources/views/templates/app_login.blade.php'),
      filename: path.resolve(__dirname, 'resources/views/layouts/app_login.blade.php'),
      inject: false
    })
  ]
})

// @ts-ignore
mix.sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/datatables.scss', 'public/css')
  .extract(['jquery', 'lodash', 'axios'])
  .extract(['bootstrap', 'moment', 'bootstrap-daterangepicker', 'ckeditor', 'toastr'])
  .extract(['select2', 'inputmask', 'inputmask/lib/jquery.inputmask', 'inputmask/lib/extensions/inputmask.extensions', 'inputmask/lib/extensions/inputmask.date.extensions', 'inputmask/lib/extensions/inputmask.numeric.extensions'])
  .extract(['jquery-validation', 'jquery.redirect', 'ladda', 'fullcalendar', 'bootbox'])
  .extract(['datatables-net', 'datatables-net-bs4', 'datatables-net-buttons', 'datatables-net-buttons-bs4', 'datatables-net-responsive', 'datatables-net-responsive-bs4', 'jquery-datatables-checkboxes', 'datatables.net-select-bs4'], 'datatables.js')
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/datatables.js', 'public/js')

// @ts-ignore
if (mix.inProduction()) {
  // @ts-ignore
  mix.version()
}
