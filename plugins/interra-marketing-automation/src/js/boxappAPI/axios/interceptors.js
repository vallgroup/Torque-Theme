import axios from 'axios'
import BoxAppValidation from './validations'
import {BoxAppAPIException} from '../exceptions/api_exceptions'

/**
 * takes the request from axios and validates the data being sent.
 *
 * @param  {Object} the config for the axios request
 * @return {Object} the config with data validated
 */
const requestSuccessful = (config) => {
  // console.log(config)
  if (!config.data || 'undefined' === typeof config.data) {
    return config;
  }

  config.data = BoxAppValidation.validateFormData(config.data)
  // console.log(config)
  return config;
}

// TODO: still needs logic
const requestUnsuccessful = (error) => {
  if (true !== (error instanceof BoxAppAPIException)) {
    // not a boxapp exception
    console.log(error)
  }
  // Do something with request error
  return Promise.reject(error);
}


const responseSuccessful = (response) => {
  // console.log(response)
  // if response came back from the server
  // but it is not successful treat as an exception
  if (false === response.data.success) {
    throw new BoxAppAPIException(response)
  }
  return response;
}


const responseUnsuccessful = (error) => {
  console.log(error)
  // only report back errors that are not already caught
  // if the error is an instance of BoxAppAPIException
  // it means that it was already caught
  if (true !== (error instanceof BoxAppAPIException)) {

    if (error.message) {
    console.log(error.message)
      throw new BoxAppAPIException(error.message)
    }

    if (error.response) {
      console.log(error.response)
      // still not sure how to report these
      // throw new BoxAppAPIException()
    }

    if (error.system) {
      console.log(error.system)
      // still not sure how to report these
      // throw new BoxAppAPIException()
    }

    if (error.request) {
      console.log(error.request)
      // still not sure how to report these
      // throw new BoxAppAPIException()
    }
  }

  return Promise.reject(error);
}

// Add a request interceptor
axios.interceptors.request.use(
  requestSuccessful,
  requestUnsuccessful
);

// Add a response interceptor
axios.interceptors.response.use(
  responseSuccessful,
  responseUnsuccessful
);