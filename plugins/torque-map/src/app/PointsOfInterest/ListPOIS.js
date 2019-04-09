import React from "react";
import axios from "axios";

export default class ListPOIS extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      list: []
    };
  }

  componentDidMount() {
    this.initListState();
  }

  componentDidUpdate(prevProps) {
    if (this.props.list !== prevProps.list) {
      this.initListState();
    }
  }

  render() {
    return (
      <div className={`torque-map-pois-list`}>
        {this.state.list &&
          0 < this.state.list.length &&
          this.state.list
          .sort(this.sortByDistance.bind(this))
          .map((poi, index) => {
            return (
              <div key={index} className={`torque-map-pois-list-item`}>
                <div className={`torque-map-pois-list-item-name`}>
                  {poi.name}
                </div>

                {/* show distance from,
								if showDistanceFrom prop is present */}
                {this.props.showDistanceFrom && (
                  <div className={`torque-map-pois-list-item-distance`}>
                    {poi.distance}
                  </div>
                )}
              </div>
            );
          })}
      </div>
    );
  }

  sortByDistance(a, b) {

    if (!a.distance || !b.distance) {
      return 0;
    }

    const distanceA = parseFloat(a.distance.replace(/[^0-9\.]/g, ''))
    const distanceB = parseFloat(b.distance.replace(/[^0-9\.]/g, ''))

    if (distanceA < distanceB) {
      return -1
    }
    if (distanceA > distanceB) {
      return 1
    }
    return 0
  }

  initListState() {
    if (!this.props.list) {
      return;
    }

    const destinations = this.props.list.map(poi => {
      return poi.geometry.location; //new google.maps.LatLng(lat,lng)
    });
// console.log(destinations)

    let destinationChunks = [];
    const chunkSize = 20;
    for (var i=0; i < destinations.length; i += chunkSize) {
      destinationChunks = [...destinationChunks, destinations.slice(i,i+chunkSize)]
    }

    if (this.props.showDistanceFrom) {
      destinationChunks.forEach(chunk => this.getDistances(this.props.showDistanceFrom, chunk));
    }

    this.setState({
      list: this.props.list
    });
  }

  getDistances(origin, destinations) {
    var service = new google.maps.DistanceMatrixService();
    return service.getDistanceMatrix(
      {
        origins: [new google.maps.LatLng(origin.lat, origin.lng)],
        destinations: destinations,
        unitSystem: google.maps.UnitSystem.IMPERIAL,
        travelMode: "DRIVING"
        // transitOptions: TransitOptions,
        // drivingOptions: DrivingOptions,
        // avoidHighways: Boolean,
        // avoidTolls: Boolean,
      },
      (resp, status) => {
        console.log(resp, status)
        if ("OK" !== status) {
          console.log(destinations)
          return;
        }
        if ("OK" === status
          && resp
          && resp.rows
          && 0 < resp.rows.length) {
          let destinations = this.state.list;
          for (var i = 0; i < resp.rows[0].elements.length; i++) {
            destinations[i].distance = resp.rows[0].elements[i].distance.text;
          }

          this.setState({
            list: destinations
          });
        }
      }
    );
  }
}
