import React from "react";
import {objEmpty} from '../../helpers'

const Opening = ({opening}) => {
  // vars
  //const _url = opening.absolute_url;
  const _title = opening.title;
  const _address = opening.location.name;

  function handleClick(e) {
    if (spectra) {
      spectra.logEvent('job_application');
    }
  }

  const urlWithParams = new URL(window.location.origin + '/job-details');
  urlWithParams.searchParams.append('board', opening.board);
  urlWithParams.searchParams.append('jobid', opening.id);

  const labelLocation = opening.location.name.replace(/\s+/g, '-').replace(',', '').toLowerCase();
  const labelTitle = opening.title.replace(/\s+/g, '-').toLowerCase();

  return !objEmpty(opening) ?
    <div className={'opening-container'}>
      <a
        className={'opening-wrapper'}
        href={urlWithParams || ''}
        target={'_self'}
        rel={'noopener noreferrer'}
        onClick={handleClick}
        id={`${labelLocation}__${labelTitle}`}
      >
        <span className={'opening-title'}>{_title}</span>
        <span className={'opening-address'}>{_address}</span>
      </a>
    </div> :
    null;
}

export default Opening
