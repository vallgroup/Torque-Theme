export const objEmpty = (obj) => {
  // if null of undefined, it is as good as empty...
  if (null === obj || undefined === obj) return true
  // otherwise if is an object and object has 0 keys, it is empty...
  return 0 === Object.keys(obj).length && Object === obj.constructor
}

export const objCount = (obj) => {
  // if null of undefined, it is as good as empty...
  if (null === obj || undefined === obj || Object !== obj.constructor) return 0
  // otherwise if is an object and object has keys, return the number of keys
  return Object.keys(obj).length
}

export const objHasKey = (obj, key) => {
  return obj.hasOwnProperty(key)
}