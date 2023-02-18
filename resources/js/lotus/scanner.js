import QrScanner from 'qr-scanner'

const $video = document.getElementById('scanner')
const $overlay = document.getElementById('result-overlay')
const $overlayShadow = document.getElementById('result-overlay-shadow')
const $overlayClose = document.getElementById('overlay-close')
const $overlayCheckIn = document.getElementById('overlay-check-in')

const qrScanner = new QrScanner($video, res => readScanResult(res.data), {
    highlightScanRegion: true,
})

qrScanner.start()
         .catch(err => {
             if (err.message === 'Scanner error: No QR code found') return

             console.error(err)
         })

let isLoaded = false

$overlayShadow.addEventListener('click', unloadScanResult)
$overlayClose.addEventListener('click', unloadScanResult)

let onCheckInClickHandler = null

/**
 *
 * @param {string} result
 * @returns {Promise<void>}
 */
async function readScanResult (result) {
    if (isLoaded) return
    isLoaded = true

    $overlayShadow.classList.remove('opacity-0')
    $overlayShadow.classList.add('opacity-80')

    const reservationId = Number.parseInt(result.at(16))
    const ticketNumber = Number.parseInt(result.at(18))

    let reservation = null

    // do a loading state here
    try {
        const res = await fetch(`/api/lotus/reservation/${reservationId}/${ticketNumber}`)
        reservation = await res.json()

        if (!reservation) throw new Error('Reservation not found')
    } catch (e) {
        console.error(e)
        alert(e.message)
        unloadScanResult()
    }

    loadReservationData(reservation, ticketNumber)
}

function loadReservationData (reservation, ticketNumber) {
    // add custom fields and reshape data
    reservation = {
        ...reservation.data,
        ticket_number: ticketNumber + 1,
        checked_in_time: new Intl.DateTimeFormat('default', {
            hour12: true, hour: 'numeric', minute: 'numeric'
        }).format(new Date(reservation.data.checked_in_at)),
    }

    $overlay.classList.remove('transform-none')

    const dataKeys = Object.keys(reservation)
    const isFieldAccepted = (getFieldClosure) => (data) => dataKeys.includes(getFieldClosure(data))

    /** @type {HTMLElement[]} */
    const dataConsumers = [...document.querySelectorAll('div[x-reservation-target] *[x-reservation-data]')]

    dataConsumers
        .filter(isFieldAccepted(el => el.getAttribute('x-reservation-data')))
        .forEach(el => {
            const field = el.getAttribute('x-reservation-data')
            el.innerText = reservation[field]
        })

    const dataIfConsumers = [...document.querySelectorAll('div[x-reservation-target] *[x-reservation-if]')]

    dataIfConsumers
        .filter(isFieldAccepted(el => el.getAttribute('x-reservation-if')))
        .forEach(el => {
            const field = el.getAttribute('x-reservation-if')

            if (reservation[field]) {
                el.classList.remove('hidden')
            } else {
                el.classList.add('hidden')
            }
        })

    const dataNotIfConsumers = [...document.querySelectorAll('div[x-reservation-target] *[x-reservation-not-if]')]

    dataNotIfConsumers
        .filter(isFieldAccepted(el => el.getAttribute('x-reservation-not-if')))
        .forEach(el => {
            const field = el.getAttribute('x-reservation-not-if')

            if (reservation[field]) {
                el.classList.add('hidden')
            } else {
                el.classList.remove('hidden')
            }
        })

    if (reservation.check_in_eligible) {
        onCheckInClickHandler = () => {
            $overlayCheckIn.classList.add('opacity-50')

            checkIn(reservation.id, ticketNumber)
                .then((data) => {
                    $overlayCheckIn.classList.remove('opacity-50')
                    loadReservationData(data, ticketNumber)
                })
                .catch(console.error)
        }

        $overlayCheckIn.addEventListener('click', onCheckInClickHandler)
    }
}

async function checkIn (reservationId, ticketNumber) {
    const res = await fetch(`/api/lotus/reservation/${reservationId}/${ticketNumber}/check-in`, {
        method: 'POST',
    })
    return await res.json()
}

function unloadScanResult () {
    $overlay.classList.add('transform-none')
    $overlayShadow.classList.remove('opacity-80')
    $overlayShadow.classList.add('opacity-0')

    if (onCheckInClickHandler) {
        $overlayCheckIn.removeEventListener('click', onCheckInClickHandler)
        onCheckInClickHandler = null
    }

    isLoaded = false
}
