import React, { Component } from 'react'
import TorqueMap from './Map/Map'

// props
//
// site: string

class App extends Component {
  render() {
    return <TorqueMap apiKey={`AIzaSyDPF2QsUSJKHsmGoPcjIgRySglSZgD-asA`} />
  }
}

export default App
