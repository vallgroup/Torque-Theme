// @flow
import type { AxiosPromise } from 'axios'
import type { WorldType } from '../src/flow-typed/world_types'
import type { BoxAppResponse } from './flow-typed/response_types'
import axios from 'axios'
import api from './index'
import BoxAppValidation from './axios/validations'
import { BoxAppAPIException, badWorldID } from './exceptions/api_exceptions'

class WorldAPIClient {
  authentication: string

  constructor (base64Auth: string) {
    this.authentication = base64Auth
  }

  static vrUrl = api.vrRoot;

  static normalizeWorld(world) {
    if ('object' === typeof world.tooltips
      && 0 < Object.keys(world.tooltips).length) {
      // normalize tooltips, they should be an array
      world.tooltips = this.objectToArray(world.tooltips)
    }

    if ('object' === typeof world.nav_buttons
      && 0 < Object.keys(world.nav_buttons).length) {
      // normalize nav_buttons, they should be an array
      world.nav_buttons = this.objectToArray(world.nav_buttons)
    }

    return world;
  }

  static objectToArray(object) {
    let _array = []
    for (var i in object) {
      _array = [..._array, object[i]]
    }
    return _array;
  }

  /**
   * Provided the world ID, this function retrieves a world from the database.
   * All worlds are public so no need to check user permissions here.
   */
  static async getWorld (
    worldId: number,
    token: string
  ): AxiosPromise<BoxAppResponse<{ world: WorldType | false }>> {
    if (!worldId) {
      throw BoxAppAPIException(badWorldID(worldId))
    }

    const headers = token ? api.getAuthorizedGetRequestHeaders(token) : {}

    const url = `${api.worldCollectionURL}${worldId}`

    const response = await axios.get(url, {headers})

    if (response.data
      && true === response.data.success
      && response.data.world) {
      return this.normalizeWorld(response.data.world)
    }

    throw new BoxAppAPIException('No world was found')
  }

  static async getWorldList (args: {
    ids?: Array<number>,
    author?: number,
    perPage?: number,
    page?: number,
    cat: Array<number>,
    status?: Array<string>
  }
  ): AxiosPromise<BoxAppResponse<{ worlds: Array<WorldType> }>> {
    // const url = api.worldCollectionURL
    const {
      ids,
      author,
      perPage,
      page,
      cat,
      status
    } = args;
    const params = {}
    if (ids) params['ids'] = ids;
    if (author) {
      params['author'] = author;
      params['status'] = ['publish', 'draft'];
    }
    params['per_page'] = perPage || -1;
    if (perPage && -1 !== perPage) {
      params['page'] = page || 1;
    }
    if (cat) {
      params['cat'] = cat.join(',');
    }
    if (status) {
      params['status'] = status
    }

    const url = api.parseURLRequest(`${api.worldCollectionURL}`, params)
    const response = await axios.get(url);

    if (response.data
      && true === response.data.success
      && response.data.worlds) {

      const _worlds = response.data.worlds.map((world, i) => {
        return this.normalizeWorld(world)
      })

      const _response = {
        worlds: _worlds,
        pagination: response.data.pagination
      }
      return _response
    }

    throw new BoxAppAPIException('No worlds were found')
  }

  static async searchWorlds (args: {
    keywords?: string,
  }): AxiosPromise<BoxAppResponse<{ worlds: Array<WorldType> }>> {

    const params = {
      order: 'ASC',
      orderby: 'title'
    }
    if (args.keywords) params['keywords'] = args.keywords;
    if (args.cat) params['cat'] = args.cat.join(',');

    const url = api.parseURLRequest(`${api.worldCollectionURL}search`, params)
    const response = await axios.get(url);

    if (undefined !== response.data
      && true === response.data.success
      && response.data.worlds) {
      const __worlds = response.data.worlds.map((world, i) => {
        return this.normalizeWorld(world)
      })

      return {
        worlds: __worlds,
        count: response.data.count
      }
    }

    throw new BoxAppAPIException('No worlds were found')
  }

  /**
   * create or edit a world. If id is 0 a new world is created.
   * If id is greater than 0 the world is updated.
   * To make changes to a world we must check user permissions.
   */
  async updateWorld (
    worldId: number,
    worldData: {
      name: string,
      description?: string
    },
  ): AxiosPromise<BoxAppResponse<{ worldId: number }>> {
    if (!worldId) {
      throw BoxAppAPIException(badWorldID(worldId))
    }

    const url = api.parseURLRequest(`${api.worldCollectionURL}${worldId}?timestamp=${new Date().getTime()}`, {})
    const headers  = api.getPostRequestHeaders(this.authentication)
    const response = await axios.post(url, worldData, {headers})

    return response
  }


  async updateWorldAdvancedSettings (
    worldId: number,
    settings: {
      tripod_watermark_size?: number,
      initial_position?: string,
      auto_rotate?: string,
    },
  ): AxiosPromise<BoxAppResponse<{ worldId: number }>> {
    if (!worldId) {
      throw BoxAppAPIException(badWorldID(worldId))
    }

    const url = api.parseURLRequest(`${api.advancedSettingsURL}${worldId}?timestamp=${new Date().getTime()}`, {})
    const headers  = api.getPostRequestHeaders(this.authentication)
    const response = await axios.post(url, settings, {headers})

    return response.data
  }

  /**
   * @param  {object} pass a world object, just as you would create it in the backend:
   *    Example: -- {
   *      user_id: number,
   *      name: string,
   *      description: string,
   *      pano_media: File object,
   *    }
   * @return {[Promise]}
   */
  async createWorld(worldObj) {

    BoxAppValidation.validateNewWorld(worldObj)

    const url      = api.parseURLRequest(`${api.worldCollectionURL}0`,{})
    const headers  = api.getPostRequestHeaders(this.authentication)

    const response = await axios.post(url, worldObj, {headers})

    return response
  }

  /**
   * delete a world from the datbase. We need to check for user permissions here.
   */
  deleteWorld (worldId: number): AxiosPromise<BoxAppResponse<{}>> {
    if (!worldId) {
      throw BoxAppAPIException(badWorldID(worldId))
    }

    const url = `${api.worldCollectionURL}${worldId}`

    return axios.delete(url, {
      headers: api.getDeleteRequestHeaders(this.authentication)
    })
  }
}

export default WorldAPIClient
