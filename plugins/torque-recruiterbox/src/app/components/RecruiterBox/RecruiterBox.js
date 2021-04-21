import React, { useState, useEffect } from "react";

const RecruiterBox = ({ apiKeys, apiFilters }) => {
  // states
  const [isLoading, setIsLoading] = useState(false);
  const [openings, setOpenings] = useState();

  console.log('apiKeys', apiKeys);
  console.log('apiFilters', apiFilters);

  return null;
}

export default RecruiterBox
