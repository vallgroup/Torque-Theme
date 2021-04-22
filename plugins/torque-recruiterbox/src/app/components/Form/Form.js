import React, { useRef, useState } from "react";
// import { useForm } from "react-hook-form";
import axios from "axios";
import LoadingIcon from "../LoadingIcon";
import { 
  getCurrDate,
  objEmpty,
  arrEmpty,
  formatDate,
  objHasKey
} from "../../helpers";
import {
  SuccessMessage,
  ErrorMessage
} from "./styles";
import { formConfig } from "./config";
import { strContains } from "../../helpers/strings";

const Form = ({ apiParams }) => {
  // general states
  const [isLoading, setIsLoading] = useState(false);
  // submissions states
  const [isError, setIsError] = useState(false);
  const [isSuccess, setIsSuccess] = useState(false);
  // availabilities states
  const [availabilities, setAvailabilities] = useState(false);
  const [isErrorAvailabilities, setIsErrorAvailabilities] = useState(false);
  // form vars
  const { register, handleSubmit, watch, errors } = useForm();
  // refs
  const apptDate = useRef();

  const handleDateOnFocus = (e) => {
    e.target.type = 'date'
  }
  
  const handleDateOnBlur = (e) => {
    e.target.type = 'text'
  }

  const handleDateChange = (e) => {
    // base URL
    var _url = formConfig.timesURL;
    var _dynamicApiParams = apiParams;
    
    // add dynamic auth params
    for (let i in _dynamicApiParams) {
      if (_dynamicApiParams.hasOwnProperty(i)) {
        _url += _dynamicApiParams[i]
          ? `${i}=${encodeURIComponent(_dynamicApiParams[i])}&` 
          : ``
      }
    }

    getAvailableTimesFromApi(_url);
  }

  const getAvailableTimesFromApi = async (url) => {
    setIsLoading(true);
    // send API request
    const _response = await axios.post(url);
    
    if ( 
      0 === _response.data.ErrorCode
      && !arrEmpty(_response.data.Response)
      && objHasKey(_response.data.Response[0], 'AvailableSlots')
      && !arrEmpty(_response.data.Response[0].AvailableSlots)
    ) {
      const _apptDate = formatDate(apptDate.current.value, '-', true);
      const _matchingDates = _response.data.Response[0].AvailableSlots.filter((availability, idx) => {
        return strContains(availability.dtStart, _apptDate);
      });
      if (!arrEmpty(_matchingDates)) {
        setAvailabilities(_matchingDates);
      } else {
        setAvailabilities([]);
      }
      setIsErrorAvailabilities(false);
    } else {
      setAvailabilities([]);
      setIsErrorAvailabilities(true);
    }

    setIsLoading(false)
  }

  // build select options based on availabilities state and apptDate ref
  const buildAvailabilityOptions = () => {
    // early exit
    if (arrEmpty(availabilities)) return null;

    // format appt date
    const _apptDate = apptDate.current
      ? formatDate(apptDate.current.value, '-', true)
      : null;

    // reset flag
    // setRebuildAvailabilities(false);

    // build options
    return availabilities.map((availability, idx) => {
        // format the availability time based on curr availabilities
        var _time = availability.dtStart.replace(':00 ', '').trim();
        // split string so we can remove the date from the avail.
        var _timeParts = _time.split(' ');
        // output the option
        return !arrEmpty(_timeParts)
          ? <option
            key={idx} 
            value={_timeParts[1]}
          >
            {_timeParts[1]}
          </option>
          : null;
      });
  }
  
  // handle form submission
  const onSubmit = (data) => {
    // base URL
    var _url = formConfig.apiURL;
    var _staticApiParams = formConfig.staticApiParams;
    var _dynamicApiParams = apiParams;
    var _formData = data;
    
    // add dynamic auth params
    for (let i in _dynamicApiParams) {
      if (_dynamicApiParams.hasOwnProperty(i)) {
        _url += _dynamicApiParams[i]
          ? `${i}=${encodeURIComponent(_dynamicApiParams[i])}&` 
          : ``
      }
    }
    
    // add static auth params
    for (let i in _staticApiParams) {
      if (_staticApiParams.hasOwnProperty(i)) {
        _url += `${i}=${encodeURIComponent(_staticApiParams[i])}&`
      }
    }
    
    // add data params
    for (let i in _formData) {
      if (_formData.hasOwnProperty(i)) {
        _url += `${i}=${encodeURIComponent(_formData[i])}&`
      }
    }

    submitToAPI(_url)
  }

  const submitToAPI = async (url) => {
    setIsLoading(true);
    // send API request
    const _response = await axios.post(url);
    
    if ( 0 === _response.data.ErrorCode ) {
      setIsError(false);
      setIsSuccess(true);
    } else {
      setIsError(true);
      setIsSuccess(false);
    }

    setIsLoading(false);
  }

  return (<>
    <form 
      onSubmit={handleSubmit(onSubmit)}
    >
      <input 
        type="text"
        name="ApptDate"
        onFocus={(e) => handleDateOnFocus(e)} 
        onBlur={(e) => handleDateOnBlur(e)}
        onChange={(e) => handleDateChange(e)}
        min={getCurrDate()} 
        placeholder="Desired Tour Date"
        className="width-50"
        required
        // ref={register}
        ref={(e) => {
          register(e);
          apptDate.current = e // you can still assign to ref
        }}
        disabled={isLoading}
      />
      <select 
        name="ApptTime"
        className="width-50"
        required
        ref={register}
        disabled={isLoading}
      >
        {false !== availabilities && arrEmpty(availabilities)
          ? <option value="">No Time Slots Available</option>
          : <option value="">Desired Tour Time</option>}
        {!arrEmpty(availabilities)
          && buildAvailabilityOptions()}
      </select>
      <input 
        type="text"
        name="FirstName"
        placeholder="First Name*"
        className="width-50"
        required
        ref={register}
        disabled={isLoading}
      />
      <input
        type="text"
        name="LastName"
        placeholder="Last Name*"
        className="width-50"
        required
        ref={register}
        disabled={isLoading}
      />
      <input
        type="email"
        name="Email"
        placeholder="Email*"
        className="width-50"
        required
        ref={register}
        disabled={isLoading}
      />
      <input
        type="text"
        name="Phone"
        placeholder="Phone"
        className="width-50"
        ref={register}
        disabled={isLoading}
      />
      <input 
        type="text"
        name="DesiredMoveInDate"
        onFocus={(e) => handleDateOnFocus(e)} 
        onBlur={(e) => handleDateOnBlur(e)} 
        min={getCurrDate()} 
        placeholder="Desired Move-in Date"
        className="width-50"
        required
        ref={register}
        disabled={isLoading}
      />
      <select 
        name="DesiredBedrooms"
        className="width-50"
        required
        ref={register}
        disabled={isLoading}
      >
        <option value="">Number of Bedrooms</option>
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
      </select>
      <textarea
        name="Message"
        placeholder="Message"
        rows="4"
        ref={register}
        disabled={isLoading}
      ></textarea>
      <input
        type="hidden"
        name="Source"
        value="website"
        ref={register}
        disabled={isLoading}
      />
      <input
        type="submit"
        value="Book My Tour"
        disabled={isLoading}
      />
      {isLoading
        && <LoadingIcon />}
    </form>
    {isError
      && <ErrorMessage className={'form-error'}>{'There was an error whilst sending your request. Please refresh the page and try again. If you continue to experience issues please contact us directly.'}</ErrorMessage>}
    {isSuccess
      && <SuccessMessage className={'form-success'}>{'Thanks for your request to schedule a tour!'}</SuccessMessage>}
    {isErrorAvailabilities
      && <ErrorMessage className={'form-error'}>{'We\'re having trouble retrieving the time slot availabilities. Please reload this page and try again.'}</ErrorMessage>}
  </>);
}

export default Form
