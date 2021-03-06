import { useState, useEffect } from "react";
import axios from "axios";
import usePagination from "./usePagination";

export default (site, activeTerm, params, postsPerPage) => {
  const [page, getNextPage, setHasNextPage] = usePagination([params]);

  // request
  const [posts, setPosts] = useState([]);
  useEffect(
    () => {
      const getPosts = async () => {
        try {
          params["posts_per_page"] = postsPerPage;
          params["paged"] = page;

          const response = await axios.get(
            `${site}/wp-json/filtered-loop/v1/posts`,
            {
              params
            }
          );

          setHasNextPage(response?.data?.has_next_page);

          const newPosts = response?.data?.posts || [];
          return page > 1
            ? setPosts(posts => [...posts, ...newPosts])
            : setPosts(newPosts);
        } catch (e) {
          console.warn(e);
          setPosts([]);
        }
      };

      getPosts();
    },
    [site, params, activeTerm, page]
  );

  return { posts, getNextPage };
};
