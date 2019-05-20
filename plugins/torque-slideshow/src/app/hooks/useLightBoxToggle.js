import React, { useState, useEffect, useRef } from "react";

export default function useLightBoxToggle() {

	const [open, setOpen] = useState(false)

	const toggleLightBox = bool => setOpen(bool)

	return [open, toggleLightBox]
}
