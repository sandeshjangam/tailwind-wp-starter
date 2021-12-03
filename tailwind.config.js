const colors = require('tailwindcss/colors');

module.exports = {
	// purge: [ './src/**/*.@(js|jsx)' ],
	purge: false,
	darkMode: false, // or 'media' or 'class'
	theme: {
		// extend: {},
		extend: {
            colors: {
                // sky: colors.sky,
                // cyan: colors.red,
                // indigo: colors.red,
            },
        },
	},
	variants: {
		extend: {},
	},
	plugins: [],
}
