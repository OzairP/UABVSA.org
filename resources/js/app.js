import Sparticles from 'sparticles'
import countItDown from 'count-it-down'

new Sparticles(document.querySelector('.landing'),
    {
        'composition': 'source-over',
        'count': 400,
        'speed': 0.1,
        'parallax': 3,
        'direction': 0,
        'xVariance': 150,
        'yVariance': 100,
        'rotate': true,
        'rotation': 1,
        'alphaSpeed': 5,
        'alphaVariance': 1,
        'minAlpha': 0,
        'maxAlpha': 0.5,
        'minSize': 1,
        'maxSize': 8,
        'style': 'fill',
        'bounce': false,
        'drift': 1.6,
        'glow': 14,
        'twinkle': true,
        'color': ['#be0818',
            '#e18814'],
        'shape': 'diamond',
        'imageUrl': ''
    });

(function textEffect () {
    const $textEffect = document.querySelector('[x-target="letter-effect"]')

    if (!$textEffect) return

    const toInnerSpan = el => el === ' ' ? ' ' : `<span class="letter-effect__element">${el}</span>`
    $textEffect.innerHTML = $textEffect.innerHTML.split('').map(toInnerSpan).join('')
})();

(function countdownToLotus () {

    const lotusDate = new Date(2023, 2, 14, 19, 0, 0, 0)
    const $countdown = document.querySelector('[x-target="countdown"]')

    // countItDown(lotusDate, ({ days, hours, minutes, seconds }) => {
    //     $countdown.innerHTML = `
    //         <span class="countdown__element">${days}</span>
    //         <span class="countdown__element">${hours}</span>
    //         <span class="countdown__element">${minutes}</span>
    //         <span class="countdown__element">${seconds}</span>
    //     `.trim()
    // })

})();
