export const getCurrDate = () => {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();
  return yyyy + '-' + mm + '-' + dd;
}

/**
 * Converts a date string by separator, optionally removing leading zeros.
 * 
 * @param {string} dateStr 
 * @param {string} separator 
 * @param {boolean} removeleadingZeros 
 */
export const formatDate = (dateStr, separator, removeleadingZeros = false) => {
  // early exit
  if ('' == dateStr || '' == separator) return false;
  // explode string
  var datePart = dateStr.split(separator);
  var year = datePart[0].substring(0, 4);
  var month = removeleadingZeros
    ? +datePart[1]
    : datePart[1];
  var day = removeleadingZeros
    ? +datePart[2]
    : datePart[2];

  return month + '/' + day + '/' + year;
}