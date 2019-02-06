const path = require("path");

const root = __dirname;

const webpackDefaults = {
  js: {
    test: /\.js$/,
    loaders: {
      loader: "babel-loader",
      options: {
        babelrc: path.join(root, "./.babelrc")
      }
    }
  },
  css: {
    test: /\.css$/,
    loaders: [
      {
        loader: "css-loader?-autoprefixer"
      },
      {
        loader: "postcss-loader",
        options: {
          config: {
            path: root
          }
        }
      }
    ]
  },
  scss: {
    test: /\.scss$/,
    loaders: [
      {
        loader: "css-loader?-autoprefixer"
      },
      {
        loader: "postcss-loader",
        options: {
          config: {
            path: root
          }
        }
      },
      {
        loader: "sass-loader?sourceMap"
      }
    ]
  },
  scssModules: {
    test: /\.scss$/,
    loaders: [
      {
        loader:
          'css-loader?-autoprefixer&modules&importLoaders=1&localIdentName="[local]__[hash:base64:5]"'
      },
      {
        loader: "postcss-loader",
        options: {
          config: {
            path: root
          }
        }
      },
      {
        loader: "sass-loader?sourceMap"
      }
    ]
  },
  images: {
    test: /\.(png|jpg|gif|svg)$/,
    loaders: {
      loader: "url-loader",
      options: {
        limit: 8192
      }
    }
  },
  fonts: {
    test: /\.(woff|woff2|eot|ttf|otf)$/,
    loaders: "file-loader"
  }
};

module.exports = {
  root,
  webpackDefaults
};
