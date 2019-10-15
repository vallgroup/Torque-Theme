// @flow
import type { AxiosPromise } from 'axios'
import axios from 'axios'
import api from './index'

class OrgAPIClient {
  authentication: string

  constructor (base64Auth: string) {
    this.authentication = base64Auth
  }

  static async getOrg(): AxiosPromise {

    const url = api.parseURLRequest(`${api.orgURL}`, {})
    const response = await axios.get(url)

    return response.data
  }

  /**
   * create or edit a world. If id is 0 a new world is created.
   * If id is greater than 0 the world is updated.
   * To make changes to a world we must check user permissions.
   */
  async updateOrg (
    args: {
      name: string,
    },
  ): AxiosPromise {

    const url = api.parseURLRequest(`${api.orgURL}`, {})
    const headers  = api.getPostRequestHeaders(this.authentication)
    const response = await axios.post(url, args, {headers})

    return response.data
  }

  async createOrg (
    args: {
      name: string,
      title: string,
      admin: number,
    },
  ): AxiosPromise {

    args.name = args.name.replace(/ /g, '');

    const url = api.parseURLRequest(`${api.orgURL}new`, {})
    const headers  = api.getPostRequestHeaders(this.authentication)
    const response = await axios.post(url, args, {headers})

    return response.data
  }

  async updateOrgSettings (
    args: {
      use_watermark?: boolean,
      use_tripod_watermark?: boolean,
    },
  ): AxiosPromise {

    const url = api.parseURLRequest(`${api.orgURL}settings`, args)
    const headers  = api.getPostRequestHeaders(this.authentication)
    const response = await axios.post(url, args, {headers})

    return response.data
  }
}

export default OrgAPIClient
