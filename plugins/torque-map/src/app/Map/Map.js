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
    this.searchClient = null;
  }

  componentWillMount() {
    this.setMapCenterFromProps();
    '' !== this.props.searchNearby
      && this.nearbySearch();
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
        isCenter={true}
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
          name={marker.name}
          marker={marker}
          onClick={this.onMarkerClick.bind(this)}
          position={marker.geometry.location}
          icon={{
            url: this.props.markersIcon && this.props.markersIcon.url
              ? this.props.markersIcon.url
              : marker.icon,
            anchor: new this.props.google.maps.Point(39 / 2, 54),
            size: new google.maps.Size(39, 54),
            scaledSize: new google.maps.Size(39, 54)
          }}
        />
      );
    });
  }

  renderDynamicInfowindow() {
    // if a mareker is clicked on and it is the center marker
    if (this.state.selectedPlace
      && this.state.selectedPlace.isCenter) {
      // check if we have a dynamic infowindow set
      // from the backend
      if (this.props.centerMarker && this.props.centerMarker.icon
        && "" !== this.props.centerMarker.icon.infowindow) {
        // we have an infowindow from the backend!
        return (<div
          className={`torque-map-dynamic-infowindow`}
          dangerouslySetInnerHTML={{
            __html: this.props.centerMarker.icon.infowindow
          }}
        />)
      } else {
        // we do NOT have an infowindow from the backend
        return (<div
          className={`torque-map-infowindow`}
        >
          <h3>{this.state.selectedPlace.name}</h3>
        </div>)
      }
    } else {
      if (this.state.activeMarker
        && this.state.activeMarker.marker) {
        // display a marker
        const infowindow = this.state.activeMarker.marker
        return (<div className={`torque-map-infowindow`}>
          <div>
            <h3>{infowindow.name}</h3>
            <p>{infowindow.vicinity}</p>
            {infowindow.opening_hours
              && <p>
                {infowindow.opening_hours.open_now
                  ? <b>Open</b>
                  : <b>closed</b>}
              </p>}
          </div>
        </div>)
      }
    }
    // return an empty div
    return (<div></div>);
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
            {this.renderDynamicInfowindow()}
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

  nearbySearch() {

    if (!(this.map.current && this.map.current.map)) {
      return;
    }

    if (!this.props.searchNearby
      || 0 === this.props.searchNearby.length) {
      return;
    }

    this.setState({
      markers: [],
      markerIcon: null,
    });
    const keywords = this.props.searchNearby.split(',')
    if (!this.searchClient) this.searchClient = new NearbySearch(this.map.current.map);

    keywords.forEach((kWord, idx) => {
      this.doSearch(kWord)
    })
  }

  async doSearch(keyword) {
    const results = await this.searchClient.search({
      keyword: keyword,
      location: this.state.mapCenter,
      radius: 1000
    });

    if (results) {
      if (0 === results.length) {
        console.warn(`${keyword} did not return any results.`)
        return
      }

      let markers = [...this.state.markers, ...results]

      // add markers and call our callback
      this.setState({
        markers: markers,
        markerIcon: this.props.selectedPOIIcon
      });

      if (this.props.onNearbySearch
        && "function" === typeof this.props.onNearbySearch) {
        this.props.onNearbySearch(this.state.markers, this.state.mapCenter);
      }

    }
  }
}

export default GoogleApiWrapper(props => ({
  apiKey: props.apiKey
}))(TorqueMap);
