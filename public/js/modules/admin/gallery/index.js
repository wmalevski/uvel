"use strict"

// Form elements
const description = document.querySelector('[name="description"]')
const title = document.querySelector('input[name="title"]')

// Form events
const autoPoulateDescription = (e) => description.value = e.currentTarget.value;
title.addEventListener('change', (e) => autoPoulateDescription(e))

