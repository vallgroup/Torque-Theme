import React, {useState, useEffect} from "react";
import axios from 'axios';
import {arrEmpty} from '../../helpers';
import LoadingIcon from '../LoadingIcon';
import Opening from '../Opening';

const RecruiterBox = ({apiKeys, apiFilters}) => {
  // states
  const [isLoading, setIsLoading] = useState(false);
  const [apiCalled, setApiCalled] = useState(false);
  const [openings, setOpenings] = useState([]);
  // vars
  const rbApiUrl = 'https://jsapi.recruiterbox.com/v1/openings';

  useEffect(() => {
    // set loading
    setIsLoading(true);
    // fetch openings
    buildOpenings();
    // set loading and api called
    setApiCalled(true);
    setIsLoading(false);
  },[]);

  const buildOpenings = () => {
    let _clientOpenings = [];
    !arrEmpty(apiKeys) && apiKeys.forEach((secret) => {
      if (secret.client_name && '' !== secret.client_name) {
        try {
          const _clientFilters = secret.filter_data ? apiFilters : {};
          const _response = axios.get(rbApiUrl, {
            params: {
              'client_name': secret.client_name,
              ..._clientFilters
            }
          });

          if (!arrEmpty(_response?.data?.objects)) {
            _clientOpenings.push(_response.data.objects);
          }
          // _clientOpenings.push(
          //   {
          //     "id": "a42f3",
          //     "title": "UX - Engineer",
          //     "description": "UX - Engineer",
          //     "location": {
          //       "city": "San Jose",
          //       "state": "CA",
          //       "country": "USA"
          //     },
          //     "tags": ["Dev","UX"],
          //     "hosted_url": "https://demoaccount.recruiterbox.com/jobs/ad3e",
          //     "allows_remote": true,
          //     "position_type": "contract",
          //     "team": "FrontEnd Engineers",
          //     "close_date": 1513445073
          //   },
          //   {
          //     "id": "a4d2f3",
          //     "title": "Product Engineer",
          //     "description": "Frontend Engineer",
          //     "location": {
          //       "city": "Chicago",
          //       "state": "IL",
          //       "country": "USA"
          //     },
          //     "tags": ["Dev","UX"],
          //     "hosted_url": "https://demoaccount.recruiterbox.com/jobs/ad3e",
          //     "allows_remote": true,
          //     "position_type": "contract",
          //     "team": "FrontEnd Engineers",
          //     "close_date": 1513445073
          //   },
          //   {
          //     "id": "a42af3",
          //     "title": "Senior Product Engineer",
          //     "description": "Frontend Engineer",
          //     "location": {
          //       "city": "Chicago",
          //       "state": "IL",
          //       "country": "USA"
          //     },
          //     "tags": ["Dev","UX"],
          //     "hosted_url": "https://demoaccount.recruiterbox.com/jobs/ad3e",
          //     "allows_remote": true,
          //     "position_type": "contract",
          //     "team": "FrontEnd Engineers",
          //     "close_date": 1513445073
          //   },
          //   {
          //     "id": "a42sdaf3",
          //     "title": "Mid Product Engineer",
          //     "description": "Frontend Engineer",
          //     "location": {
          //       "city": "Chicago",
          //       "state": "IL",
          //       "country": "USA"
          //     },
          //     "tags": ["Dev","UX"],
          //     "hosted_url": "https://demoaccount.recruiterbox.com/jobs/ad3e",
          //     "allows_remote": true,
          //     "position_type": "contract",
          //     "team": "FrontEnd Engineers",
          //     "close_date": 1513445073
          //   }
          // );
        } catch (error) {
          console.warn(error);
        }
      }
    });

    Promise.all(_clientOpenings)
      .then(_clientOpenings => {
        setOpenings(_clientOpenings)
      });
  }

  return isLoading ? 
    <LoadingIcon/> :
    apiCalled && !arrEmpty(openings) ?
    <div className={'openings-container'}>
      {openings.map((opening, idx) => {
        return <Opening
        key={idx}
        opening={opening}
        />
      })}
    </div> :
    'No current openings available.';
}

export default RecruiterBox
