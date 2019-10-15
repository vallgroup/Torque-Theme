// @flow
import axios from 'axios'
import api from './index'

export const getPagesBySlug = async (slug: string): Promise => {
  if (!slug) {
  	return
  }

  const page = await axios.get(
  	api.parseURLRequest(`${api.pagesURL}`, {_embedded: true, slug: slug})
  )

  return page.data
}