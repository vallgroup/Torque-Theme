import React, { Component } from 'react'
import axios from 'axios'
import FloorPlanSelector from './FloorPlanSelector/FloorPlanSelector'
import Header from './Header/Header'
import Thumbnail from './Thumbnail/Thumbnail'
import style from './App.scss'

// props
//
// site: string

class App extends Component {
  constructor(props) {
    super(props)

    this.state = {
      floorPlans: [],
      selected: 0,
    }
  }

  componentDidMount() {
    this.getFloorPlans()
  }

  updateSelected(newIndex) {
    this.setState({ selected: newIndex })
  }

  getSelectedFloorPlan() {
    return this.state.floorPlans[this.state.selected]
  }

  render() {
    if (!this.state.floorPlans || !this.state.floorPlans.length) {
      return null
    }

    return (
      <div className={`torque-floor-plans ${style.floorPlans}`}>
        <div className={`torque-floor-plans-header-wrapper ${style.header}`}>
          <Header floorPlan={this.getSelectedFloorPlan()} />
        </div>
        <div className={`torque-floor-plans-selector ${style.selector}`}>
          <div className={`torque-floor-plans-list ${style.list}`}>
            <FloorPlanSelector
              floorPlans={this.state.floorPlans}
              updateSelected={this.updateSelected.bind(this)}
            />
          </div>
          <div className={`torque-floor-plans-thumbnail ${style.thumbnail}`}>
            <Thumbnail floorPlan={this.getSelectedFloorPlan()} />
          </div>
        </div>
      </div>
    )
  }

  async getFloorPlans() {
    try {
      const floorPlansUrl = `${
        this.props.site
      }/wp-json/floor-plans/v1/floor-plans/`

      const { data } = await axios.get(floorPlansUrl)

      if (data.success) {
        this.setState({ floorPlans: data.floor_plans, selected: 0 })
      } else {
        throw 'Failed getting floor plans'
      }
    } catch (e) {
      console.log(e)
      this.setState({ floorPlans: [], selected: 0 })
    }
  }
}

export function getFloorWithAffix(floorPlan) {
  let affix = 'th'

  switch (parseInt(floorPlan.floor_number)) {
    case 1 || -1:
      affix = 'st'
      break

    case 2 || -2:
      affix = 'nd'
      break

    case 3 || -3:
      affix = 'rd'
      break

    default:
      affix = 'th'
  }

  return `${floorPlan.floor_number}${affix} floor`
}

export default App
