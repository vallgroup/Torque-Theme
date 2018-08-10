import React from 'react'
import styles from './PointsOfInterest.scss'

class PointsOfInterest extends React.PureComponent {
  render() {
    return (
      <div className={`torque-map-pois`}>
        {this.props.pois &&
          this.props.pois.map((poi, index) => {
            return (
              <div
                key={index}
                className={`torque-map-poi ${styles.torqueMapPOI}`}
                onClick={() => this.props.updatePOIS(poi.keyword)}
                dataname={poi.name}>
                {poi.name}
              </div>
            )
          })}
      </div>
    )
  }
}

export default PointsOfInterest
