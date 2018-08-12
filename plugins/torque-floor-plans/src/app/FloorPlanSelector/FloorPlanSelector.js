import React, { PureComponent } from 'react'
import { getFloorWithAffix } from '../App'
import style from './FloorPlanSelector.scss'

class FloorPlanSelector extends PureComponent {
  renderFloor(floorPlan) {
    return (
      <div className={`${style.optionBlock} ${style.floor}`}>
        {getFloorWithAffix(floorPlan)}
      </div>
    )
  }

  renderTitle(floorPlan) {
    return <div className={`${style.optionBlock}`}>{floorPlan.post_title}</div>
  }

  renderRSF(floorPlan) {
    const formatted = floorPlan.rsf.replace(/\d(?=(\d{3})$)/g, '$&,')
    return (
      <div className={`${style.optionBlock}`}>
        {`${formatted} RSF`}
      </div>
    )
  }

  render() {
    if (!this.props.floorPlans) {
      return null
    }

    return (
      <React.Fragment>
        <h4 className={style.title}>
          {'CLICK TO PREVIEW FLOOR PLAN ON THE RIGHT'}
        </h4>
        {this.props.floorPlans
          .sort((a, b) => {
            return a.floor_number > b.floor_number
          })
          .map((floorPlan, index) => {
            return (
              <div
                key={index}
                className={style.option}
                onClick={() => {
                  this.props.updateSelected(index)
                }}>
                {this.renderFloor(floorPlan)}
                {this.renderTitle(floorPlan)}
                {this.renderRSF(floorPlan)}
              </div>
            )
          })}
      </React.Fragment>
    )
  }
}

export default FloorPlanSelector
