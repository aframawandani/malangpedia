const cssImport = require('postcss-import')
const cssNesting = require('postcss-nesting')
const mix = require('laravel-mix')
const path = require('path')
const purgecss = require('@fullhuman/postcss-purgecss')
const tailwindcss = require('tailwindcss')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css/app.css')
  .options({
    postCss: [
      cssImport(),
      cssNesting(),
      tailwindcss('tailwind.config.js'),
      ...mix.inProduction() ? [
        purgecss({
          content: ['./resources/views/**/*.blade.php', './resources/js/**/*.vue'],
          defaultExtractor: content => content.match(/[\w-/:.]+(?<!:)/g) || [],
          whitelistPatternsChildren: [/nprogress/],
        }),
      ] : [],
    ],
  })
  .webpackConfig({
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '@': path.resolve('resources/js'),
      },
    },
  })
  .version()
  .sourceMaps()

Mix.listen('configReady', webpackConfig => {
  if (Mix.isUsing('hmr')) {
    // Remove leading '/' from entry keys
    webpackConfig.entry = Object.keys(webpackConfig.entry).reduce((entries, entry) => {
      entries[entry.replace(/^\//, '')] = webpackConfig.entry[entry];
          
      return entries;
    }, {});

    // Remove leading '/' from ExtractTextPlugin instances
    webpackConfig.plugins.forEach(plugin => {
      if (plugin.constructor.name === 'ExtractTextPlugin') {
        plugin.filename = plugin.filename.replace(/^\//, '');
      }
    });
  }
});