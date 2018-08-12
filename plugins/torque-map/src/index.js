// entry point for React side of plugin
//
import React from 'react'
import ReactDOM from 'react-dom'
import App from './app/App'
import './app/scss/main.scss'

if (!global._babelPolyfill) {
	require('babel-polyfill');
}


const entry = document.querySelectorAll('.torque-map-react-entry')

entry.forEach(entry => {
	console.log( entry )
  if (entry) {
    // pass through the data-site attr as props so the app knows where to send requests
    ReactDOM.render(<App
    	site={entry.getAttribute('data-site')}
    	center={entry.getAttribute('data-center')}
    	centerMarker={entry.getAttribute('data-center_marker')}
    	apiKey={entry.getAttribute('data-api_key')}
    	mapID={entry.getAttribute('data-map_id')} />,
    	entry
    )
  }
})
