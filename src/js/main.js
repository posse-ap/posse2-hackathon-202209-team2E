'use strict'
const cardClassList = document.querySelectorAll('.card')
const openModalClassList = document.querySelectorAll('.modal-open')
const closeModalClassList = document.querySelectorAll('.modal-close')
const overlay = document.querySelector('.modal-overlay')
const body = document.querySelector('body')
const modal = document.querySelector('.modal')
const modalInnerHTML = document.getElementById('modalInner')

// イベント一覧の各イベント名部分にクリックイベントを追加
for (let i = 0; i < openModalClassList.length; i++) {
  openModalClassList[i].addEventListener('click', (e) => {
    e.preventDefault()
    let eventId = parseInt(cardClassList[i].id.replace('event-', ''))
    openModal(eventId)
  }, false)
}

// モーダルを閉じるクリックイベント
for (var i = 0; i < closeModalClassList.length; i++) {
  closeModalClassList[i].addEventListener('click', closeModal)
}
overlay.addEventListener('click', closeModal)

// モーダルを開く動作
async function openModal(eventId) {
  try {
    const url = '/api/getModalInfo.php?eventId=' + eventId
    const res = await fetch(url)
    const event = await res.json()

    let modalHTML = `
      <h2 class="text-md font-bold mb-3">${event.name}</h2>
      <p class="text-sm">${event.date}(${event.day_of_week})</p>
      <p class="text-sm">${event.start_at}~${event.end_at}</p>

      <hr class="my-4">

      <p class="text-md">
        ${event.message}
      </p>

      <hr class="my-4">

      <p class="text-sm w-20 mb-3 cursor-pointer" onclick="switchParticipantsDispInModal()"><span class="text-xl">${event.total_participants}</span>人参加</p>
      <div id="participantsArea" class="hidden">
    `
    // 参加者の名前を表示する部分
    event.participateView.forEach((user) => {
      modalHTML += `<p>${user.name}</p>`
    })
    modalHTML += `</div>`

    // 参加ステータスによって表示を切り替え
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


// モーダルを閉じる動作
function closeModal() {
  modalInnerHTML.innerHTML = ''
  toggleModal()
}

function toggleModal() {
  modal.classList.toggle('opacity-0')
  modal.classList.toggle('pointer-events-none')
  body.classList.toggle('modal-active')
}

// モーダル内の参加者の表示を切り替え
function switchParticipantsDispInModal() {
  const participantsArea = document.getElementById('participantsArea');
  participantsArea.classList.toggle('hidden');
}

// イベント一覧の参加者表示を切り替え
function switchParticipantsDisp(eventId) {
  const participantsArea = document.getElementById(`participantsArea${eventId}`);
  participantsArea.classList.toggle('hidden');
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

