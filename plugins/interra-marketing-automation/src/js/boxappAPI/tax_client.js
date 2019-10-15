// @flow
import axios from 'axios'
import api from './index'

export const getCategories = async (worldID: number): Promise => {

  const world_id = (worldID && 0 < worldID)
    ? {post: worldID}
    : {}

  const url = api.parseURLRequest(api.catsURL, world_id)

  const response = await axios.get(url)

  return response.data
}