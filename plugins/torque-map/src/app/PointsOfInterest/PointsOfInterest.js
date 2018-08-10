import React from 'react'
import styles from './PointsOfInterest.scss'

class PointsOfInterest extends React.PureComponent {
  render() {
    return (
      <div className={`torque-map-pois`}>
        {this.props.pois &&
          this.props.pois.map((poi, index) => {
            const active =
              poi.keyword === this.props.searchNearby ? 'active' : ''

            return (
              <button
                key={index}
                className={`torque-map-poi ${styles.torqueMapPOI} ${
                  poi.color
                } ${active}`}
                onClick={() => this.props.updatePOIS(poi.keyword)}
                dataname={poi.name}>
                {poi.name}
              </button>
            )
          })}
      </div>
    )
  }
}

export default PointsOfInterest
