import React from 'react'
import { Map, InfoWindow, Marker, GoogleApiWrapper } from 'google-maps-react'
import style from './Map.scss'
import MapShape from './Shape'

import Geocode from '../Geocode/Geocode'

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
    this.placesServices = null
  }

  componentWillMount() {
    this.setMapCenterFromProps()
  }

  componentDidUpdate(prevProps) {
    // Typical usage (don't forget to compare props):
    if (this.props.searchNearby !== prevProps.searchNearby) {
      this.nearbySearch(this.props.searchNearby)
    }
  }

  onMarkerClick(props, marker, e) {
    this.setState({
      selectedPlace: props,
      activeMarker: marker,
      showingInfoWindow: true,
    })
  }

  onMapClick(props) {
    if (this.state.showingInfoWindow) {
      this.setState({
        showingInfoWindow: false,
        activeMarker: null,
      })
    }
  }

  // pass a lat and lng object
  updateMapCenter(center) {
    this.setState({
      mapCenter: center,
    })
  }

  renderCenterMarker() {
    return (
      <Marker
        onClick={this.onMarkerClick.bind(this)}
        name={this.props.centerMarker.name}
        position={this.state.mapCenter}
        icon={
          this.props.centerMarker.icon && {
            url: this.props.centerMarker.icon.url,
            anchor: new this.props.google.maps.Point(
              this.props.centerMarker.icon.width,
              this.props.centerMarker.icon.height
            ),
            scaledSize: new this.props.google.maps.Size(
              this.props.centerMarker.icon.width,
              this.props.centerMarker.icon.height
            ),
          }
        }
      />
    )
  }

  renderMarkers() {
    return this.state.markers.map((marker, index) => {
      return (
        <Marker
          key={index}
          name={marker.name}
          position={marker.geometry.location}
          icon={{
            url: this.props.markersIcon
              ? this.props.markersIcon.url
              : marker.icon,
            anchor: new this.props.google.maps.Point(39, 54),
            size: new google.maps.Size(39, 54),
            scaledSize: new google.maps.Size(39, 54),
          }}
        />
      )
    })
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
          ref={mapObject => (this.map = mapObject && mapObject.map)}>
          {this.props.center &&
            this.props.centerMarker &&
            this.renderCenterMarker()}

          {this.state.markers &&
            0 < this.state.markers.length &&
            this.renderMarkers()}

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

  setMapCenterFromProps() {
    if (!this.props.center) {
      return
    }

    if (!this.props.center.lat
    	|| !this.props.center.lng) {
    	this.geocode()
    } else {
      this.updateMapCenter(this.props.center)
    }
  }

  async geocode() {
    const geoClient = new Geocode();
    const coordinates = await geoClient.geocode({address:this.props.center})
    this.updateMapCenter(coordinates)
  }

  nearbySearch(keyword) {
    if (!this.map) {
      return
    }

    if (!this.placesServices) {
      this.placesServices = new this.props.google.maps.places.PlacesService(
        this.map
      )
    }

    this.placesServices.nearbySearch(
      {
        keyword: keyword,
        location: this.state.mapCenter,
        radius: 8000,
      },
      this.doneWithNearbySearch.bind(this)
    )
  }

  doneWithNearbySearch(results, status, pagination) {
    if ('OK' === status && 0 < results.length) {
      this.setState({ markers: results })
      if (
        this.props.onNearbySearch &&
        'function' === typeof this.props.onNearbySearch
      ) {
        this.props.onNearbySearch(results, this.state.mapCenter)
      }
    }
  }
}

export default GoogleApiWrapper(props => ({
  apiKey: props.apiKey,
}))(TorqueMap)
