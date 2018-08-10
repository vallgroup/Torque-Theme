import React from 'react'
import styles from './PointsOfInterest.scss'

class PointsOfInterest extends React.Component {
	constructor(props) {
		super(props)

		this.state = {

		}
	}

	render() {
		return (
			<div className={`torque-map-pois`}>
				{this.props.pois
					&& this.props.pois.map((poi,index) => {
						return (
							<div
								key={index}
								className={`torque-map-poi ${styles.torqueMapPOI}`}
								onClick={() => this.props.updatePOIS(poi.keyword)}>
								{poi.name}
							</div>
						)
					})}
			</div>
		)
	}
}

export default PointsOfInterest;