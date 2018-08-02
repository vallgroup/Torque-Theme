const path = require('path')
const webpack = require('webpack')
const ExtractTextPlugin = require('extract-text-webpack-plugin')

const srcDir = path.join(__dirname, 'src')

const config = {
  context: srcDir,

  entry: {
    main: ['babel-polyfill', './js/index.js'],
  },

  output: {
    path: path.join(__dirname, 'dist/bundles'),
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
        test: /\.css$/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          use: ['css-loader', 'postcss-loader'],
        }),
      },
      {
        test: /\.scss$/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          // resolve-url-loader may be chained before sass-loader if necessary
          use: ['css-loader', 'sass-loader?sourceMap', 'postcss-loader'],
        }),
      },
      {
        test: /\.(png|jpg|gif|svg)$/,
        use: {
          loader: 'url-loader',
          options: {
            limit: 8192,
          },
        },
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
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
