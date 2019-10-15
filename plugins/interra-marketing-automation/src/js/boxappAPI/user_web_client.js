// @flow
import type { UserLogin, User } from '../src/flow-typed/user_types'
import axios from 'axios'
import { btoa } from 'Base64'
import api from './index'
// import UserAuthStorage from './asyncStorage/userAuth_storage'

const userSession = {}

/**
 * Private class methods
 */
function _newAuthentication (username: string, password: string): string {
  return _createBase64Auth(username, password)
}

function _createBase64Auth (username: string, password: string): string {
  return btoa(username + ':' + password)
}

/**
 * We'll want to save an instantiated version of this object
 * somewhere high up the app state
 * so it's always available to be interacted with.
 *
 * If we change user, we'll replace the state with a new instantiated object
 */
class UserAPIWebClient {
  authentication: string
  user: User

  constructor () {
    this.authentication = ''
    this.user = false
  }

  async initUser (): Promise<void> {
    this.authentication = userSession.token

    if (!this.authentication) {
      throw new Error('No token found')
    }
  }

  async login (newLogin: UserLogin): Promise<void> {
    const { username, password } = newLogin
    const url = `${api.wpAPIRoot}/users/me`
    const newAuth = _newAuthentication(username, password)

    // if we already have a token set we dont need a new one
    // unless we're logging in with a different username and password
    // then it will need to change
    if (!this.authentication || newAuth !== this.authentication) {
      this.authentication = newAuth
      // save token to local storage
      userSession.token = this.authentication;
    }

    const user = await axios.get(url, {
      headers: api.getAuthorizedGetRequestHeaders(this.authentication)
    })

    this.user = user.data
  }

  async backgroundLogin () {
    const url = `${api.wpAPIRoot}/users/me`
    if (!this.authentication) {
      return false
    }

    const user = await axios.get(url, {
      headers: api.getAuthorizedGetRequestHeaders(this.authentication)
    })

    this.user = user.data
  }

  async logout (): Promise<void> {
    // await UserAuthStorage.removeAuthToken()

    this.authentication = ''
    this.user = false
  }

  /**
   * return the current user id
   *
   * @return {int} the user id as an integer
   */
  getUser (): number {
    return this.user ? this.user.id : 0
  }

  getAuthentication (): string {
    return this.authentication
  }
}

export default UserAPIWebClient
