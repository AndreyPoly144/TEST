//ИЗМЕНЕНИЕ ПРОФИЛЯ
let btnReg=document.querySelector('#btn-edit');
let form=document.querySelector('form');
let message=document.querySelector('#message');
let tel=document.querySelector('input[name="tel"]');
function reg(e){
    e.preventDefault();

    //УСТАНАВЛИВАЕМ ПЕРЕДАВАЕМЫЕ ДАННЫЕ
    const data=new FormData(form);

    //ДЕЛАЕМ ЗАПРОС
    let xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            let response=xhttp.response;
            if (response.status==='success'){
                location.href='/TEST/profile.php';
            }else if(response.status==='error'){
                message.textContent=response.message;
                message.classList.remove('hidden');
                message.classList.add('err');
                let elemRed=document.querySelector(`input[name="${response.where}"]`);
                elemRed.classList.add('redinput');
                elemRed.addEventListener('change',()=>{
                    elemRed.classList.remove('redinput')
                    message.classList.add('hidden')
                })
            }
        }
    }
    xhttp.open('POST','/TEST/edit.php', true);
    xhttp.responseType='json';
    xhttp.send(data);
}

btnReg.addEventListener("click", reg);

//СОБЫТИЯ ДЛЯ ВВОДА ТЕЛ
tel.addEventListener('focus', ()=>{
    if(tel.value==''){
        tel.value='+7'}else{
        tel.value=tel.value
    }
})
tel.addEventListener('blur', ()=>{
    tel.value=tel.value;
})