import React from 'react'
import TourScheduler from './components/TourScheduler'

const App = ({
  site,
  apiParams
}) => {

  return <TourScheduler apiParams={apiParams} />;
}

export default App
