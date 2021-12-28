//Menu toggle
let toggle = document.querySelector('.toggle');
let navigation = document.querySelector('.navigation');
let main = document.querySelector('.main');

toggle.onclick = function () {
    navigation.classList.toggle('active');
    main.classList.toggle('active');
}

//add hovered class in selected list item
let list = document.querySelectorAll('.navigation li:not(.hovered)');

function activeLinkAdd() {
    this.classList.add('hovered');
}
function activeLinkRemove() {
    this.classList.remove('hovered');
}
list.forEach((item) => {
    item.addEventListener('mouseenter', activeLinkAdd);
    item.addEventListener('mouseleave', activeLinkRemove);
});
    

//enable tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})