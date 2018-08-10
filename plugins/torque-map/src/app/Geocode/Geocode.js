

export default class Geocode {

	// static geocoder = null;

	constructor() {

	  if (!this.geocoder) {
	    this.geocoder = new google.maps.Geocoder()
	  }

	  this.params = {}
	}

	geocode(params) {
		// if no params exit
	  if (!params) {
	    return
	  }
	  // return if the required properties are not
	  // present in the params object
	  if (!params.address && !params.components) {
	  	return
	  }
	  // save our params to the class
	  this.params = params;
	  // build and return our Premise
	  const response = new Promise(this.handleGeocodePromise.bind(this))
	  return response
	}

	handleGeocodePromise(resolve, reject) {
		// do geocode
	  this.geocoder.geocode(this.params, (results, status) => {
	  	// successful, resove the promise
	    if ('OK' === status) {
	    	// pass the lat and lng coordinates
	      resolve({
	        lat: results[0].geometry.location.lat(),
	        lng: results[0].geometry.location.lng(),
	      })
	    }
	    // else, reject it
	    reject(null)
	  })
  }
}