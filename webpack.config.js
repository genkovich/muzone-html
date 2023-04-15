const Encore = require('@symfony/webpack-encore');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');
const webpack = require('webpack');
const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './assets/app.js')
    .addEntry('styles', './assets/styles/app.scss')

    .addEntry('admin', './assets/admin.js')
    .addStyleEntry('admin_style', './assets/styles/admin/admin.scss')

    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .enableSassLoader()
    .enablePostCssLoader()
    .addPlugin(new MiniCssExtractPlugin({
        filename: '[name].css'
    }))
    .addPlugin(new ESLintPlugin())
    .addPlugin(new CopyWebpackPlugin({
        patterns: [
            { from: "./assets/landing/libs/form/ua.json", to: "libs/form/" },
        ],
    }),)
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .addAliases({
        '@symfony/stimulus-bridge/controllers.json': path.resolve(__dirname, 'assets/controllers.json'),
        $: 'jquery',
        jQuery: 'jquery'
    })
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
