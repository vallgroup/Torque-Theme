// @flow
import './axios/interceptors'

const ENV = 'dev'
const ORG = ''

const __appRoot = 'boxapp.localhost:3000'
const __apiRoot = 'boxapp.local'
const __360Root = 'vr.boxapp.localhost:8081/index.html'

const protocol = ('dev' === ENV)
    ? 'http://'
    : 'https://'

const domain = ('production' === ENV)
  ? 'boxapp.io'
  : __appRoot

const host = ('production' === ENV)
  ? `${protocol}api.boxapp.io`
  : `${protocol}${__apiRoot}`

const vrRoot = ('production' === ENV)
  ? `${protocol}vr.boxapp.io`
  : `${protocol}${__360Root}`

if ('production' !== ENV) {console.log('Environment: ', ENV)}

/**
 * API class to interact with the BoxApp Database.
 */

type RequestHeaders = {
  Authorization?: string,
  Accept?: string,
  'Content-Type'?: string
}

type API = {
  host: string,
  protocol: string,
  domain: string,
  vrRoot: string,
  customAPIRoot: string,
  wpAPIRoot: string,
  worldURL: string,
  navBtnCollectionURL: string,
  tooltipCollectionURL: string,
  mediaURL: string,
  usersURL: string,
  wpUsersURL: string,
  currentUserURL: string,
  contactsURL: string,
  pagesURL: string,
  catsURL: string,
  followURL: string,
  worldCollectionURL: string,
  parseURLRequest: (url: string, options: {}) => string,
  getAuthorizedGetRequestHeaders: (base64Auth: string) => RequestHeaders,
  getPostRequestHeaders: (base64Auth: string) => RequestHeaders,
  getPutRequestHeaders: (base64Auth: string) => RequestHeaders,
  getDeleteRequestHeaders: (base64Auth: string) => RequestHeaders,
  prepareMediaForPost: (data: {}) => FormData
};

function getAuthorizedGetRequestHeaders (base64Auth: string): RequestHeaders {
  return {
    Authorization: `Basic ${base64Auth}`
  }
}

function getPostRequestHeaders (base64Auth: string): RequestHeaders {
  return {
    Authorization: `Basic ${base64Auth}`,
    Accept: 'application/json',
    'Content-Type': 'multipart/form-data'
    // 'Content-Type': 'application/json',
    // 'X-Content-Type-Options': 'nosniff'
  }
}

function getPutRequestHeaders (base64Auth: string): RequestHeaders {
  return {
    Authorization: `Basic ${base64Auth}`,
    Accept: 'application/json',
    'Content-Type': 'multipart/form-data'
  }
}

function getDeleteRequestHeaders (base64Auth: string): RequestHeaders {
  return {
    Authorization: `Basic ${base64Auth}`
  }
}

function prepareMediaForPost (mediaObj: {}, key: string, name: string): FormData {
  let _body = new FormData()
  _body.append(key, mediaObj)
  return _body
}

function optionsToURLParams (options: { [string]: string | number }): string {
  let _params = ''
  for (var i in options) {
    if (options.hasOwnProperty(i)) {
      // check for empty Arrays
      if (Array.isArray(options[i])
        && 0 === options[i].length) {
        continue;
      }
      _params += i + '=' + encodeURIComponent(options[i]) + '&'
    }
  }
  return _params
}

function parseURLRequest (
  url: string,
  options: { [string]: string | number }
): string {
  let _url = url + '?'
  // build data from options
  _url += optionsToURLParams(options)
  return _url.substr(0, _url.length - 1)
}

function buildFormDateFromObject(object) {
  object = object || {}
  let data = new FormData()

  for (var i in object) {
    if (object.hasOwnProperty(i)) {
      data.append(i, object[i])
    }
  }

  return data
}

function updateOrgUrl(path) {
  if ('undefined' === typeof path) return
  this.org = path.replace(/\//g, '')
  this.host = ('' !== this.org) ? `${host}/${this.org}` : host
  this.updateVRRootForOrg(this.org)
  this.resetUrls()
}

function updateVRRootForOrg(path) {
  let _vrRoot = this.vrRoot

  if ('' !== path) {
    if (-1 !== _vrRoot.indexOf('?')) {
      // we already have a param, clear it
      _vrRoot = _vrRoot.slice(0, _vrRoot.indexOf('?'))
      _vrRoot += `?org=${path}`
    } else {
      _vrRoot += `?org=${path}`
    }
  } else {
    _vrRoot = vrRoot;
  }
  this.vrRoot = _vrRoot
}

function getVRURL(worldID) {
  if (-1 !== this.vrRoot.indexOf('?')) {
    return `${this.vrRoot}&worldID=${worldID}`
  } else {
    return `${this.vrRoot}?worldID=${worldID}`
  }
}

function init(orgName) {
  orgName = orgName || ''
  this.updateOrgUrl(orgName)
}

function getOrgBackendUrl(org, namespace) {
  if ('undefined' === typeof org) return
  const name = org.path.replace(/\//g, '')
  const orgURL = ('' !== name)
    ? `${host}/${name}/wp-json`
    : `${host}/wp-json`
  return ('wp' === namespace)
    ? `${orgURL}/wp/v2/`
    : `${orgURL}/boxapp/v1/`
}

function getOrgIdFromOrgName(name, orgs) {
  if ('' === name) {
    return 1
  }

  let orgId = 0
  for (const i in orgs) {
    const orgName = orgs[i].path.replace(/\//g, '')
    if (orgName === name) {
      orgId = orgs[i].userblog_id
      return orgId
    }
  }

  return orgId
}

function getOrgNameFromOrgId(id, orgs) {
  if (!id) {
    return ''
  }

  return orgs[id].path.replace(/\//g, '')
}

function getOrgbyName(name, orgs) {
  if ('' === name) {
    return null
  }

  let __org = {}
  for (const i in orgs) {
    const orgName = orgs[i].path.replace(/\//g, '')
    if (orgName === name) {
      __org = orgs[i]
      return __org
    }
  }

  return __org
}

function getDynamicUrl(org) {
  org = org || ''
  const _subdomain = ('' !== org)
    ? org+'.'
    : ''

  return `${this.protocol}${_subdomain}${this.domain}`
}

function isOrg() {
  return this.org !== ''
}

// resets urls from this.host
function resetUrls() {
  this.customAPIRoot = `${this.host}/wp-json/boxapp/v1`
  this.wpAPIRoot = `${this.host}/wp-json/wp/v2`
  this.worldCollectionURL = `${this.customAPIRoot}/worlds/`
  this.navBtnCollectionURL = `${this.customAPIRoot}/nav-buttons/`
  this.tooltipCollectionURL = `${this.customAPIRoot}/tooltips/`
  this.objectsCollectionURL = `${this.customAPIRoot}/objects/`
  this.lightsCollectionURL = `${this.customAPIRoot}/lights/`
  this.wpUsersURL = `${this.wpAPIRoot}/users`
  this.mediaURL = `${this.wpAPIRoot}/media/`
  this.usersURL = `${this.customAPIRoot}/users`
  this.currentUserURL = `${this.wpAPIRoot}/users/me/`
  this.contactsURL = `${this.customAPIRoot}/contacts/`
  this.pagesURL = `${this.wpAPIRoot}/pages/`
  this.catsURL = `${this.wpAPIRoot}/categories/`
  this.followURL = `${this.usersURL}/follow/`
  this.orgURL = `${this.customAPIRoot}/org/`
  this.advancedSettingsURL = `${this.customAPIRoot}/advanced-settings/`
}

const api: API = {
  ENV,
  protocol,
  domain,
  host,
  vrRoot,
  parseURLRequest,
  getAuthorizedGetRequestHeaders,
  getPostRequestHeaders,
  getPutRequestHeaders,
  getDeleteRequestHeaders,
  prepareMediaForPost,
  buildFormDateFromObject,
  updateOrgUrl,
  resetUrls,
  updateVRRootForOrg,
  getVRURL,
  init,
  getOrgIdFromOrgName,
  getOrgNameFromOrgId,
  getOrgbyName,
  getDynamicUrl,
  getOrgBackendUrl,
  isOrg
}

api.init(ORG)

export default api
