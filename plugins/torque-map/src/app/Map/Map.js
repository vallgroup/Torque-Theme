import React from 'react'
import {Map, InfoWindow, Marker, GoogleApiWrapper} from 'google-maps-react'
import style from './Map.scss'

export class TorqueMap extends React.Component {

	constructor(props) {
		super(props)

		this.state = {
			selectedPlace: {},
      activeMarker: {},
      showingInfoWindow: false
		}
	}

	render() {
		console.log( style )
		return (
			<div
				onClick={this.onMapClick.bind(this)}
				className={style.torqueMap}>

				<Map
					google={this.props.google}
					zoom={14}>

	        <Marker
	        	onClick={this.onMarkerClick.bind(this)}
	          name={'Current location'} />

	        <InfoWindow
		        marker={this.state.activeMarker}
	          visible={this.state.showingInfoWindow}>
            <div>
              <h1>{this.state.selectedPlace.name}</h1>
            </div>
	        </InfoWindow>
	      </Map>
			</div>
		)
	}

	onMarkerClick(props, marker, e) {
		console.log( 'marker clicked' )
    this.setState({
      selectedPlace: props,
      activeMarker: marker,
      showingInfoWindow: true
    })
	}

  onMapClick(props) {
  	console.log( 'map clicked' )
    if (this.state.showingInfoWindow) {
      this.setState({
        showingInfoWindow: false,
        activeMarker: null
      })
    }
  }
}

export default GoogleApiWrapper(
  (props) => ({
    apiKey: props.apiKey,
  }
))(TorqueMap)