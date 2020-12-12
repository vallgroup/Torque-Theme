import React, { useState, useEffect } from "react";
import loadingIcon from "../../assets/images/loading_icon.png";
import { Spinner } from "./styles";

const LoadingIcon = () => {
  return (<Spinner 
    src={loadingIcon}
    alt='loading...'
    width='25px'
    height='25px'
  />);
}

export default LoadingIcon
