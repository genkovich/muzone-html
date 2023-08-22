import '../styles/app.scss';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import svg4everybody from 'svg4everybody';

import 'jquery-validation';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import ScrollToPlugin from 'gsap/ScrollToPlugin';
import Swiper, { Navigation } from 'swiper';
import { Quad } from "gsap/gsap-core";
import { Fancybox } from '@fancyapps/ui';
import "@fancyapps/ui/dist/fancybox/fancybox.css";

import { Circ } from "gsap/gsap-core";

import { commonInit } from './common.js';
import { animationInit } from './animation.js';
import { formInit } from './form.js';

import './contactForm.js';

const imagesContext = require.context('../img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
const images = imagesContext.keys().reduce((images, key) => {
    images[key.replace('./', '')] = imagesContext(key);
    return images;
}, {});

window.images = images;

$(document).ready(() => {
    require('jquery-lazy');
    require('jquery-lazy/plugins/jquery.lazy.picture');
    require('../js/libs/scroll.js');
    require('../js/libs/jquery.maskedinput.min.js');
    require('@emretulek/jbvalidator');
    animationInit(gsap, ScrollToPlugin, ScrollTrigger, Quad, jQuery);
    commonInit(jQuery, svg4everybody, Fancybox, Swiper, Navigation, gsap, Circ, Quad);
    formInit(jQuery);
});





