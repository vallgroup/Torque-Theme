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
      map: null,
      pois: [],
      selectedPOI: {},
      searchNearby: '',
      mapCenter: null,
    }
  }

  componentWillMount() {
    this.getTheMapDetails()
  }

  render() {
    return (
      <div className={`torque-map`}>
        <PointsOfInterest
          pois={this.state.pois}
          searchNearby={this.state.selectedPOI.keyword}
          updatePOIS={this.updatePOIS.bind(this)} />

        {/*Display the map*/}
        {this.state.map
          &&
        <TorqueMap
          apiKey={`AIzaSyDPF2QsUSJKHsmGoPcjIgRySglSZgD-asA`}
          center={this.state.map.center}
          centerMarker={{
            name: this.state.map.title,
            icon: this.state.map.center_marker,
          }}
          searchNearby={this.state.selectedPOI.keyword}
          onNearbySearch={this.updatePOIList.bind(this)}
          markersIcon={this.state.selectedPOI.marker} />
        }

        <ListPOIS
          list={this.state.poiList}
          showDistanceFrom={this.state.mapCenter} />
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
          map: mapPost.data.map_details,
          pois: mapPost.data.pois,
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
