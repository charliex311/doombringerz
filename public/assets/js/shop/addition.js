let loginModal = document.getElementById("loginModal");
let lmodal = document.getElementById("lmodal");
let lmodal3 = document.getElementById("lmodal3");
let lclose = document.getElementById("lclose");
if (lmodal) {
  lmodal.onclick = function () {
    loginModal.classList.add('modal-target');
  }
  lmodal3.onclick = function () {
    resetModal.classList.remove('modal-target');
    loginModal.classList.add('modal-target');
  }
  loginModal.onclick = function () {
    if (event.target == loginModal) {
      loginModal.classList.remove('modal-target');
    }
  }
  window.onclick = function (event) {
    if (event.target == loginModal) {
      loginModal.classList.remove('modal-target');
    }
  }
}

let resetModal = document.getElementById("resetModal");
let rmodal = document.getElementById("rmodal");
let rclose = document.getElementById("rclose");
if (rmodal) {
  rmodal.onclick = function () {
    loginModal.classList.remove('modal-target');
    resetModal.classList.add('modal-target');
  }
  resetModal.onclick = function () {
    if (event.target == resetModal) {
      resetModal.classList.remove('modal-target');
    }
  }
  window.onclick = function (event) {
    if (event.target == resetModal) {
      resetModal.classList.remove('modal-target');
    }
  }
}

let sellModal = document.getElementById("sellModal");
let slmodal = document.getElementById("slmodal");
let slclose = document.getElementById("slclose");
if (slmodal) {
  slmodal.onclick = function () {
    sellModal.classList.add('modal-target');
  }
  slclose.onclick = function () {
    sellModal.classList.remove('modal-target');
  }
  window.onclick = function (event) {
    if (event.target == sellModal) {
      sellModal.classList.remove('modal-target');
    }
  }
}


let createticket = document.getElementById("createticket");
if (slmodal) {
  createticket.onclick = function () {
    document.getElementById("ticketModal").style.display = "block";
  }
  document.getElementById("tclose").onclick = function () {
    document.getElementById("ticketModal").style.display = "none";
  }
}