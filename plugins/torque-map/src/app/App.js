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

const markerIcons = {
	dinner: {
		url: 'http://localhost:8000/wp-content/uploads/2018/08/dinner-pin@2x.png',
	},
	drinks: {
		url: 'http://localhost:8000/wp-content/uploads/2018/08/drinks-pin@2x.png',
	},
	shopping: {
		url: 'http://localhost:8000/wp-content/uploads/2018/08/shopping-pin@2x.png',
	},
	entertainment: {
		url: 'http://localhost:8000/wp-content/uploads/2018/08/entertainment-pin@2x.png',
	}
}

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
	    	onNearbySearch={this.updatePOIList.bind(this)}
	    	markersIcon={markerIcons[this.state.searchNearby]} />

	    <ListPOIS
	    	list={this.state.poiList}
	    	showDistanceFrom={this.state.mapCenter} />
    </div>)
  }

  updatePOIS(keyword) {
  	this.setState({
  		searchNearby: keyword,
  	})
  }

  updatePOIList(list, mapCenter) {
  	this.setState({
  		poiList: list,
  		mapCenter: mapCenter
  	})
  }
}

export default App
