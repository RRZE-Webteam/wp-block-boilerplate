const defaultConfig = require('@wordpress/scripts/config/webpack.config');

// Import the helper to find and generate the entry points in the src directory
const { getWebpackEntryPoints } = require( '@wordpress/scripts/utils/config' );

// Check if it's a production build
const isProduction = process.env.NODE_ENV === 'production';

let optimization = defaultConfig.optimization;

if (isProduction) {
  optimization = {
    ...defaultConfig.optimization,
  };
}

// Set the devtool based on the build environment
const devtool = isProduction ? false : 'eval-source-map';

module.exports = {
  ...defaultConfig,
  entry: {
		...getWebpackEntryPoints('script')(),
	},
  devtool: devtool,
  module: {
    ...defaultConfig.module,
    rules: [
      ...defaultConfig.module.rules,
    ],
  },
  optimization: optimization,
  performance: {
    ...defaultConfig.performance,
    hints: false
  },
};
