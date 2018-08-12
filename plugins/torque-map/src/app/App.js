import React, { Component } from 'react'
import axios from 'axios'
import TorqueMap from './Map/Map'
import PointsOfInterest from './PointsOfInterest/PointsOfInterest'
import ListPOIS from './PointsOfInterest/ListPOIS'

/**
 * I'm guessing we'll eventually want to generalise and have these things
 * set from the back end? We can rely on the pin images being in the media gallery
 */
class App extends Component {
  constructor(props) {
    super(props)

    this.state = {
      apiKey: '',
      map: null,
      pois: [],
      selectedPOI: {},
      poiList: [],
      displayPOIList: false,
      mapCenter: null,
    }
  }

  componentWillMount() {
    this.getTheMapDetails()
  }

  render() {
    return (
      <div className={`torque-map`}>
        {/* if we have points of interest, show them */}
        {0 < this.state.pois.length
          && <PointsOfInterest
            pois={this.state.pois}
            searchNearby={this.state.selectedPOI.keyword}
            updatePOIS={this.updatePOIS.bind(this)} />}

        {/* Display the map when we have a map in state */}
        {this.state.map
          && <TorqueMap
            apiKey={this.state.apiKey}
            center={this.state.map.center}
            centerMarker={{
              name: this.state.map.title,
              icon: this.state.map.center_marker,
            }}
            searchNearby={this.state.selectedPOI.keyword}
            onNearbySearch={this.updatePOIList.bind(this)}
            markersIcon={this.state.selectedPOI.marker} />}

        {/* Display the poi list if we have one */}
        {this.state.displayPOIList
          && 0 < this.state.poiList.length
          && <ListPOIS
            list={this.state.poiList}
            showDistanceFrom={this.state.mapCenter} />}
      </div>
    )
  }

  getTheMapDetails() {
    if (this.props.mapID) {
      this.ajaxMapDetails();
    }
  }

  async ajaxMapDetails() {
    try {
      const url = this.props.site + `/wp-json/torque-map/v1/map/${this.props.mapID}`
      const mapPost = await axios.get(url)
      if (mapPost.data.success) {
        this.setState({
          apiKey: mapPost.data.api_key,
          map: mapPost.data.map_details,
          pois: mapPost.data.pois,
          displayPOIList: mapPost.data.display_poi_list,
        })
      }
    } catch(err) {
      console.error(err)
    }
  }

  updatePOIS(poi) {
    this.setState({
      selectedPOI: poi,
    })
  }

  updatePOIList(list, mapCenter) {
    this.setState({
      poiList: list,
      mapCenter: mapCenter,
    })
  }
}

export default App
