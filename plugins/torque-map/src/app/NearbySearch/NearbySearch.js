export default class NearbySearch {
  // static geocoder = null;

  constructor(map) {
    if (!this.placesServices) {
      this.placesServices = new google.maps.places.PlacesService(map);
    }

    this.params = {};
  }

  search(params) {
    if (!params) {
      return;
    }

    this.params = params;

    const response = new Promise(this.handleSearchPromise.bind(this));
    return response;
  }

  handleSearchPromise(resolve, reject) {
    // do search
    this.placesServices.nearbySearch(
      this.params,
      (results, status, pagination) => {
        // if 0 results
        if ("ZERO_RESULTS" === status) {
          resolve(results);
        }
        // if succesful resolve promise
        if ("OK" === status && 0 < results.length) {
          resolve(results);
        }
        // else, reject it
        reject(null);
      }
    );
  }
}
