import '../scss/main.scss'

if (!global._babelPolyfill) {
	require('babel-polyfill');
}

import './header/toggle-burger-menu'
