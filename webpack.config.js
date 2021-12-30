/**
 * WordPress dependencies
 */
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
/**
 * External dependencies
 */
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const WebpackBar = require('webpackbar');
const path = require('path');

module.exports = {
	...defaultConfig,
	entry: {
		theme: path.resolve(process.cwd(), 'src', 'theme.js'),
	},
	output: {
		...defaultConfig.output,
		path: path.resolve(process.cwd(), 'assets'),
	},
	optimization: {
		...defaultConfig.optimization,
		minimizer: [
			...defaultConfig.optimization.minimizer,
			new CssMinimizerPlugin(),
		],
	},
	plugins: [
		...defaultConfig.plugins,
		new WebpackBar({
			name: 'Theme',
			color: '#fddb33',
		}),
	],
};
