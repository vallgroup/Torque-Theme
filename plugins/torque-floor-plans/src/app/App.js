import React, { Component } from 'react'
import axios from 'axios'
import style from './App.scss'

// props
//
// site: string

class App extends Component {
  constructor(props) {
    super(props)

    this.state = {
      floorPlans: []
    }
  }

  componentDidMount() {
    this.getFloorPlans()
  }

  render() {
    console.log(this.state)
    return <div className={style.test}>{this.props.text}</div>
  }

  async getFloorPlans() {
    try {
      const floorPlansUrl = `${this.props.site}/wp-json/floor-plans/v1/floor-plans/`

      const { data } = await axios.get(floorPlansUrl)

      if (data.success) {
        this.setState({ floorPlans: data.floor_plans })
      } else {
        throw 'Failed getting floor plans'
      }
    } catch (e) {
      console.log(e)
      this.setState({ floorPlans: [] })
    }
  }
}

export default App
