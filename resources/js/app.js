import './bootstrap';
import 'flowbite';
import '@fortawesome/fontawesome-free/js/all.js';

import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init({
    duration: 800,
    once: true,
    offset: 120,
    easing: 'ease-in-out',
});

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;
