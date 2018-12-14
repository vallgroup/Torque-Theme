import React, { Component } from "react";
import axios from "axios";
import TorqueMap from "./Map/Map";
import PointsOfInterest from "./PointsOfInterest/PointsOfInterest";
import ListPOIS from "./PointsOfInterest/ListPOIS";

/**
 * I'm guessing we'll eventually want to generalise and have these things
 * set from the back end? We can rely on the pin images being in the media gallery
 */
class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      apiKey: "",
      map: null,
      pois: [],
      selectedPOI: {},
      selectedPOIIcon: {},
      poiList: [],
      poisTitle: "",
      poisLocation: "",
      displayPOIList: false,
      mapCenter: null
    };
  }

  componentWillMount() {
    this.getTheMapDetails();
  }

  render() {
    return (
      <div className={`torque-map`}>
        {/* if we have points of interest
        & the poisLocation is not equal to bottom, show them */}
        {0 < this.state.poisLocation.length &&
          "middle" !== this.state.poisLocation &&
          "bottom" !== this.state.poisLocation &&
          this.showPOIs()}

        {/* Display the map when we have a map in state */}
        {this.state.map && (
          <TorqueMap
            apiKey={this.state.apiKey}
            center={this.state.map.center}
            zoom={this.state.map.zoom}
            centerMarker={{
              name: this.state.map.title,
              icon: this.state.map.center_marker
            }}
            searchNearby={this.state.selectedPOI.keyword}
            onNearbySearch={this.updatePOIList.bind(this)}
            markersIcon={this.state.selectedPOIIcon}
          />
        )}

        {/* Display the poisLocation below the map but above pois */}
        {"middle" === this.state.poisLocation && this.showPOIs()}

        {/* Display the poi list if we have one */}
        {this.state.displayPOIList &&
          0 < this.state.poiList.length && (
            <ListPOIS
              list={this.state.poiList}
              showDistanceFrom={this.state.mapCenter}
            />
          )}

        {/* Display the poisLocation below the map */}
        {"bottom" === this.state.poisLocation && this.showPOIs()}
      </div>
    );
  }

  showPOIs() {
    return (
      0 < this.state.pois.length && (
        <PointsOfInterest
          pois={this.state.pois}
          poisTitle={this.state.poisTitle}
          location={this.state.poisLocation}
          searchNearby={this.state.selectedPOI.keyword}
          updatePOIS={this.updatePOIS.bind(this)}
        />
      )
    );
  }

  getTheMapDetails() {
    if (this.props.mapID) {
      this.ajaxMapDetails();
    } else {
      this.setState({
        apiKey: this.props.apiKey,
        map: {
          center: this.props.center,
          zoom: this.props.zoom,
          title: this.props.title
        }
      });
    }
  }

  async ajaxMapDetails() {
    try {
      const url =
        this.props.site + `/wp-json/torque-map/v1/map/${this.props.mapID}`;
      const mapPost = await axios.get(url);
      console.log(mapPost.data);
      if (mapPost.data.success) {
        this.setState({
          apiKey: mapPost.data.api_key,
          map: mapPost.data.map_details,
          pois: mapPost.data.pois,
          poisTitle: mapPost.data.pois_title,
          poisLocation: mapPost.data.pois_location,
          displayPOIList: mapPost.data.display_poi_list
        });
      }
    } catch (err) {
      console.error(err);
    }
  }

  updatePOIS(poi) {
    this.setState({
      selectedPOI: poi
    });
  }

  updatePOIList(list, mapCenter) {
    this.setState(({ selectedPOI }) => {
      return {
        poiList: list,
        mapCenter: mapCenter,
        // update the icon here rather than when clicking the new POI,
        // so the icon doesnt change before the network request completes
        selectedPOIIcon: selectedPOI.marker
      };
    });
  }
}

export default App;
