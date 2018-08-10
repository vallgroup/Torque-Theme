import '../scss/main.scss'

if (!global._babelPolyfill) {
  require('babel-polyfill')
}

jQuery(window).load(() => {
  jQuery('body').css(
    'background-image',
    `url('/wp-content/uploads/2018/08/shutterstock-219154477.jpg')`
  )
})
