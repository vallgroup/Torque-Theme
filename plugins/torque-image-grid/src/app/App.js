import React, { memo, useMemo, useState } from 'react'
import useWPPosts from './hooks/useWPPosts'
import Grid from './components/Grid/Grid'
import { TorqueImageGrid } from './styles/styles'

const App = ({
  site,
  slug
}) => {
  const [grid] = useWPPosts(site, slug);

  return 0 < Object.entries(grid).length && grid.constructor === Object
    ? (<TorqueImageGrid>
        <Grid grid={grid} />
      </TorqueImageGrid>)
    : null;
};

export default memo(App)
