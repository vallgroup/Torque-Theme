export function isEmpty (obj) {
  return ( 0 === Object.keys(obj).length && Object === obj.constructor ) || obj === null || obj === undefined;
}

/**
 * Helper to sort object alphabetically by a key
 * 
 * @param {object} data : object to sort
 * @param {string} attr : object key to sort by
 * returns an object
 */
export function sortObjectOfObjectsAlphabetically (data, attr) {
  // create array of sortable properties
  var arr = [];
  for (var prop in data) {
      if (data.hasOwnProperty(prop)) {
          var obj = {};
          obj[prop] = data[prop];
          obj.tempSortName = data[prop][attr].toLowerCase();
          arr.push(obj);
      }
  }
  // sort array
  arr.sort(function(a, b) {
      var at = a.tempSortName,
          bt = b.tempSortName;
      return at > bt ? 1 : ( at < bt ? -1 : 0 );
  });
  // filter object and return
  var result = [];
  for (var i=0, l=arr.length; i<l; i++) {
      var obj = arr[i];
      delete obj.tempSortName;
      for (var prop in obj) {
          if (obj.hasOwnProperty(prop)) {
              var id = prop;
          }
      }
      var item = obj[id];
      result.push(item);
  }
  return result;
}