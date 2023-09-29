import './bootstrap';
import Swiper from 'swiper';
import { EffectCards } from 'swiper/modules';
// Cargar primera vez:
new Swiper('.slider-grape', {
    effect: "cards",
    grabCursor: true,
    modules: [EffectCards]
});

new Swiper('.slider-grape', {
    effect: "cards",
    grabCursor: true,
    modules: [EffectCards]
});
//Cargar al usar wire:navigate
document.addEventListener('livewire:navigated', () => {
    new Swiper('.slider-grape', {
        effect: "cards",
        grabCursor: true,
        modules: [EffectCards]
    });

    new Swiper('.slider-grape', {
        effect: "cards",
        grabCursor: true,
        modules: [EffectCards]
    });
})
