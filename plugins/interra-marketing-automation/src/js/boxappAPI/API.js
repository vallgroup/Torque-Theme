/**
 * API class to interact with the BoxApp Database.
 *
 *
 * NOTE: THIS IS DEPRECATED,
 *       USE index.js AND OTHER CLIENT FILES
 */

// ensure that the base64 module is available
window.btoa = require('Base64').btoa;

class API {

  constructor() {

    this.panoURL    = 'https://api.boxapp.io/wp-json/boxapp/v1/pano/';
    this.navBtnURL  = 'https://api.boxapp.io/wp-json/boxapp/v1/update-nav-button/';
    this.tooltipURL = 'https://api.boxapp.io/wp-json/boxapp/v1/update-tooltip/';
    this.mediaURL   = 'https://api.boxapp.io/wp-json/wp/v2/media/';
    this.panoCollectionURL = 'https://api.boxapp.io/wp-json/wp/v2/posts/';

    // this.authentication = btoa('mario:pw.true?1:0;');
    // console.log(this.authentication)
    // this.auth = this.authentication;
  }

  saveAuthentication( base64auth ) {
    this.authentication = base64auth;
  }

  login( username, password ) {
    // TODO: func not ready needs to login user
    // once logged in, save authentication
    this.saveAuthentication( this.createBase64Auth(username + ':' + password) );
  }

  createBase64Auth( username, password ) {
    return btoa(username + ':' + password)
  }

  /**
   * return the current user id
   *
   * @return {int} the user id as an integer
   */
  getUserId() {
    return 1;
  }

  /**
   * Provided the pano ID, this function retrieves a pano from the database.
   * All panos are public so no need to check user permissions here.
   *
   * @param  {int}     panoId the id for the pano to load
   * @return {promise}        resolves to the pano object
   */
  async getPano( panoId ) {
    const url = this.panoURL+panoId;
    try {
      let response = await fetch(url);
      let responseJson = await response.json();
      if ( responseJson.pano_id ) {

        return responseJson;
      }
    } catch (error) {
      throw new Error('There was an error getting the pano. -- ' + error.message)
    }
  }

  async getUserPanos() {
    const url = this.panoCollectionURL+'?perpage=999&author='+this.getUserId();

    try {
      let response = await fetch(url);
      let responseJson = await response.json();

      return responseJson;
    } catch (error) {
      throw new Error('There was an error getting the pano. -- ' + error.message)
    }
  }

  /**
   * create or edit a pano. If id is 0 a new pano is created. If id is greater than 0 the pano is updated. To make changes to a pano we must check user permissions.
   *
   * @param  {object} pano the pano object with the new data
   * @return {object}      returns a promise that resolves to an object.
   */
  newPano( pano ) {
    const url  = 'https://api.boxapp.io/wp-json/boxapp/v1/new-pano/'
    const data = new FormData();
    // build data from options
    for ( var i in pano ) {
      if ( 'pano_media' === i
        && Array.isArray(pano[i]) ) {
        for (var m = 0; m < pano[i].length; m++) {

          data.append( pano[i][m].name, pano[i][m] );
        }
      } else {
        pano.hasOwnProperty( i )
          && data.append( i, pano[i] )
      }
    }

    return fetch(url, {
      method: 'post',
      headers: {
        'Authorization': 'Basic ' + this.authentication,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: data,
    })
    .then(response => {
      return response.json()
    })
  }

  async updatePano( pano, media ) {
    const url = this.parseURLRequest( this.panoURL, pano)
    const options = this.getPostRequestOptions(media);
    try {
      let response = await fetch(url, options);
      let responseJson = await response.json();

      return responseJson;
    } catch (error) {
      throw new Error('There was an error updating the pano. -- ' + error.message)
    }
  }

  /**
   * delete a pano from the datbase. We need to check for user permissions here.
   * @param  {[type]} panoId [description]
   * @return {[type]}        [description]
   */
  deletePano( panoId ) {
    const url  = 'https://api.boxapp.io/wp-json/wp/v2/posts/'+panoId

    return fetch(url, {
      method: 'delete',
      headers: {
        'Authorization': 'Basic ' + this.authentication,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
    })
    .then(response => {
      return response.json()
    })
  }

  getTooltipsForLocation( locationID ) {
    return fetch('https://api.boxapp.io/wp-json/wp/v2/posts/'+locationID)
    .then(response => {
      return response.json()
      .then(json => {
        return json
          && json.meta
          && json.meta.tooltips
          && 0 < json.meta.tooltips.length
          && json.meta.tooltips
      })
    })
  }

  async deleteTooltip( args ) {
    const url = this.parseURLRequest( this.tooltipURL, args )
    const options = this.getDeleteRequestOptions()

    try {
      let response = await fetch(url, options);
      let responseJson = await response.json();

      return responseJson;
    } catch (error) {
      throw new Error('There was an error deleting the tooltip. -- ' + error.message)
    }
  }

  async getPanoList() {
    const url = this.parseURLRequest( this.panoCollectionURL, {
      _embed: true,
      per_page: 100,
    });
    try {
      let response = await fetch(url);
      let responseJson = await response.json();

      return responseJson;
    } catch (error) {
      throw new Error('There was an error get the pano list. -- ' + error.message)
    }
  }

  async updateTooltip( tooltip, media ) {
    const url = this.parseURLRequest( this.tooltipURL, tooltip )
    const options = this.getPostRequestOptions(media)

    try {
      let response = await fetch(url, options);
      let responseJson = await response.json();

      return responseJson;
    } catch (error) {
      throw new Error('There was an error updating the tooltip. -- ' + error.message)
    }
  }

  async updateNavButton( button ) {
    const url = this.parseURLRequest( this.navBtnURL, button )
    const options = this.getPostRequestOptions()

    try {
      let response = await fetch(url, options);
      let responseJson = await response.json();

      return responseJson;
    } catch (error) {
      throw new Error('There was an error updating the nav button. -- ' + error.message)
    }
  }

  async deleteNavButton( args ) {
    const url = this.parseURLRequest( this.navBtnURL, args )
    const options = this.getDeleteRequestOptions()

    try {
      let response = await fetch(url, options);
      let responseJson = await response.json();

      return responseJson;
    } catch (error) {
      throw new Error('There was an error deleting the Nav Button. -- ' + error.message)
    }
  }

  async getMedia( mediaId ) {
    if ( 0 === mediaId || 0 === mediaId.length )
      throw new Error('Invalid media id.')

    const id = Array.isArray( mediaId )
      ? '?include='+mediaId.join(',')
      : mediaId
    const url = this.mediaURL + id

    try {
      let response = await fetch(url);
      let responseJson = await response.json();

      if ( responseJson.source_url ) {
        // if the source_url exists, then we received one image
        return {
          uri: responseJson.source_url,
        }
      } else {
        // we assume that multiple images were returned
        const order = [
          'right',
          'left',
          'top',
          'bottom',
          'front',
          'back',
        ];
        let orderedMedia = [];
        // make sure images are ordered properly
        for (var m = 0; m < responseJson.length; m++) {
          const _index = order.indexOf(responseJson[m].title.rendered.trim().toLowerCase())
          if ( -1 !== _index ) {
            orderedMedia[ _index ] = {uri: responseJson[m].source_url}
          }
        }
        // console.log( orderedMedia )
        return orderedMedia
      }
    } catch (error) {
      throw new Error('There was an error getting the media. -- ' + error.message)
    }
  }

  parseURLRequest( url, options ) {
    let _url  = url + '?'
    // build data from options
    _url += this.optionsToURLParams( options )
    return _url.substr(0, (_url.length -1));
  }

  optionsToURLParams( options ) {
    let _params = '';
    for ( var i in options ) {
      if ( options.hasOwnProperty( i ) ) {
        _params += i + '=' + options[i] + '&'
      }
    }
    return _params;
  }

  getPostRequestOptions(media) {
    media = media || {}
    // empty JSON prevents errors
    let _body = JSON.stringify(media)

    if ( 0 !== Object.keys(media).length ) {
      _body = new FormData();
      for ( var i in media ) {
        if ( media.hasOwnProperty( i ) ) {
          _body.append( i, media[i] )
        }
      }
    }

    const options = {
      method: 'POST',
      headers: {
        Authorization: 'Basic ' + this.authentication,
        Accept: 'application/json',
        'Content-Type': 'application/json'
      },
      body: _body,
    }
    return options;
  }

  getDeleteRequestOptions() {
    const options = {
      method: 'DELETE',
      headers: {
        Authorization: 'Basic ' + this.authentication,
        Accept: 'application/json',
        'Content-Type': 'application/json'
      },
      // empty JSON prevents errors
      body: JSON.stringify({}),
    }
    return options;
  }
}

export default new API();
