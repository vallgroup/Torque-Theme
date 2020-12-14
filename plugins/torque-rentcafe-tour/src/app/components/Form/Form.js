import React, { useRef, useState } from "react";
import { useForm } from "react-hook-form";
import axios from "axios";
import LoadingIcon from "../LoadingIcon";
import { 
  getCurrDate,
  objEmpty,
} from "../../helpers";
import {
  SuccessMessage,
  ErrorMessage
} from "./styles";
import { formConfig } from "./config";

const Form = () => {
  // states
  const [isLoading, setIsLoading] = useState(false);
  const [isError, setIsError] = useState(false);
  const [isSuccess, setIsSuccess] = useState(false);
  // form vars
  const { register, handleSubmit, watch, errors } = useForm();

  // handle form submission
  const onSubmit = (data) => {
    // base URL
    var _url = formConfig.apiURL;
    var _authData = formConfig.apiAuth;
    var _formData = data;
    
    // add auth params
    for (let i in _authData) {
      if (_authData.hasOwnProperty(i)) {
        _url += `${i}=${encodeURIComponent(_authData[i])}&`
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
    const _response = await axios.post(url)

    console.log('url', url)
    console.log('_response', _response)
    
    if ( 0 === _response.data.ErrorCode ) {
      setIsError(false)
      setIsSuccess(true)
    } else {
      setIsError(true)
      setIsSuccess(false)
    }

    setIsLoading(false)
  }

  const handleDateOnFocus = (e) => {
    e.target.type = 'date'
  }
  
  const handleDateOnBlur = (e) => {
    e.target.type = 'text'
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
        min={getCurrDate()} 
        placeholder="Desired Tour Date"
        className="width-50"
        required
        ref={register}
        disabled={isLoading}
      />
      <select 
        name="ApptTime"
        className="width-50"
        required
        ref={register}
        disabled={isLoading}
      >
        <option value="">Desired Tour Time</option>
        <option value="09:00am">9:00am</option>
        <option value="09:30am">9:30am</option>
        <option value="10:00am">10:00am</option>
        <option value="10:30am">10:30am</option>
        <option value="11:00am">11:00am</option>
        <option value="11:30am">11:30am</option>
        <option value="12:00pm">12:00pm</option>
        <option value="12:30pm">12:30pm</option>
        <option value="01:00pm">1:00pm</option>
        <option value="01:30pm">1:30pm</option>
        <option value="02:00pm">2:00pm</option>
        <option value="02:30pm">2:30pm</option>
        <option value="03:00pm">3:00pm</option>
        <option value="03:30pm">3:30pm</option>
        <option value="04:00pm">4:00pm</option>
        <option value="04:30pm">4:30pm</option>
        <option value="05:00pm">5:00pm</option>
        <option value="05:30pm">5:30pm</option>
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
  </>);
}

export default Form
