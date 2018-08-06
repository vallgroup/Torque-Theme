// entry point for React side of plugin
import React from 'react'
import ReactDOM from 'react-dom'
import App from './app/App'
import './app/scss/main.scss'

if (!global._babelPolyfill) {
	require('babel-polyfill');
}

const entry = document.querySelectorAll('.torque-floor-plans-react-entry')

entry.forEach(entry => {
  if (entry) {
    ReactDOM.render(<App text={"Hello World"}/>, entry)
  }
})
