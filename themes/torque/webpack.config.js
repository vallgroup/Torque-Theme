const rootConfig = require('../../config')
const path = require('path')
const webpack = require('webpack')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const srcDir = path.join(__dirname, 'src')
const buildDir = path.join(rootConfig.root, 'wp-content/themes/torque')

const config = {
  context: srcDir,

  entry: {
    main: ['babel-polyfill', './js/index.js'],
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
        exclude: ['/node_modules/', 'statics'],
        use: {
          loader: 'babel-loader',
          options: {
            babelrc: path.join(rootConfig.root, './.babelrc'),
          },
        },
      },
      {
        test: /\.css$/,
        exclude: ['statics'],
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          use: [
            {
              loader: 'css-loader',
            },
            {
              loader: 'postcss-loader',
              options: {
                config: {
                  path: path.join(rootConfig.root, './postcss.config.js'),
                },
              },
            },
          ],
        }),
      },
      {
        test: /\.scss$/,
        exclude: ['statics'],
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          // resolve-url-loader may be chained before sass-loader if necessary
          use: [
            {
              loader: 'css-loader',
            },
            {
              loader: 'sass-loader?sourceMap',
            },
            {
              loader: 'postcss-loader',
              options: {
                config: {
                  path: path.join(rootConfig.root, './postcss.config.js'),
                },
              },
            },
          ],
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
      {
        from: path.join(srcDir, 'statics/**/*'),
        to: path.join(buildDir, 'statics'),
      },
      {
        from: path.join(srcDir, 'external/**/*'),
        to: path.join(buildDir, 'external'),
      },
      {
        from: path.join(srcDir, 'parts/**/*'),
        to: path.join(buildDir, 'parts'),
      },
      { from: path.join(srcDir, 'style.css'), to: buildDir },
      { from: path.join(srcDir, 'screenshot.png'), to: buildDir },
      { from: path.join(srcDir, '*.php'), to: buildDir },
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
