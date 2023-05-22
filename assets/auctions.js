import swal from 'sweetalert';

const aucts = document.querySelectorAll('#auctions .card')
const btns = document.querySelectorAll('.raise');

for(const btn of btns){
    btn.addEventListener('click',function(){

        const info = document.querySelector('.info-success');
        const n=0;
        console.log(info);
           
            if(typeof(info.firstElementChild) != undefined){
                const text = info.textContent
                console.log(info.firstElementChild);
                // swal(text);
            }
       
    

    })
}