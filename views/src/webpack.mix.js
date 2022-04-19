const mix						      = require('laravel-mix')
const path						      = require('path')
const LiveReloadPlugin			   = require('webpack-livereload-plugin')
const CopyWebpackPlugin			   = require('copy-webpack-plugin')
const ImageminWebpWebpackPlugin	= require("imagemin-webp-webpack-plugin")
const { setPublicPath } = require('laravel-mix')

const paths = {
	dist: './dist',
}

mix
   setPublicPath(paths.dist)
   .js('js/app.js', `${paths.dist}`)
   .sass('scss/app.scss', `${paths.dist}`)
   .copy('images', `${paths.dist}/images`)
   .copy('fonts/', `${paths.dist}/fonts`)
   .version()
   .options({
      processCssUrls: false,
   })
   .webpackConfig({
      module: {
         rules: [
            {
               test: /\.js$/,
               use: 'babel-loader',
               exclude: /node_modules/
            }
         ]
      },
      plugins: [
         new LiveReloadPlugin({
            port: 31725
         }),
         new CopyWebpackPlugin({
            patterns: [
               { from: 'images', to: './images' },
            ]
         }),
         new ImageminWebpWebpackPlugin({
            config: [{
               test: /\.(jpe?g|png)/,
               options: {
                  quality: 75
               }
            }],
            overrideExtension: true,
            detailedLogs: false,
            silent: false,
            strict: true
         })
      ]
   })

if(!mix.inProduction()) {
   mix.options({
      sourcemaps: 'source-map',
      uglify: {
         sourceMap: true
      }
   })
   .sourceMaps()

   mix.webpackConfig({ devtool: "inline-source-map" });
}
