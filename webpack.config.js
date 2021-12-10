const Encore = require('@symfony/webpack-encore');

Encore
    .addEntry('app_js', './assets/app.js')
    .addEntry('panel_js', './assets/panel.js')
    .addStyleEntry('app_css', './assets/css/app.scss')
    .addStyleEntry('panel_css', './assets/css/panel.scss')
    .autoProvidejQuery()
    .cleanupOutputBeforeBuild()
    .copyFiles({
        from: './public/images',
        to: 'images/[path][name].[ext]',
    })
    .enableBuildNotifications()
    .enableSassLoader()
    .enableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .setOutputPath('public/build/')
    .setPublicPath('/build')

;

module.exports = Encore.getWebpackConfig();