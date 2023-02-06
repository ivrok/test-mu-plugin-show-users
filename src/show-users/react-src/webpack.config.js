const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
    ...defaultConfig,
    resolve: {
        extensions: ['.js', '.jsx']
    }
}
