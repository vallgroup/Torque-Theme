import React, { useState, useEffect, useRef } from "react";
import { Map, InfoWindow, Marker, GoogleApiWrapper } from "google-maps-react";
import { arrEmpty } from "../helpers";
import InfoWindowEx from "./InfoWindowEx";
import { InfoBox_1 } from "../components/InfoBox";

const MapView = ({ apiKey, posts, mapOptions, loopTemplate, mapWrapperRef }) => {
  // states
  const [markers, setMarkers] = useState([]);
  const [bounds, setBounds] = useState(new google.maps.LatLngBounds());
  const [selectedPlace, setSelectedPlace] = useState({});
  const [activeMarker, setActiveMarker] = useState({});
  const [showingInfoWindow, setShowingInfoWindow] = useState(false);
  const [showingInfoBox, setShowingInfoBox] = useState(false);
  const [mapCenter, setMapCenter] = useState(mapOptions.map_center);
  const [mapZoom, setMapZoom] = useState(parseInt(mapOptions.map_zoom_archive) || 12);
  const [mapStyles, setMapStyles] = useState(mapOptions.map_styles && JSON.parse(mapOptions.map_styles));
  const [markerIcon, setMarkerIcon] = useState(mapOptions.marker_icon);

  const mapContainerRef = useRef(null);
  const infoWindowContainerRef = useRef(null);

  const pinSize = mapOptions.pin_size ? mapOptions.pin_size.split(",").map( Number ) : [39,54]

  useEffect(() => {

    // format each post as a marker, and define bounds array for auto center feature
    if (posts && !arrEmpty(posts)) {
      const newMarkers = [];
      var points = new google.maps.LatLngBounds();

      posts.forEach((post, idx) => {
        newMarkers.push({
          'name': post?.post_name,
          'icon': markerIcon,
          'geometry': {
            'location': post?.acf?.latitude_longitude || false,
          },
          'post': post,
        })

        if (post && post.acf && post.acf.latitude_longitude) {
          let boundsLatLng = post.acf.latitude_longitude
          if ( typeof post.acf.latitude_longitude === 'string' ) {
            boundsLatLng = JSON.parse(post.acf.latitude_longitude)
          }
          points.extend({ lat: parseFloat(boundsLatLng.lat), lng: parseFloat(boundsLatLng.lng) })
        }

      });
      setMarkers(newMarkers)
      setBounds(points)
      handleMapReset()
    }
  }, [posts]);

  const onMarkerClick = (marker) => {
    // set the active marker
    setActiveMarker(marker)
    // show the info window
    setShowingInfoWindow(true)
    // hide the info box
    setShowingInfoBox(false)
    // remove the toggle class from parent wrapper
    mapWrapperRef.current.classList.remove('info-box-open')
  }

  const showInfoBox = () => {
    if (showingInfoBox) {
      // hide the info box
      setShowingInfoBox(false)
      // remove the toggle class from parent wrapper
      mapWrapperRef.current.classList.remove('info-box-open')
    } else {
      // show the info box
      setShowingInfoBox(true)
      // add the toggle class from parent wrapper
      mapWrapperRef.current.classList.add('info-box-open')
    }
  }

  const onInfoWindowClose = () => {
    if (showingInfoWindow) {
      // reset active marker
      setActiveMarker(null)
      // hide info window
      setShowingInfoWindow(false)
      // hide info box
      setShowingInfoBox(false)
      // remove the toggle class from parent wrapper
      mapWrapperRef.current.classList.remove('info-box-open')
    }
  }

  const handleMapReset = () => {
      // reset active marker
      setActiveMarker(null)
      // hide info window
      setShowingInfoWindow(false)
      // hide info box
      setShowingInfoBox(false)
  }

  const renderMarkers = () => {
    // console.log('renderMarkers()', markers)
    return markers.map((marker, index) => {

      // determine if this post is of type 'Retail'
      let isRetail = false;
      marker.post.terms.forEach(term => {
        if (
          'newcastle_property_type' === term.taxonomy
          && 'Retail' === term.name
        ) {
          isRetail = true;
          return;
        }
      });

      // early exit, if template-5 and not a retail marker
      if (
        'template-5' === loopTemplate
        && !isRetail
      ) return null;

      return (
        (marker.geometry.location)
          && <Marker
            key={index}
            name={marker.name}
            marker={marker}
            onClick={() => onMarkerClick(marker)}
            position={marker.geometry.location}
            icon={{
              url: markerIcon,
              anchor: new google.maps.Point(pinSize[0] / 2, pinSize[1]),
              size: new google.maps.Size(pinSize[0], pinSize[1]),
              scaledSize: new google.maps.Size(pinSize[0], pinSize[1])
            }}
          />
      );
    });
  }

  const renderInfoWindow = () => {
    if (activeMarker) {
      // display a marker
      return (<div className={`infowindow`}>
        <div>
          <h3 className={'title'}>{activeMarker.post?.post_title || ''}</h3>
          <h5 className={'address'}>
            {activeMarker.post?.acf?.street_address || ''}<br/>
            {activeMarker.post?.acf?.city || ''}, {activeMarker.post?.acf?.state || ''} {activeMarker.post?.acf?.zip_code || ''}
          </h5>
          <div
            className={`cta ${showingInfoBox ? 'opened' : ''}`}
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

  if (!apiKey || !mapCenter) return null;

  return (
    <div className={'map-container'} >
      <Map
        google={google}
        zoom={mapZoom}
        initialCenter={{
          lat: parseFloat(mapCenter.lat),
          lng: parseFloat(mapCenter.lng)
        }}
        bounds={bounds}
        styles={mapStyles}
      >

        {markers && !arrEmpty(markers)
          && renderMarkers()}

        {/* NOTE: required, because the Google Maps library we're using doesn't allow for
          links in the InfoWindow component content, therefore we render a new div via React
          and send props through */}
        {/* SEE: https://stackoverflow.com/questions/53615413/how-to-add-a-button-in-infowindow-with-google-maps-react */}
        <InfoWindowEx
          visible={showingInfoWindow}
          position={activeMarker?.geometry?.location
            ? {
              lat: parseFloat(activeMarker.geometry.location.lat),
              lng: parseFloat(activeMarker.geometry.location.lng)
            }
            : {
              lat: parseFloat(mapCenter.lat),
              lng: parseFloat(mapCenter.lng)
            }}
          onClose={() => onInfoWindowClose()}
        >
          {renderInfoWindow()}
        </InfoWindowEx>

      </Map>

    {showingInfoBox
      && activeMarker
      && <InfoBox_1 post={activeMarker.post} />}
  </div>);
};

export default GoogleApiWrapper(props => ({
  apiKey: props.apiKey
}))(MapView);
