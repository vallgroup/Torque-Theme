const projectConfig = require('../../../config')
const path = require('path')
const webpack = require('webpack')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const srcDir = path.join(__dirname, 'src')
const buildDir = path.join(
  projectConfig.root,
  'wp-content/plugins/lib/torque-plugin'
)

const config = {
  context: srcDir,

  entry: {
    main: ['babel-polyfill', './index.js'],
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
    ],
  },

  plugins: [
    new CopyWebpackPlugin([
      { from: path.join(srcDir, '**/*.php'), to: buildDir },
    ]),
  ],
}

module.exports = config
