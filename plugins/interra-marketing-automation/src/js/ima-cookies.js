
(function($) {

	const IMA_COOKIE_BANNER = 'imaCookieBanner';
	const IMA_COOKIE_GEO = 'imaCookieGeolocations';
	const IMA_COOKIE_USER = 'imaCookieVisitors';
	const IMA_COOKIE_DEVICE = 'imaCookieDevices';

	const encrypt = window.btoa;
	const decrypt = window.atob;

	const cookieArgs = {
		expires: 30,
		path: '/',
		domain: location.hostname || '',
		sameSite: 'strict',
		secure: ('https:' === location.protocol),
	}

	// gets the cookie, decrypts it, and parses it
	// as JSON, if there is a cookie present.
	var getCookie = (cookie) => {
		const __c = Cookies.get(cookie)
		// decrypt and parse cookie if not empty
		if (__c && '' !== __c) {
			return JSON.parse(decrypt(__c))
		}
		return null;
	}

	// sets and encrypts a cookie
	var setCookie = (cookie, value) => {
		const __encryptedValue = encrypt(JSON.stringify(value))
		Cookies.set(cookie, __encryptedValue, cookieArgs)
	}

	// delete a cookie
	var removeCookie = (cookie) => Cookies.remove(cookie)

	// adds a new cookie to a cookie array
	var addCookie = (cookie, value) => {
		const currentCookie = getCookie(cookie)
		if (currentCookie) {
			// console.log(currentCookie)
		} else {
			setCookie(cookie, value)
		}
	}

	var maybeStoreGeo = () => {
		if (getCookie(IMA_COOKIE_GEO)) return;
		if ('geolocation' in navigator) {
			navigator.geolocation.getCurrentPosition((pos) => {
				addCookie(IMA_COOKIE_GEO, {
					lat: pos.coords && pos.coords.latitude,
					lng: pos.coords && pos.coords.longitude,
					timestamp: pos.timestamp,
				})
			});
		}
	}

	var maybeStoreDevice = () => {
		if (getCookie(IMA_COOKIE_DEVICE)) return;
		let __device = {
			platform: navigator.appVersion,
			language: navigator.language,
			connection: navigator.connection
				&& navigator.connection.effectiveType
		}
		// save device info
		addCookie(IMA_COOKIE_DEVICE, __device)
	}

	var maybeStoreUser = () => {
		if (getCookie(IMA_COOKIE_USER)) return;
		let __user = {
			someData: 'coming soon'
		}
		// save device info
		addCookie(IMA_COOKIE_USER, __user)
	}

	// Display cookies banner if no cookie has been set
	var maybeDisplayCookieBanner = () => {
		if (getCookie(IMA_COOKIE_BANNER)) return;
		const userAgrees = confirm('This website uses cookies.')
		userAgrees && setCookie(IMA_COOKIE_BANNER, {userAgrees})
	}

	// initiate our cookies object
	var init = () => {
		maybeDisplayCookieBanner()
		// attempt to save our cookies
		maybeStoreGeo()
		maybeStoreDevice()
		maybeStoreUser()
	}

	var IMACookies = {
		init,
		encrypt,
		decrypt,
		getCookie,
		setCookie,
		maybeStoreGeo,
		maybeStoreDevice
	}

	$(window).load( IMACookies.init )

}(jQuery))
