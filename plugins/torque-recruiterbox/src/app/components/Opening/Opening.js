import React from "react";
import {objEmpty} from '../../helpers'

const Opening = ({opening}) => {
  // vars
  const _url = opening.hosted_url;
  const _title = opening.title;
  const _address = `${opening.location.city}, ${opening.location.state}, ${opening.location.country}`;
  
  return !objEmpty(opening) ?
    <div className={'opening-container'}>
      <a
        className={'opening-wrapper'}
        href={_url || ''}
        target={'_blank'}
        rel={'noopener noreferrer'}
      >
        <span className={'opening-title'}>{_title}</span>
        <span className={'opening-address'}>{_address}</span>
      </a>
    </div> : 
    null;
}

export default Opening
