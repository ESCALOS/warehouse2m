import './bootstrap';
import Swiper from 'swiper';
import { EffectCards } from 'swiper/modules';
// Cargar primera vez:
new Swiper('.mySwiper', {
    spaceBetween: 30,
      effect: "fade",
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
});
//Cargar al usar wire:navigate
document.addEventListener('livewire:navigated', () => {
    new Swiper('.mySwiper', {
        spaceBetween: 30,
      effect: "fade",
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
})
