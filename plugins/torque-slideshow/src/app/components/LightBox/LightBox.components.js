import React from "react";
import styled from "styled-components";

export const LightBoxWrapper = styled.div`
  display: inline-block;
`

export const LightBoxDialogDiv = styled.div`
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999999999;

  opacity: ${props => props.open ? 1 : 0};
  visibility: ${props => props.open ? 'visible' : 'hidden'};

  transition: all 0.6s ease-in-out;
  background: #000;
`

export const LightBoxClose = styled.a`
  display: block;
  position: absolute;
  top: 30px;
  right: 20px;
  width: 2.5em;
  height: 2.5em;
  background: rgba(255, 255, 255, 0);
  text-align: center;
  z-index: 99999999;

  &:before,
  &:after {
    content: '';
    display: block;
    background: #fff;
    width: 2.5em;
    height: 1px;
    border-radius: 3px;
    position: absolute;
    top: 50%;
  }

  &:before {
    transform: rotate(-45deg);
    left: 0;
  }

  &:after {
    transform: rotate(45deg);
    right: 0;
  }
`

export const IframeWrapper  = styled.div`
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 999999;
`

export const Iframe360 = styled.iframe`
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
`


export const LightBoxControls = styled.div`
  display: block;
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 999999;
`

export const LightBoxControlsTab = styled.div`
  display: block;
  float: left;
  width: ${props => (100 / props.count)}%;
  box-sizing: border-box;
  text-align: center;
  padding: 0.5em 2em;
  background: ${props => props.active ? '#7caed2' : 'rgba(255, 255, 255, 0.95)'};
  color: ${props => props.active ? '#fff' : '#7caed2'};
  cursor: pointer;
`