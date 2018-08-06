const path = require('path')

const root = __dirname

const webpackDefaults = {
  js: {
    test: /\.js$/,
    loaders: {
      loader: 'babel-loader',
      options: {
        babelrc: path.join(root, './.babelrc'),
      },
    },
  },
  css: {
    test: /\.css$/,
    loaders: [
      {
        loader: 'css-loader',
      },
      {
        loader: 'postcss-loader',
        options: {
          config: {
            path: path.join(root, './postcss.config.js'),
          },
        },
      },
    ],
  },
  scss: {
    test: /\.scss$/,
    loaders: [
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
            path: path.join(root, './postcss.config.js'),
          },
        },
      },
    ],
  },
  scssModules: {
    test: /\.scss$/,
    loaders: [
      {
        loader: 'css-loader?modules&importLoaders=1&localIdentName="[local]__[hash:base64:5]"',
      },
      {
        loader: 'sass-loader?sourceMap',
      },
      {
        loader: 'postcss-loader',
        options: {
          config: {
            path: path.join(root, './postcss.config.js'),
          },
        },
      },
    ],
  },
  images: {
    test: /\.(png|jpg|gif|svg)$/,
    loaders: {
      loader: 'url-loader',
      options: {
        limit: 8192,
      },
    },
  },
  fonts: {
    test: /\.(woff|woff2|eot|ttf|otf)$/,
    loaders: 'file-loader',
  },
}

module.exports = {
  root,
  webpackDefaults,
}
