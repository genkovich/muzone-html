const Encore = require('@symfony/webpack-encore');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');
const webpack = require('webpack');
const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const fs = require('fs');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('landing/script', './assets/landing/js/app.js')
    .addStyleEntry('landing/style', './assets/landing/styles/app.scss')

    .addEntry('admin/script', './assets/admin/js/admin.js')
    .addStyleEntry('admin/style', './assets/admin/styles/admin.scss')

    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .enableSassLoader(
        options => {
            options.sassOptions = {
                ...options.sassOptions,
                includePaths: [path.resolve(__dirname, 'node_modules')],
            };
        }
    )
    .enablePostCssLoader()
    .addPlugin(new MiniCssExtractPlugin({
        filename: '[name].css'
    }))
    .addPlugin(new ESLintPlugin())
    .addPlugin(new CopyWebpackPlugin({
        patterns: [
            { from: "./assets/landing/js/libs/form/ua.json", to: "libs/form/" },
        ],
    }),)
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .autoProvidejQuery()
    .copyFiles({
        from: './assets/favicon',
        to: 'favicon/[path][name].[ext]',
    })
;

const adminJsPath = './assets/admin/js';
const adminJsFiles = fs.readdirSync(adminJsPath);

adminJsFiles.forEach(file => {
    const fileName = path.basename(file, '.js');
    Encore.addEntry(`admin/js/${fileName}`, path.resolve(adminJsPath, file));
});

module.exports = Encore.getWebpackConfig();
