import React, { useState, useEffect } from "react";
import { Map, InfoWindow, Marker, GoogleApiWrapper } from "google-maps-react";
import { arrEmpty } from "../helpers";
import axios from "axios";

const MapView = ({ apiKey, posts }) => {
  const [activePost, setActivePost] = useState({});
  const [showingInfoWindow, setShowingInfoWindow] = useState(false);
  const [markers, setMarkers] = useState(posts || []);

  useEffect(() => {
    const newMarkers = [...markers];

    !arrEmpty(markers) && markers.map((marker, index) => {
      newMarkers[index].location = getLatLong(marker);
    });

    setMarkers(newMarkers);
  }, [])

  const onMarkerClick = (marker) => {
    setActivePost(marker)
    setShowingInfoWindow(false)
  }

  const onMapClick = () => {
    if (showingInfoWindow) {
      setActivePost({})
      setShowingInfoWindow(false)
    }
  }

  const getLatLong = async (marker) => {
    const address = marker && marker.acf
      ? marker.acf.street_address 
        + '+' + marker.acf.city
        + '+' + marker.acf.state
        + '+' + marker.acf.zip_code
      : false

    if (!address) return;

    try {
      const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${apiKey}`;
      const response = await axios.get(url);

      if (response && !arrEmpty(response?.data?.results)) {
        console.log('latLong', response?.data?.results[0].geometry.location)
        return response?.data?.results[0]?.geometry?.location;
      } else {
        return false;
      }
    } catch (err) {
      console.error(err);
    }
  }

  const renderMarkers = () => {
    return markers.map((marker, index) => {
      // todo:
      // - convert address to lat/long
      // - pull icon from server
      // - determine what 'marker' is
      // - ...?

      console.log('marker', marker)

      return (
        marker.location
          && <Marker
            key={index}
            name={marker.post_name}
            // marker={marker}
            onClick={() => onMarkerClick()}
            position={marker.location}
            icon={{
              url: 'http://localhost:8000/wp-content/uploads/2020/12/1200-px-saic-logo-svg-1-copy.png',
              // url: markersIcon && markersIcon.url
              //   ? markersIcon.url
              //   : marker.thumbnail,
              anchor: new google.maps.Point(39 / 2, 54),
              size: new google.maps.Size(39, 54),
              scaledSize: new google.maps.Size(39, 54)
            }}
          />
      );
    });
  }

  const renderDynamicInfowindow = () => {
    // if a post is active
    if (activePost) {
      // display a marker
      const name = activePost.post_name;
      const address = activePost.post_name;
      return (<div className={`torque-map-infowindow`}>
        <div>
          <h3>{name}</h3>
          <h5>{name}</h5>
          <div className={'button'}>View Details</div>
        </div>
      </div>);
    }
    // return an empty div
    return (<div></div>);
  }

  return (
    <Map
      google={google}
      zoom={12}
      onClick={() => onMapClick()}
      // todo get map centre from server
      center={{lat: 41.8781, lng: -87.6298}}
      // styles={this.props.styles}
    >
      {markers && !arrEmpty(markers)
        && renderMarkers()}

      <InfoWindow
        marker={activePost}
        visible={showingInfoWindow}
      >
        {renderDynamicInfowindow()}
      </InfoWindow>
    </Map>
  );
};

export default GoogleApiWrapper(props => ({
  apiKey: props.apiKey
}))(MapView);
