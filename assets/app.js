import './styles/app.css';
import './styles/app.scss';
import './styles/landing/style.scss';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import svg4everybody from 'svg4everybody';

import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import ScrollToPlugin from 'gsap/ScrollToPlugin';
import Swiper from 'swiper';
import { Quad } from "gsap/gsap-core";
import { Fancybox } from '@fancyapps/ui';
import { Circ } from "gsap/gsap-core";

import { commonInit } from './landing/js/common.js';
import { animationInit } from './landing/js/animation.js';
import { formInit } from './landing/js/form.js';

import './landing/js/contactForm.js';

$(document).ready(() => {
    require('jquery-lazy');
    require('jquery-lazy/plugins/jquery.lazy.picture');
    require('./landing/libs/scroll.js');
    require('./landing/libs/jquery.maskedinput.min.js');
    require('@emretulek/jbvalidator');
    commonInit(jQuery, svg4everybody, Fancybox, Swiper, gsap, Circ);
    animationInit(gsap, ScrollToPlugin, ScrollTrigger, Quad, jQuery);
    formInit(jQuery, Fancybox);
});

const imagesContext = require.context('./landing/img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
const images = imagesContext.keys().reduce((images, key) => {
    images[key.replace('./', '')] = imagesContext(key);
    return images;
}, {});

window.images = images;
