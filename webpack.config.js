const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
module.exports = {
  mode: 'production',
  resolve: {
    alias: {
      wp_theme: path.resolve(__dirname, 'wp-content/themes/fritidsbanken/'),
    },
  },
  entry: [
    'wp_theme/src/sass/style.scss',
    'wp_theme/src/sass/admin-overwrites.scss',
    'wp_theme/src/js/main.js',
  ],
  output: {
    filename: 'wp-content/themes/fritidsbanken/assets/js/main.min.js',
    path: path.resolve(__dirname),
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: 'wp-content/themes/fritidsbanken/[name].css',
            },
          },
          {
            loader: 'extract-loader',
          },
          {
            loader: 'css-loader?-url',
          },
          {
            loader: 'postcss-loader',
          },
          {
            loader: 'sass-loader',
          },
        ],
      },
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [['@babel/preset-env']],
          },
        },
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        use: ['file-loader'],
      },
    ],
  },
  // remove comments from JS files
  optimization: {
    minimizer: [
      new UglifyJsPlugin({
        uglifyOptions: {
          output: {
            comments: false,
          },
        },
      }),
      new OptimizeCSSAssetsPlugin({
        cssProcessorPluginOptions: {
          preset: ['default', { discardComments: { removeAllButFirst: true } }],
        },
      }),
    ],
  },
};
