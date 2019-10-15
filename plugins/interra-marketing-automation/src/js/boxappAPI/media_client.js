// @flow
import type { AxiosPromise } from 'axios'
import type { Media } from '../src/flow-typed/media_types'
import axios from 'axios'
import api from './index'
import {BoxAppAPIException} from './exceptions/api_exceptions'

class MediaAPIClient {
  authentication: string

  constructor (base64Auth: string) {
    this.authentication = base64Auth
  }

  static createMediaName (prettyName, ext) {
    return prettyName
      .trim()
      .toLowerCase()
      .replace(/ /g, '-')
      .concat(Date.now().toString())
      .concat(`.${ext}`)
  }

  static async getMedia (mediaId: number): AxiosPromise<Media> {
    if (mediaId === 0) {
      throw BoxAppAPIException('Invalid media id.')
    }

    const url = `${api.mediaURL}${mediaId}`
    const response = await axios.get(url)

    return response.data
  }

  static getMediaArray (mediaIdArray: Array<number>): AxiosPromise<Array<Media>> {
    if (mediaIdArray.length === 0) {
      throw BoxAppAPIException('Empty media id array.')
    }

    const url = `${api.mediaURL}?include=${mediaIdArray.join(',')}`

    return axios.get(url)
  }

  static async getMediaFromOrg (mediaID: number, org: {}): AxiosPromise<Media> {
    if (mediaID === 0) {
      throw BoxAppAPIException('Invalid media id.')
    }

    if (!org) {
      throw BoxAppAPIException('Organization must be an Object.')
    }

    const orgURL = api.getOrgBackendUrl(org, 'wp')
    const url = `${orgURL}media/${mediaID}`
    const response = await axios.get(url)

    return response.data
  }
}

export default MediaAPIClient
