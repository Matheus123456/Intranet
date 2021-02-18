let imagens= document.querySelectorAll('.small_img');
let modal = document.querySelector('.modal_tes');
let modalImg = document.querySelector('#modal_img');
let btClose = document.querySelector('#bt_close');
let srcVal="";

for(let i =0; i<imagens.length;i++){
    imagens[i].addEventListener('click',function(){

        srcVal = imagens[i].getAttribute('src');
        modalImg.setAttribute('src', srcVal);
        modal.classList.toggle('modal_active');
        $('.navbar').css("display", "none");
    });

}

btClose.addEventListener('click', function(){
    modal.classList.toggle('modal_active');
    $('.navbar').css("display", "block");
});
