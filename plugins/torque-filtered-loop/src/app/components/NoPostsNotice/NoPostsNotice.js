import React, { useRef, useEffect } from "react";
import { arrayContains, arrEmpty } from "../../helpers";

const NoPostsNotice = ({ loopTemplate }) => {
  const postTypeLabel = 'template-4' === loopTemplate || 'template-5' === loopTemplate
    ? 'properties'
    : 'posts';
  return (
    <div className={"no-posts-found"}>
      {`We’re sorry. None of our ${postTypeLabel} match your selection. Try adjusting your filters to find what you’re looking for.`}
    </div>
  )
}

export default NoPostsNotice;
