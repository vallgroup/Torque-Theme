// @flow
import type { AxiosPromise } from 'axios'
import type { BoxAppResponse } from './flow-typed/response_types'
import type { NavigationToolTip } from '../src/flow-typed/tooltip_types'
import axios from 'axios'
import api from './index'
import { BoxAppAPIException, badWorldID } from './exceptions/api_exceptions'

class NavButtonAPIClient {
  authentication: string

  constructor (base64Auth: string) {
    this.authentication = base64Auth
  }

  static getNavButtons (
    worldId: number
  ): AxiosPromise<BoxAppResponse<{ nav_buttons: Array<NavigationToolTip> }>> {
    if (!worldId) {
      throw BoxAppAPIException(badWorldID(worldId))
    }

    const url = api.navBtnCollectionURL
    const params = {
      world_id: worldId
    }

    return axios.get(api.parseURLRequest(url, params))
  }

  updateNavButton (
    args: {
      id: number,
      world_id: number,
      name?: string,
      description?: string,
      location_id?: number,
      headMatrix?: Array,
    }
  ): AxiosPromise<BoxAppResponse<{ id: number }>> {
    if (!args.world_id) {
      throw BoxAppAPIException(badWorldID(args.world_id))
    }

    const url = api.parseURLRequest(api.navBtnCollectionURL, args)

    return axios.post(url, {}, {
      headers: api.getPostRequestHeaders(this.authentication)
    })
  }

  deleteNavButton (args: {
    id: number,
    world_id: number
  }): AxiosPromise<BoxAppResponse<{}>> {
    if (!args.world_id) {
      throw BoxAppAPIException(badWorldID(args.world_id))
    }

    const url = api.parseURLRequest(api.navBtnCollectionURL, args)

    return axios.delete(url, {
      headers: api.getDeleteRequestHeaders(this.authentication)
    })
  }
}

export default NavButtonAPIClient
