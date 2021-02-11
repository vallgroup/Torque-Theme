import React, { useRef, useEffect } from "react";
import { arrayContains, arrEmpty } from "../../helpers";

const NoPostsNotice = () => {
  return (
    <div className={"no-posts-found"}>
      {"No results found. Please try a different combination of filters."}
    </div>
  )
}

export default NoPostsNotice;
