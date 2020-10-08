//fonction pour afficher une image selectionné dans un input type="file"
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#image').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
// Paramétres animation titre
var textWrapper = document.querySelector('.ml10 .letters');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
anime.timeline({loop: true})
.add({
targets: '.ml10 .letter',
rotateY: [-110, 0],
duration: 1500,
delay: 500
}).add({
targets: '.ml10',
opacity: 0,
duration: 1000,
easing: "easeOutExpo",
delay: 15000
});
