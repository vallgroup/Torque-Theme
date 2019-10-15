// @flow
import type { AxiosPromise } from 'axios'
import type { BoxAppResponse } from './flow-typed/response_types'
import type { ToolTip } from '../src/flow-typed/tooltip_types'
import axios from 'axios'
import api from './index'
import { BoxAppAPIException, badWorldID } from './exceptions/api_exceptions'

class TooltipAPIClient {
  authentication: string

  constructor (base64Auth: string) {
    this.authentication = base64Auth
  }

  static getTooltips (
    worldId: number
  ): AxiosPromise<BoxAppResponse<{ tooltips: Array<ToolTip> }>> {
    if (!worldId) {
      throw BoxAppAPIException(badWorldID(worldId))
    }

    const url = api.tooltipCollectionURL
    const params = {
      world_id: worldId
    }
console.log(api.parseURLRequest(url, params))
    return axios.get(api.parseURLRequest(url, params))
  }

  async updateTooltip (
    args: {
      id: number,
      world_id: number,
      name: string,
      description: string
    }
  ): AxiosPromise<BoxAppResponse<{ id: number }>> {
    if (!args.world_id) {
      throw BoxAppAPIException(badWorldID(args.world_id))
    }

    const url = api.parseURLRequest(api.tooltipCollectionURL, {})

    const headers  = api.getPostRequestHeaders(this.authentication)
    const response = await axios.post(url, args, {headers})

    return response
  }

  deleteTooltip (args: {
    id: number,
    world_id: number
  }): AxiosPromise<BoxAppResponse<{}>> {
    if (!args.world_id) {
      throw BoxAppAPIException(badWorldID(args.world_id))
    }

    const url = api.parseURLRequest(api.tooltipCollectionURL, args)

    return axios.delete(url, {
      headers: api.getDeleteRequestHeaders(this.authentication)
    })
  }
}

export default TooltipAPIClient
