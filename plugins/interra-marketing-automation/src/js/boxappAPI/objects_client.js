// @flow
import type { AxiosPromise } from 'axios'
import type { BoxAppResponse } from './flow-typed/response_types'
import axios from 'axios'
import api from './index'
import { BoxAppAPIException, badWorldID } from './exceptions/api_exceptions'

class ObjectsAPIClient {
  authentication: string

  constructor (base64Auth: string) {
    this.authentication = base64Auth
  }

  static async getObjects (
    worldId: number
  ): AxiosPromise<BoxAppResponse<{ tooltips: Array<ToolTip> }>> {
    if (!worldId) {
      throw BoxAppAPIException(badWorldID(worldId))
    }

    const url = api.objectsCollectionURL
    const params = {
      world_id: worldId
    }

    const response = await axios.get(api.parseURLRequest(url, params))

    return response.data.objects
  }

  async updateObject ( id: number,
    args: {
      world_id: number,
      title?: string,
      position?: string,
      rotate?: string,
      size?: string,
      lit?: number,
    }
  ): AxiosPromise<BoxAppResponse<{ id: number }>> {

    const url = `${api.objectsCollectionURL}${id}`

    const headers  = api.getPostRequestHeaders(this.authentication)
    const response = await axios.post(url, args, {headers})

    return response.data
  }

  async deleteObject (args: {
    id: number,
    world_id: number
  }): AxiosPromise<BoxAppResponse<{}>> {

    const url = `${api.objectsCollectionURL}${args.id}`

    const response = await axios.delete(url, {
      headers: api.getDeleteRequestHeaders(this.authentication)
    })

    return response.data
  }
}

export default ObjectsAPIClient
