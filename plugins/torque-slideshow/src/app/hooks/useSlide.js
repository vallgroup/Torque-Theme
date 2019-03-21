import { useState } from "react";
import useInterval from "./useInterval";

export default (length, interval) => {
  const [slide, setSlide] = useState(0);

  const incrementSlide = () => setSlide(Math.abs((slide + 1) % length));
  const decrementSlide = () => setSlide(Math.abs((slide - 1) % length));
  const createSetSlide = index => () => setSlide(index);

  useInterval(incrementSlide, parseInt(interval));

  return [slide, createSetSlide, incrementSlide, decrementSlide];
};
