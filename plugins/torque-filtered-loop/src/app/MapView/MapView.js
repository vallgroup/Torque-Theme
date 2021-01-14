import React, { useState, useEffect, useRef } from "react";
import { Map, InfoWindow, Marker, GoogleApiWrapper } from "google-maps-react";
import { arrEmpty } from "../helpers";
import InfoWindowEx from "./InfoWindowEx";
import { InfoBox_1 } from "../components/InfoBox";

const MapView = ({ apiKey, posts, mapOptions }) => {
  // states
  const [markers, setMarkers] = useState([]);
  const [selectedPlace, setSelectedPlace] = useState({});
  const [activeMarker, setActiveMarker] = useState({});
  const [showingInfoWindow, setShowingInfoWindow] = useState(false);
  const [showingInfoBox, setShowingInfoBox] = useState(false);
  const [mapCenter, setMapCenter] = useState(mapOptions.map_center);
  const [mapZoom, setMapZoom] = useState(parseInt(mapOptions.map_zoom));
  const [mapStyles, setMapStyles] = useState(mapOptions.map_styles && JSON.parse(mapOptions.map_styles));
  const [markerIcon, setMarkerIcon] = useState(mapOptions.marker_icon);

  const infoWindowContainerRef = useRef(null);

  useEffect(() => {
    // format each post as a marker
    if (posts && !arrEmpty(posts)) {
      const newMarkers = [];
      posts.forEach((post, idx) => {
        newMarkers.push({
          'name': post?.post_name,
          'icon': markerIcon,
          'geometry': {
            'location': post?.acf?.latitude_longitude || false,
          },
          'post': post,
        })
      });
      setMarkers(newMarkers)
    }
  }, [posts]);

  const onMarkerClick = (marker) => {
    console.log('onMarkerClick()')
    setActiveMarker(marker)
    setShowingInfoWindow(true)
    setShowingInfoBox(false)
  }

  const showInfoBox = () => {
    console.log('showInfoBox()')
    setShowingInfoBox(true)
  }

  const onMapClick = () => {
    console.log('onMapClick()')
    if (showingInfoWindow) {
      setActiveMarker(null)
      setShowingInfoWindow(false)
      setShowingInfoBox(false)
    }
  }

  const renderMarkers = () => {
    // console.log('renderMarkers()', markers)
    return markers.map((marker, index) => {
      return (
        marker.geometry.location
          && <Marker
            key={index}
            name={marker.name}
            onClick={() => onMarkerClick(marker)}
            position={marker.geometry.location}
            icon={{
              url: markerIcon,
              anchor: new google.maps.Point(39 / 2, 54),
              size: new google.maps.Size(39, 54),
              scaledSize: new google.maps.Size(39, 54)
            }}
          />
      );
    });
  }

  const renderInfoWindow = () => {
    console.log('renderInfoWindow()')
    if (activeMarker) {
      // display a marker
      return (<div className={`infowindow`}>
        <div>
          <h3 className={'title'}>{activeMarker.post?.post_name || ''}</h3>
          <h5 className={'address'}>
            {activeMarker.post?.acf?.street_address || ''}<br/>
            {activeMarker.post?.acf?.city || ''}, {activeMarker.post?.acf?.state || ''} {activeMarker.post?.acf?.zip_code || ''}
          </h5>
          <div 
            className={`cta ${showingInfoBox ? 'selected' : ''}`}
            onClick={() => showInfoBox()}
          >
            {'View Details'}
          </div>
        </div>
      </div>);
    } else {
      return <div></div>;
    }
  }

  // console.log('---')
  // console.log('activeMarker', activeMarker ? activeMarker.name : activeMarker)
  // console.log('showingInfoWindow', showingInfoWindow)
  // console.log('showingInfoBox', showingInfoBox)
  // console.log('---')

  return (<div 
    className={'map-container'}
    onClick={() => onMapClick()}
  >
    <Map
      google={google}
      zoom={mapZoom}
      initialCenter={mapCenter}
      styles={mapStyles}
    >
        
      {markers && !arrEmpty(markers)
        && renderMarkers()}

      {/* not showing infowindow or infobox */}
      {/* <InfoWindowEx
        visible={showingInfoWindow}
        marker={activeMarker}
        onClose={() => onMapClick()}
      >
        {renderInfoWindow()}
      </InfoWindowEx> */}

      {/* showing infowindow, but not infobox */}
      {/* {activeMarker
        && <InfoWindowEx
          visible={showingInfoWindow}
          position={activeMarker?.geometry?.location || mapCenter}
          onClose={() => onMapClick()}
        >
          {renderInfoWindow()}
        </InfoWindowEx>} */}

      {/* not showing infowindow or infobox */}
      {/* <InfoWindow
        marker={activeMarker}
        visible={showingInfoWindow}
        // position={activeMarker?.geometry?.location || mapCenter}
        // onClose={() => onMapClick()}
      >
        {renderInfoWindow()}
      </InfoWindow> */}

      {/* showing infowindow, but not infobox */}
      {activeMarker
        && <InfoWindow
          visible={showingInfoWindow}
          position={activeMarker?.geometry?.location || mapCenter}
          onClose={() => onMapClick()}
          // these aren't built into the google-maps-react library...
          // options={{
          //   enableEventPropagation: true
          // }}
        >
          {renderInfoWindow()}
        </InfoWindow>}

    </Map>

    {showingInfoBox
      && activeMarker
      && <InfoBox_1 post={activeMarker.post} />}
  </div>);
};

export default GoogleApiWrapper(props => ({
  apiKey: props.apiKey
}))(MapView);
