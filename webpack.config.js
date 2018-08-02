const path = require('path')
const webpack = require('webpack')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const srcDir = path.join(__dirname, 'src')
const buildDir = path.join(__dirname, 'wp-content/themes/torque')

const config = {
  context: srcDir,

  entry: {
    main: ['babel-polyfill', './js/index.js'],
  },

  output: {
    path: `${buildDir}/bundles`,
    publicPath: '/',
    filename: 'bundle.js',
  },

  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: ['/node_modules/', 'statics'],
        use: {
          loader: 'babel-loader',
        },
      },
      {
        test: /\.css$/,
        exclude: ['statics'],
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          use: ['css-loader', 'postcss-loader'],
        }),
      },
      {
        test: /\.scss$/,
        exclude: ['statics'],
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          // resolve-url-loader may be chained before sass-loader if necessary
          use: ['css-loader', 'sass-loader?sourceMap', 'postcss-loader'],
        }),
      },
      {
        test: /\.(png|jpg|gif|svg)$/,
        exclude: ['statics'],
        use: {
          loader: 'url-loader',
          options: {
            limit: 8192,
          },
        },
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
        exclude: ['statics'],
        use: 'file-loader',
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
      { from: `${srcDir}/statics/**/*`, to: `${buildDir}/statics` },
      { from: `${srcDir}/external/**/*`, to: `${buildDir}/external` },
      { from: `${srcDir}/parts/**/*`, to: `${buildDir}/parts` },
      { from: `${srcDir}/style.css`, to: `${buildDir}` },
      { from: `${srcDir}/screenshot.png`, to: `${buildDir}` },
      { from: `${srcDir}/*.php`, to: `${buildDir}` },
    ]),
  ],

  devtool: 'source-map',

  devServer: {
    historyApiFallback: {
      rewrites: [
        {
          from: /!(css|js|map|png|ico|jpg|woff|woff2|ttf)$/,
          to: '/index.html',
        },
      ],
    },
  },
}

module.exports = config
