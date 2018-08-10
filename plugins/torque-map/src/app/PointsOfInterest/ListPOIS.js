import React from 'react'
import axios from 'axios'

export default class ListPOIS extends React.Component {
	constructor(props) {
		super(props)

		this.state = {
			list: [],
		}
	}

	componentDidUpdate(prevProps) {
		if (this.props.list !== prevProps.list) {
			const destinations = this.props.list.map(poi => {
				return poi.geometry.location //new google.maps.LatLng(lat,lng)
			})
			if (this.props.showDistanceFrom) {
	    	this.getDistances(this.props.showDistanceFrom, destinations)
			}
	    this.setState({
	    	list: this.props.list,
	    })
	  }
	}

	render() {
		return (
			<div className={`torque-map-pois-list`}>
				{this.state.list
					&& 0 < this.state.list.length
					&& this.state.list.map((poi, index) => {
						return (
							<div
								key={index}
								className={`torque-map-pois-list-item`}>

								<div
									className={`torque-map-pois-list-item-name`}>
									{poi.name}
								</div>

								{/* show distance from,
								if showDistanceFrom prop is present */}
								{this.props.showDistanceFrom
									&& <div
										className={`torque-map-pois-list-item-distance`}>
											{poi.distance}
									</div>}
							</div>
						)
					})}
			</div>
		)
	}

	getDistances(origin, destinations) {
		var service = new google.maps.DistanceMatrixService();
		return service.getDistanceMatrix({
	    origins: [new google.maps.LatLng(origin.lat, origin.lng)],
	    destinations: destinations,
	    unitSystem: google.maps.UnitSystem.IMPERIAL,
	    travelMode: 'DRIVING',
	    // transitOptions: TransitOptions,
	    // drivingOptions: DrivingOptions,
	    // avoidHighways: Boolean,
	    // avoidTolls: Boolean,
	  }, (resp) => {

	  	if (resp.rows
	  		&& 0 < resp.rows.length) {

	  		let destinations = this.state.list
	  		for (var i = 0; i < resp.rows[0].elements.length; i++) {
	  			destinations[i].distance = resp.rows[0].elements[i].distance.text
		  	}

		  	this.setState({
		  		list: destinations
		  	})
	  	}
	  });
	}
}