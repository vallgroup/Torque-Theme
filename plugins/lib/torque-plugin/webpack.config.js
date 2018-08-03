const projectConfig = require('../../config')
const path = require('path')
const webpack = require('webpack')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const srcDir = path.join(__dirname, 'src')
const buildDir = path.join(
  projectConfig.root,
  'wp-content/plugins/<torque_plugin_slug>'
)

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
        test: projectConfig.webpackDefaults.js.test,
        exclude: ['/node_modules/'],
        use: projectConfig.webpackDefaults.js.loaders,
      },
      {
        test: projectConfig.webpackDefaults.css.test,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          use: projectConfig.webpackDefaults.css.loaders,
        }),
      },
      {
        test: projectConfig.webpackDefaults.scss.test,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader?sourceMap',
          // resolve-url-loader may be chained before sass-loader if necessary
          use: projectConfig.webpackDefaults.scss.loaders,
        }),
      },
      {
        test: projectConfig.webpackDefaults.images.test,
        use: projectConfig.webpackDefaults.images.loaders,
      },
      {
        test: projectConfig.webpackDefaults.fonts.test,
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
      { from: path.join(srcDir, '**/*.php'), to: buildDir },
    ]),
  ],

  devtool: 'source-map',
}

module.exports = config
