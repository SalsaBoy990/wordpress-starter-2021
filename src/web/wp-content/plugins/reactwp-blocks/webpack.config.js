// eslint-disable-next-line no-undef
const MiniCSSExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
// const path = require("path");

module.exports = (env, argv) => {
  function isDevelopment() {
    return argv.mode === 'development';
  }
  var config = {
    entry: {
      editor: './src/editor.js',
      script: './src/script.js',
    },
    output: {
      filename: '[name].js',
      clean: true,
    },
    optimization: {
      minimizer: [
        new TerserJSPlugin({
          terserOptions: {
            sourceMap: true,
          },
        }),
        new OptimizeCSSAssetsPlugin({
          cssProcessorOptions: {
            map: {
              inline: false,
              annotation: true,
            },
          },
        }),
      ],
    },
    plugins: [
      new MiniCSSExtractPlugin({
        chunkFilename: '[id].css',
        filename: (chunkData) => {
          return chunkData.chunk.name === 'script' ? 'style.css' : '[name].css';
        },
      }),
    ],
    devtool: isDevelopment() ? 'source-map' : '',
    mode: 'development',
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: [
            {
              loader: 'babel-loader',
              options: {
                presets: [
                  '@babel/preset-env',
                  [
                    '@babel/preset-react',
                    {
                      pragma: 'wp.element.createElement',
                      pragmaFrag: 'wp.element.Fragment',
                      development: isDevelopment(),
                    },
                  ],
                ],
                plugins: ['@babel/plugin-proposal-class-properties'],
              },
            },
            'eslint-loader',
          ],
        },
        {
          test: /\.s[ac]ss$/i,
          use: [
            // Creates `style` nodes from JS strings
            // "style-loader",
            MiniCSSExtractPlugin.loader,
            // Translates CSS into CommonJS
            'css-loader',
            'postcss-loader',
            // Compiles Sass to CSS
            'sass-loader',
          ],
        },
        {
          test: /\.css$/i,
          use: [
            // Creates `style` nodes from JS strings
            // Translates CSS into CommonJS
            'css-loader',
            'postcss-loader',
          ],
        },
      ],
    },
    externals: {
      react: 'React',
      'react-dom': 'ReactDOM',
      jquery: 'jQuery',
      lodash: 'lodash',
      '@wordpress/blocks': ['wp', 'blocks'],
      '@wordpress/i18n': ['wp', 'i18n'],
      '@wordpress/editor': ['wp', 'editor'],
      '@wordpress/block-editor': ['wp', 'blockEditor'],
      '@wordpress/components': ['wp', 'components'],
      '@wordpress/element': ['wp', 'element'],
      '@wordpress/blob': ['wp', 'blob'],
      '@wordpress/data': ['wp', 'data'],
      '@wordpress/html-entities': ['wp', 'htmlEntities'],
      '@wordpress/compose': ['wp', 'compose'],
      '@wordpress/api-fetch': ['wp', 'apiFetch'],
      '@wordpress/url': ['wp', 'url'],
    },
  };
  return config;
};
