import React from 'react'
import {Map, InfoWindow, Marker, GoogleApiWrapper} from 'google-maps-react'
import style from './Map.scss'
import MapShape from './Shape'

export class TorqueMap extends React.Component {

	constructor(props) {
		super(props)

		this.state = {
			mapCenter: {}, // lat a& lng object
			selectedPlace: {},
      activeMarker: {},
      showingInfoWindow: false,
      markers: [],
		}

		this.map = null
		this.geocoder = null
		this.placesServices = null

	}

	componentWillMount() {
		this.setMapCenterFromProps()
	}

	componentDidUpdate(prevProps) {
	  // Typical usage (don't forget to compare props):
	  if (this.props.searchNearby !== prevProps.searchNearby) {
	  	console.log('I ran')
	    this.nearbySearch(this.props.searchNearby)
	  }
	}

	render() {
		// console.log(this.map)
		// console.log(this.props)
		// console.log(this.state)
		return (
			<div
				onClick={this.onMapClick.bind(this)}
				className={`torque-map-container ${style.torqueMap}`}>

				<Map
					google={this.props.google}
					zoom={15}
					center={this.state.mapCenter}
					ref={(mapObject) => this.map = mapObject && mapObject.map}>

					{this.props.center
						&& this.props.centerMarker
						&& this.ouputCenterMarker()}

					{this.state.markers
						&& 0 < this.state.markers.length
						&& this.outputMarkers()}

	        <InfoWindow
		        marker={this.state.activeMarker}
	          visible={this.state.showingInfoWindow}>
            <div>
              <h3>{this.state.selectedPlace.name}</h3>
            </div>
	        </InfoWindow>
	      </Map>
			</div>
		)
	}

	ouputCenterMarker() {
		return (
			<Marker
	    	onClick={this.onMarkerClick.bind(this)}
	      name={this.props.centerMarker.name}
	      position={this.state.mapCenter}
	      icon={this.props.centerMarker.icon && {
	      	url: this.props.centerMarker.icon.url,
	      	anchor: new this.props.google.maps.Point(this.props.centerMarker.icon.width,this.props.centerMarker.icon.height),
					scaledSize: new this.props.google.maps.Size(this.props.centerMarker.icon.width,this.props.centerMarker.icon.height),
	      }} />
	  )
	}

	outputMarkers() {
		return this.state.markers.map((marker, index) => {
  		return (
	  		<Marker
	  			key={index}
		    	name={marker.name}
		      position={marker.geometry.location}
		      icon={{
		      	url: marker.icon,
		      }} />
	  	)
  	})
	}

	onMarkerClick(props, marker, e) {
    this.setState({
      selectedPlace: props,
      activeMarker: marker,
      showingInfoWindow: true
    })
	}

  onMapClick(props) {
    if (this.state.showingInfoWindow) {
      this.setState({
        showingInfoWindow: false,
        activeMarker: null
      })
    }
  }

  onCategoryClick() {
  	this.nearbySearch()
  }

  setMapCenterFromProps() {
  	// check if we have lat and lng already
  	const _center = Object.keys(this.props.center);
		if (2 === _center.length
			&& -1 !== _center.indexOf('lat')
			&& -1 !== _center.indexOf('lng')) {
			this.updateMapCenter({
				lat: this.props.center.lat,
				lng: this.props.center.lng
			})
		}
		// we dont have lat and lng, let's try to get them
		else {
			this.geocode(this.props.center)
		}
  }

  // pass a lat and lng object
  updateMapCenter(center) {
		this.setState({
			mapCenter: center,
		})
  }

  geocode(place) {
  	place = place || null

  	if (!place) {
  		return;
  	}

  	if (!this.geocoder) {
  		this.geocoder = new this.props.google.maps.Geocoder();
  	}

		const address = {'address': place}
  	this.geocoder.geocode(address, (results, status) => {
			if ('OK' === status) {
				this.updateMapCenter({
					lat: results[0].geometry.location.lat(),
					lng: results[0].geometry.location.lng(),
				})
			}
	  })
  }

  nearbySearch(keyword) {
  	if (!this.map) {
  		return
  	}

  	if (!this.placesServices) {
  		this.placesServices = new this.props.google.maps.places.PlacesService(this.map)
  	}

  	this.placesServices.nearbySearch({
  		keyword: keyword,
			location: this.state.mapCenter,
			radius: 8000,
		},
		(results, status, pagination) => {
			if ('OK' === status
				&& 0 < results.length) {
  			this.setState({markers: results})
  			if (this.props.onNearbySearch
  				&& 'function' === typeof this.props.onNearbySearch) {
  				this.props.onNearbySearch(results, this.state.mapCenter)
  			}
			}
		})
  }
}

export default GoogleApiWrapper(
  (props) => ({
    apiKey: props.apiKey,
  }
))(TorqueMap)