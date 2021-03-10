/**
 * Helper used to merge two arrays and filter out all duplicates.
 * @param {array} array1 
 * @param {array} array2 
 * @returns a single, merged, filtered array without duplicates
 */
export const mergeAndRemoveDuplicates = (array1, array2) => {
  const merged = [...array1, ...array2];
  const filtered = merged.reduce((acc, current) => {
    const x = acc.find(item => item.id === current.id);
    if (!x) {
      return acc.concat([current]);
    } else {
      return acc;
    }
  }, []);
  return filtered;
}

/**
 * Helper used to merge two arrays and filter out all duplicates,
 *  based on an identical key within both arrays
 * @param {array} array1 
 * @param {array} array2 
 * @param {string} keyMatch
 * @returns a single, merged, filtered array without duplicates
 */
export const mergeAndRemoveDuplicatesByKey = (array1, array2, keyMatch) => {
  const merged = [...array1, ...array2];
  const filtered = merged.reduce((acc, current) => {
    const x = acc.find(item => item[keyMatch] === current[keyMatch]);
    if (!x) {
      return acc.concat([current]);
    } else {
      return acc;
    }
  }, []);
  return filtered;
}

/**
 * Determines if an array is empty, null or undefined.
 * Returns a boolean.
 * @param {array} arr 
 */
export const arrEmpty = (arr) => {
  if (
    'undefined' === typeof arr 
    || null === arr
  ) return true
  return (null === arr.length || 0 >= arr.length)
}

/**
 * Sorts an array by a given key value
 * @param {array} arr 
 * @param {string} key 
 */
export const sortArrayOfObjectsByKeyName = (arr, key) => {
  return [...arr].sort((a, b) => a[key].localeCompare(b[key], 'en', {'sensitivity': 'base'}));
}

/**
 * Searches an array for any instances of an item in a given array.
 * @param {item} array 
 * @param {string} item 
 */
export const arrayContains = (array, item) => {
  // early exit
  if (arrEmpty(array) || !item) return false

  const index = array.indexOf(item)
  return 0 <= index ? true : false
}

/**
 * Removes an item from an array, if the item exists
 * @param {array} array 
 * @param {string} item 
 */
export const removeArrayItem = (array, item) => {
  const index = array.indexOf(item)
  if (index !== -1) {
    array.splice(index, 1)
  }
  return array
}
