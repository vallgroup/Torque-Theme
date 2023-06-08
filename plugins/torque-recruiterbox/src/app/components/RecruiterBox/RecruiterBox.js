import React, {useState, useEffect} from "react";
import axios from 'axios';
import {arrEmpty} from '../../helpers';
import LoadingIcon from '../LoadingIcon';
import Opening from '../Opening';

const RecruiterBox = ({apiKeys, apiFilters}) => {
  // states
  const [isLoading, setIsLoading] = useState(false);
  const [isError, setIsError] = useState(false);
  const [hasOpenings, setHasOpenings] = useState();
  const [openings, setOpenings] = useState([]);
  // vars
  //const rbApiUrl = 'https://jsapi.recruiterbox.com/v1/openings';
  const rbApiUrl = 'https://boards-api.greenhouse.io/v1/boards';

  useEffect(() => {
    // set loading
    setIsLoading(true);
    // fetch openings
    buildOpenings();
    // set loading and api called
    setIsLoading(false);
  },[]);

  const buildOpenings = async () => {
    const _clientOpenings = [];

    !arrEmpty(apiKeys) && await Promise.all(apiKeys.map(async (secret, idx) => {
      if (secret.client_name && '' !== secret.client_name) {
        try {
          // fetch the openings
          const _response = await axios.get(`${rbApiUrl}/${secret.client_name}/jobs`, {
            params: {
              'content': false,
            }
          });

          // if openings available, add to client openings
          if (!arrEmpty(_response?.data?.jobs)) {
            const _jobs = _response.data.jobs;

            //apdd client name to each job
            _jobs.forEach(object => {
              object.board = secret.client_name;
            });

            _clientOpenings.push(..._jobs);
          }
          setIsError(false);
        } catch (error) {
          console.warn(error);
          setIsError(true);
        }
      }
    }));

    if (!arrEmpty(_clientOpenings)) {
      // save the openings
      setOpenings(_clientOpenings);
      setHasOpenings(true);
    } else {
      setHasOpenings(false);
    }
  }

  // early-exits
  if (isLoading) {
    return <LoadingIcon/>;
  } else if (isError) {
    return 'An error has occured. Please reload this page to try again.';
  } else if (false === hasOpenings) {
    return 'No current openings available.';
  }

  return (
    <div className={'openings-container'}>
      {openings.map((opening, idx) => (
        <Opening
          key={idx}
          opening={opening}
        />
      ))}
    </div>
  );
}

export default RecruiterBox
