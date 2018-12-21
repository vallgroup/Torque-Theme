const projectConfig = require('../../config')
const path = require('path')
const webpack = require('webpack')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const srcDir = path.join(__dirname, 'src')
const buildDir = path.join(
  projectConfig.root,
  'wp-content/plugins/torque-recaptcha'
)

const config = {
  context: srcDir,

  entry: {
    main: ['./index.js'],
  },

  output: {
    path: path.join(buildDir, './bundles'),
    publicPath: '/',
    filename: 'bundle.js',
  },

  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        },
      },
      {
        test: projectConfig.webpackDefaults.css.test,
        exclude: /node_modules/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          use: projectConfig.webpackDefaults.css.loaders,
        }),
      },
      {
        test: projectConfig.webpackDefaults.scssModules.test,
        exclude: /node_modules/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          // resolve-url-loader may be chained before sass-loader if necessary
          use: projectConfig.webpackDefaults.scssModules.loaders,
        }),
      },
      {
        test: projectConfig.webpackDefaults.images.test,
        exclude: /node_modules/,
        use: projectConfig.webpackDefaults.images.loaders,
      },
      {
        test: projectConfig.webpackDefaults.fonts.test,
        exclude: /node_modules/,
        use: projectConfig.webpackDefaults.fonts.loaders,
      },
    ],
  },

  plugins: [
    new ExtractTextPlugin({
      filename: 'main.css',
      publicPath: '/',
      allChunks: true,
      ignoreOrder: true,
    }),
    new CopyWebpackPlugin([
      { from: path.join(srcDir, 'shortcode/*.js'), to: buildDir },
      { from: path.join(srcDir, 'shortcode/*.html'), to: buildDir },
      { from: path.join(srcDir, '**/*.php'), to: buildDir },
    ]),
  ],

  devtool: 'source-map',
}

module.exports = config
