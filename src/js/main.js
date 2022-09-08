'use strict'
const openModalClassList = document.querySelectorAll('.modal-open')
const closeModalClassList = document.querySelectorAll('.modal-close')
const overlay = document.querySelector('.modal-overlay')
const body = document.querySelector('body')
const modal = document.querySelector('.modal')
const modalInnerHTML = document.getElementById('modalInner')

for (let i = 0; i < openModalClassList.length; i++) {
  openModalClassList[i].addEventListener('click', (e) => {
    e.preventDefault()
    let eventId = parseInt(e.currentTarget.id.replace('event-', ''))
    openModal(eventId)
  }, false)
}

for (var i = 0; i < closeModalClassList.length; i++) {
  closeModalClassList[i].addEventListener('click', closeModal)
}

overlay.addEventListener('click', closeModal)


async function openModal(eventId) {
  try {
    const url = '/api/getModalInfo.php?eventId=' + eventId
    const res = await fetch(url)
    const event = await res.json()

    let modalHTML = `
      <h2 class="text-md font-bold mb-3">${event.name}</h2>
      <p class="text-sm">${event.date}（${event.day_of_week}）</p>
      <p class="text-sm">${event.start_at} ~ ${event.end_at}</p>

      <hr class="my-4">

      <p class="text-md">
        ${event.message}
      </p>

      <hr class="my-4">

      <p class="menu js-menu" onclick="toggle()">${event.total_participants}人</p>
    `
    event.participateView.forEach((user) => {
      modalHTML += `<div class="contents">${user.name}</div>`

    })
    
    
    switch (event.status) {
      case 'presence':
        modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-green-400">参加</p>
          </div>
          <div class="flex mt-5">
            <button id="participateButton" class="flex-1 bg-blue-500 pointer-events-none py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})">参加する</button>
            <button id="notParticipateButton" class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="notParticipateEvent(${eventId})">参加しない</button>
          </div>
        `
        break;
      case 'absence':
        modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-gray-300">不参加</p>
          </div>
          <div class="flex mt-5">
            <button id="participateButton" class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})">参加する</button>
            <button id="notParticipateButton" class="flex-1 bg-blue-500 pointer-events-none py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="notParticipateEvent(${eventId})">参加しない</button>
          </div>
        `
        break;
      default:
        modalHTML += `
          <div class="text-center mt-6">
            <p class="text-lg font-bold text-yellow-400">未回答</p>
            <p class="text-xs text-yellow-400">期限 ${event.deadline}</p>
          </div>
          <div class="flex mt-5">
          <button id="participateButton" class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})">参加する</button>
          <button id="notParticipateButton" class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="notParticipateEvent(${eventId})">参加しない</button>
          </div>
        `
        break;
    }
    modalInnerHTML.insertAdjacentHTML('afterbegin', modalHTML)
  } catch (error) {
    console.log(error)
  }
  toggleModal()
}



function closeModal() {
  modalInnerHTML.innerHTML = ''
  toggleModal()
}

function toggleModal() {
  modal.classList.toggle('opacity-0')
  modal.classList.toggle('pointer-events-none')
  body.classList.toggle('modal-active')
}

const menu = document.querySelectorAll(".js-menu");

function toggle() {
  const jsMenu = document.querySelector(".js-menu");
  const contents = document.querySelectorAll(".contents");
  jsMenu.classList.toggle("is-active");
  contents.forEach((content) =>{
    content.classList.toggle("is-open");
  })
  
}
for (let i = 0; i < menu.length; i++) {
  menu[i].addEventListener("click", toggle);
}

const participateButton = document.getElementById("participateButton")

async function participateEvent(eventId) {
  try {
    let formData = new FormData();
    formData.append('event_id', eventId)
    formData.append('status', 'presence')
    const url = '/api/postEventAttendance.php'
    await fetch(url, {
      method: 'POST',
      body: formData
    }).then((res) => {
      if (res.status !== 200) {
        throw new Error("system error");
      }
      return res.text();
    })
    closeModal()
    location.reload()
  } catch (error) {
    console.log(error)
  }
}
async function notParticipateEvent(eventId) {
  try {
    let formData = new FormData();
    formData.append('event_id', eventId)
    formData.append('status', 'absence')
    const url = '/api/postEventAttendance.php'
    await fetch(url, {
      method: 'POST',
      body: formData
    }).then((res) => {
      if (res.status !== 200) {
        throw new Error("system error");
      }
      return res.text();
    })
    closeModal()
    location.reload()
  } catch (error) {
    console.log(error)
  }
}

