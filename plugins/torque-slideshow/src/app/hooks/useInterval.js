import React, { useState, useEffect, useRef } from "react";

export default function useInterval(callback, delay) {
  useEffect(
    () => {
      if (delay !== null && delay > 0) {
        let id = setInterval(callback, delay * 1000);
        return () => clearInterval(id);
      }
    },
    [callback, delay]
  );
}
