import React, { memo, useMemo, useState } from "react";
import PropTypes from "prop-types";
import Filters from "./Filters";
import Posts from "./Posts";
import { useWPTerms, useWPPosts, useParentId } from "./hooks";
import { createRequestParams } from "./helpers";

const App = ({ site, postType, tax, parent, firstTerm, loopTemplate }) => {
  const [activeTerm, setActiveTerm] = useState(0);
  const updateActiveTerm = useMemo(
    () => termId => () => setActiveTerm(termId),
    []
  );

  const terms = useWPTerms(site, tax);
  const parentId = useParentId(terms, parent);

  const params = createRequestParams(tax, parentId, activeTerm);
  const posts = useWPPosts(site, activeTerm, firstTerm, postType, params);

  return terms?.length ? (
    <div className={"torque-filtered-loop"}>
      <Filters
        terms={terms}
        activeTerm={activeTerm}
        updateActiveTerm={updateActiveTerm}
        parentId={parentId}
      />
      <Posts posts={posts} loopTemplate={loopTemplate} parentId={parentId} />
    </div>
  ) : null;
};

export default memo(App);
