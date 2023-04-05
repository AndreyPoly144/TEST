//АВТОРИЗАЦИЯ
let btnLog=document.querySelector('#btn-log');
let form=document.querySelector('form');
let message=document.querySelector('#message');

function log(e){
    e.preventDefault();

    //УСТАНАВЛИВАЕМ ПЕРЕДАВАЕМЫЕ ДАННЫЕ
    const data=new FormData(form);

    //ДЕЛАЕМ ЗАПРОС
    let xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log(xhttp);
            let response=xhttp.response
            if (response.status==='success'){
                location.href='/TEST/profile.php';
            }else if(response.status==='error'){
                message.textContent=response.message;
                message.classList.remove('hidden');
                message.classList.add('err');
                if (response.where==='recaptcha') {
                    grecaptcha.reset();
                }else{
                    let elemRed = document.querySelector(`input[name="${response.where}"]`);
                    elemRed.classList.add('redinput');
                    elemRed.addEventListener('change', () => {
                        elemRed.classList.remove('redinput')
                        message.classList.add('hidden')
                    })
                }
            }
        }
    }
    xhttp.open('POST','/TEST/signin.php', true);
    xhttp.responseType='json';
    xhttp.send(data);


}
btnLog.addEventListener("click", log);











