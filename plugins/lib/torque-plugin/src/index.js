// entry point for React side of plugin
//
import React from 'react'
import ReactDOM from 'react-dom'
import App from './app/App'
import './app/scss/main.scss'

const entry = document.querySelector('<torque_plugin_slug>-react-entry')
if (entry) {
  ReactDOM.render(<App />, entry)
}
