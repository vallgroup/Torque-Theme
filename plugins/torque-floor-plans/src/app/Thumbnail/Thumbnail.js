import React, { PureComponent } from 'react'

class Thumbnail extends PureComponent {
  render() {
    if (!this.props.floorPlan || !this.props.floorPlan.thumbnail) {
      return null
    }

    return (
      <img
        style={{
          width: '100%',
          height: '100%',
          objectFit: 'contain',
        }}
        src={this.props.floorPlan.thumbnail}
      />
    )
  }
}

export default Thumbnail
