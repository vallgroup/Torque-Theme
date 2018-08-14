import React from 'react'
import styles from './PointsOfInterest.scss'

class PointsOfInterest extends React.PureComponent {
  render() {
    return (
      <div
        className={`torque-map-pois`}
        data-location={this.props.location}>
        {this.props.pois &&
          this.props.pois.map((poi, index) => {
            const active =
              poi.keyword === this.props.searchNearby ? 'active' : ''

            return (
              <div
                key={index}
                className={`torque-map-poi ${styles.torqueMapPOI} ${active}`}
                data-poi={poi.name.toLowerCase().trim().replace(/[^\w\d]/, '-')}>
                <button
                  onClick={() => this.props.updatePOIS(poi)}
                  dataname={poi.name}>
                  {poi.name}
                </button>
              </div>
            )
          })}
      </div>
    )
  }
}

export default PointsOfInterest
