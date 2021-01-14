import React, { memo, useEffect, useRef } from "react";
import ReactDOM from "react-dom";
import { InfoWindow } from "google-maps-react";

// original example from: https://stackoverflow.com/questions/53615413/how-to-add-a-button-in-infowindow-with-google-maps-react

// export default function InfoWindowEx(props) {
//   const infoWindowRef = React.createRef();
//   const contentElement = document.createElement('div');
//   useEffect(() => {
//     ReactDOM.render(React.Children.only(props.children), contentElement);
//     infoWindowRef.current.infowindow.setContent(contentElement);
//   }, [props.children]);
//   return <InfoWindow ref={infoWindowRef} {...props} />;
// }

const InfoWindowEx = (props) => {
  const infoWindowRef = useRef();
  const contentElement = document.createElement("div");
  useEffect(() => {
    console.log('InfoWindowEx props', props)
    ReactDOM.render(React.Children.only(props.children), contentElement);
    infoWindowRef.current.infowindow.setContent(contentElement);
  }, [props.children]);
  return <InfoWindow ref={infoWindowRef} {...props} />;
}

export default memo(InfoWindowEx);
