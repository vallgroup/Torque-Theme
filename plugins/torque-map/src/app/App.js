import React, { Component } from 'react'
import TorqueMap from './Map/Map'
import PointsOfInterest from './PointsOfInterest/PointsOfInterest'
import ListPOIS from './PointsOfInterest/ListPOIS'

const pois = [{
	name: 'Dinner',
	keyword: 'dinner',
},{
	name: 'Drinks',
	keyword: 'drinks',
},{
	name: 'Shopping',
	keyword: 'shopping',
},{
	name: 'Entertainament',
	keyword: 'entertainment',
}];

class App extends Component {
	constructor(props) {
		super(props)

		this.state = {
			searchNearby: '',
			mapCenter: null,
		}
	}

  render() {
    return (<div className={`torque-map`}>
	    <PointsOfInterest
	    	pois={pois}
	    	updatePOIS={this.updatePOIS.bind(this)} />

  		{/*Display the map*/}
	    <TorqueMap
	    	apiKey={`AIzaSyDPF2QsUSJKHsmGoPcjIgRySglSZgD-asA`}
	    	center={'905 Fulton Market Chicago, IL'}
	    	centerMarker={{
	    		name: '905 Fulton Market',
		    	icon: {
		    		url: 'http://localhost:8000/wp-content/uploads/2018/08/905-location-pin@2x.png',
		    		width: 69,
		    		height: 92,
		    	}
	    	}}
	    	searchNearby={this.state.searchNearby}
	    	onNearbySearch={this.updatePOIList.bind(this)} />

	    <ListPOIS
	    	list={this.state.poiList}
	    	showDistanceFrom={this.state.mapCenter} />
    </div>)
  }

  updatePOIS(keyword) {
  	console.log(keyword)
  	this.setState({
  		searchNearby: keyword,
  	})
  }

  updatePOIList(list, mapCenter) {
  	console.log(list)
  	this.setState({
  		poiList: list,
  		mapCenter: mapCenter
  	})
  }
}

export default App
