// @flow
import type { AxiosPromise } from 'axios'
import type { BoxAppResponse } from './flow-typed/response_types'
import axios from 'axios'
import api from './index'
import { BoxAppAPIException, badWorldID } from './exceptions/api_exceptions'

class LightsAPIClient {
  authentication: string

  constructor (base64Auth: string) {
    this.authentication = base64Auth
  }

  static async getLights (
    worldId: number
  ): AxiosPromise<BoxAppResponse<{ tooltips: Array<ToolTip> }>> {
    if (!worldId) {
      throw BoxAppAPIException(badWorldID(worldId))
    }

    const url = api.lightsCollectionURL
    const params = {
      world_id: worldId
    }

    const response = await axios.get(api.parseURLRequest(url, params))

    return response.data.lights
  }

  async updateLights ( type: string,
    args: {
      world_id: number,
      intensity?: string
    }
  ): AxiosPromise<BoxAppResponse<{ type: string }>> {

    const url = `${api.lightsCollectionURL}${type}`

    const headers  = api.getPostRequestHeaders(this.authentication)
    const response = await axios.post(url, args, {headers})

    return response.data
  }

  async deleteLights (args: {
    id: number,
    world_id: number
  }): AxiosPromise<BoxAppResponse<{}>> {

    const url = `${api.lightsCollectionURL}${args.id}`

    const response = await axios.delete(url, {
      headers: api.getDeleteRequestHeaders(this.authentication)
    })

    return response.data
  }
}

export default LightsAPIClient
