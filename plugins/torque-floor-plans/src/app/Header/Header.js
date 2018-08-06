import React, { PureComponent } from 'react'
import { getFloorWithAffix } from '../App'

class Header extends PureComponent {
  renderButton() {
    if (
      !this.props.floorPlan.downloads ||
      !this.props.floorPlan.downloads.pdf
    ) {
      return null
    }

    return (
      <a href={this.props.floorPlan.downloads.pdf} target="_blank">
        <button>{'Download PDF'}</button>
      </a>
    )
  }

  render() {
    if (!this.props.floorPlan) {
      return null
    }

    return (
      <React.Fragment>
        <div
          style={{
            display: 'inline-block',
            verticalAlign: 'top',
            paddingRight: '25px',
            width: '33%',
            boxSizing: 'border-box',
          }}>
          <h3 style={{ width: '100%', textTransform: 'uppercase' }}>
            {getFloorWithAffix(this.props.floorPlan)}
          </h3>
          <h4 style={{ width: '100%', textTransform: 'uppercase' }}>
            {this.props.floorPlan.post_title}
          </h4>
        </div>
        <div
          style={{
            display: 'inline-block',
            verticalAlign: 'top',
            width: '66%',
          }}>
          {this.renderButton()}
        </div>
      </React.Fragment>
    )
  }
}

export default Header
