export default function isEmpty(obj) {
  return ( 0 === Object.keys(obj).length && Object === obj.constructor ) || obj === null || obj === undefined;
}
