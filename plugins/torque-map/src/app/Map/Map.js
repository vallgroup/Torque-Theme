import React, { createRef } from "react";
import { Map, InfoWindow, Marker, GoogleApiWrapper } from "google-maps-react";
import style from "./Map.scss";
import MapShape from "./Shape";

import Geocode from "../Geocode/Geocode";
import NearbySearch from "../NearbySearch/NearbySearch";

export class TorqueMap extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      mapCenter: {}, // lat a& lng object
      selectedPlace: {},
      activeMarker: {},
      showingInfoWindow: false,
      markers: [],
      markerIcon: props.selectedPOIIcon
    };

    this.map = createRef();
    this.placesServices = null;
  }

  componentWillMount() {
    this.setMapCenterFromProps();
  }

  componentDidUpdate(prevProps, prevState) {
    // check if we have a new search term
    if (this.props.searchNearby !== prevProps.searchNearby) {
      // make sure we have the map and term before running the search
      if (this.map.current && this.props.searchNearby) {
        this.nearbySearch();
      }
    }
  }

  onMarkerClick(props, marker, e) {
    this.setState({
      selectedPlace: props,
      activeMarker: marker,
      showingInfoWindow: true
    });
  }

  onMapClick(props) {
    if (this.state.showingInfoWindow) {
      this.setState({
        showingInfoWindow: false,
        activeMarker: null
      });
    }
  }

  // pass a lat and lng object
  updateMapCenter(center) {
    this.setState({
      mapCenter: center
    });
  }

  renderCenterMarker() {
    return (
      <Marker
        onClick={this.onMarkerClick.bind(this)}
        name={this.props.centerMarker.name}
        position={this.state.mapCenter}
        zIndex={this.props.google.maps.Marker.MAX_ZINDEX + 1}
        icon={
          this.props.centerMarker.icon && {
            url: this.props.centerMarker.icon.url,
            anchor: new this.props.google.maps.Point(
              this.props.centerMarker.icon.width / 2,
              this.props.centerMarker.icon.height
            ),
            scaledSize: new this.props.google.maps.Size(
              this.props.centerMarker.icon.width,
              this.props.centerMarker.icon.height
            )
          }
        }
      />
    );
  }

  renderMarkers() {

    return this.state.markers.map((marker, index) => {
      return (
        <Marker
          key={index}
          onClick={this.onMarkerClick.bind(this)}
          name={marker.name}
          position={marker.geometry.location}
          icon={{
            url: this.props.markersIcon
              ? this.props.markersIcon.url
              : marker.icon,
            anchor: new this.props.google.maps.Point(39 / 2, 54),
            size: new google.maps.Size(39, 54),
            scaledSize: new google.maps.Size(39, 54)
          }}
          infowindow={this.getInfoWindowForMarker(marker)}
        />
      );
    });
  }

  getInfoWindowForMarker(marker) {
    const {
      name,
      distance,
      place_id,
      opening_hours,
      price_level,
      rating,
      user_ratings_total,
      vicinity,
      photos
    } = marker;

    const info = {
      name: name,
      distance: distance,
      placeID: place_id,
      openingHours: opening_hours,
      dollarSigns: price_level,
      rating: rating,
      reviews: user_ratings_total,
      vicinity: vicinity,
      photos: photos,
    }

    return info;
  }

  renderDynamicInfowindow() {

    if (this.state.selectedPlace
      && this.state.selectedPlace.infowindow) {
      const infowindow = this.state.selectedPlace.infowindow

      return (<div className={`torque-map-infowindow`}>
        <div>
          <h3>{infowindow.name}</h3>
          <p>{infowindow.vicinity}</p>
            {infowindow.openingHours
              && <p>
                {infowindow.openingHours.open_now
                  ? <b>Open</b>
                  : <b>closed</b>}
              </p>}

        </div>
      </div>)
    }

    if (this.props.centerMarker
      && this.props.centerMarker.icon
      && "" !== this.props.centerMarker.icon.infowindow) {
      return (<div
        className={`torque-map-dynamic-infowindow`}
        dangerouslySetInnerHTML={{
          __html: this.props.centerMarker.icon.infowindow
        }} />)
    }
  }

  render() {
    return (
      <div
        onClick={this.onMapClick.bind(this)}
        className={`torque-map-container ${style.torqueMap}`}
      >
        <Map
          google={this.props.google}
          zoom={+this.props.zoom || 12}
          center={this.state.mapCenter}
          ref={this.map}
          styles={this.props.styles}
        >
          {this.props.center &&
            this.props.centerMarker &&
            this.renderCenterMarker()}

          {this.state.markers &&
            0 < this.state.markers.length &&
            this.renderMarkers()}

          <InfoWindow
            marker={this.state.activeMarker}
            visible={this.state.showingInfoWindow}
          >
            <div>
              <h3>{this.state.selectedPlace.name}</h3>
            </div>
          </InfoWindow>
        </Map>
      </div>
    );
  }

  setMapCenterFromProps() {
    if (!this.props.center) {
      return;
    }

    if (!this.props.center.lat || !this.props.center.lng) {
      this.geocode();
    } else {
      this.updateMapCenter(this.props.center);
    }
  }

  async geocode() {
    const geoClient = new Geocode();
    const coordinates = await geoClient.geocode({ address: this.props.center });
    this.updateMapCenter(coordinates);
  }

  async nearbySearch() {

    if (!(this.map.current && this.map.current.map)) {
      return;
    }

    const searchClient = new NearbySearch(this.map.current.map);
    const results = await searchClient.search({
      keyword: this.props.searchNearby,
      location: this.state.mapCenter,
      radius: 1000
    });
    if (results) {
      if (0 === results.length) {
        alert('no results found')
      }
      // add markers and call our callback
      this.setState({
        markers: results,
        markerIcon: this.props.selectedPOIIcon
      });

      if (this.props.onNearbySearch
        && "function" === typeof this.props.onNearbySearch) {
        this.props.onNearbySearch(results, this.state.mapCenter);
      }
    } else {
      this.props.onNearbySearch([], this.state.mapCenter);
    }
  }
}

export default GoogleApiWrapper(props => ({
  apiKey: props.apiKey
}))(TorqueMap);
