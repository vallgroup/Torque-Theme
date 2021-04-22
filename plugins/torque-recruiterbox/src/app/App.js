import React, {useState, useEffect} from 'react';
import axios from 'axios';
import LoadingIcon from './components/LoadingIcon';
import RecruiterBox from './components/RecruiterBox';

const App = ({
  site,
  apiFilters
}) => {
  // states
  const [isLoading, setIsLoading] = useState(true);
  const [apiKeys, setApiKeys] = useState(null);

  // get API keys from WP
  useEffect(() => {
    getApiKeys();
  },[]);

  const getApiKeys = async () => {
    setIsLoading(true);

    // get API secrets
    try {
      const _response = await axios.get('http://localhost:8000/wp-json/torque-recruiterbox/v1/secrets/');
      
      if (_response?.data?.api_keys) {
        setApiKeys(_response.data.api_keys);
      }
    } catch (error) {
      console.warn(error);
    }

    setIsLoading(false);
  }

  return isLoading ?
    <LoadingIcon/> : 
    <RecruiterBox 
      apiKeys={apiKeys}
      apiFilters={apiFilters}
    />;
}

export default App
