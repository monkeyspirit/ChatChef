var today = new Date();
var hour = today.getHours();
var minute = today.getMinutes();

//Cambia la copertina in base all'ora

/*
if(hour>=4 && hour<10){
    cover = breakfast;
}
else if(hour>=10 && hour<12){
    cover = brunch;
}
else if(hour>=12 && hour<16){
    cover = lunch;
}
else if(hour>=16 && hour<18){
    cover = snack;
}
else if(hour>=18 && hour<22){
    cover = dinner;
}
else {
    cover = evening_snack;
}
*/

//Cambia la copertina in base ai minuti, cosi rendo piu veloce il tutto


if(minute>0 && minute<=10){
    if(window.screen.width < 760){
        cover = '<img src="image/covers/breakfast_cover-small_phone.jpg" class="d-block w-100 pb-5" alt="...">';
    }
    else{
        cover = '<img src="image/covers/breakfast_cover-small.jpg" class="d-block w-100 pb-5" alt="...">';
    }
}
else if(minute>10 && minute<=20){
    if(window.screen.width < 760){
        cover = '<img src="image/covers/brunch_cover-small_phone.jpg" class="d-block w-100 pb-5" alt="...">';
    }
    else{
        cover = '<img src="image/covers/brunch_cover-small.jpg" class="d-block w-100 pb-5" alt="...">';
    }
}
else if(minute>20 && minute<=30){
    if(window.screen.width < 760){
        cover = '<img src="image/covers/lunch_cover-small_phone.jpg" class="d-block w-100 pb-5" alt="...">';
    }
    else{
        cover = '<img src="image/covers/lunch_cover-small.jpg" class="d-block w-100 pb-5" alt="...">';
    }
}
else if(minute>30 && minute<=40){
    if(window.screen.width < 760){
        cover = '<img src="image/covers/snack_cover-small_phone.jpg" class="d-block w-100 pb-5" alt="...">';
    }
    else{
        cover = '<img src="image/covers/snack_cover-small.jpg" class="d-block w-100 pb-5" alt="...">';
    }
}
else if(minute>40 && minute<=50){
    if(window.screen.width < 760){
        cover = '<img src="image/covers/dinner_cover-small_phone.jpg" class="d-block w-100 pb-5" alt="...">';
    }
    else{
        cover = '<img src="image/covers/dinner_cover-small.jpg" class="d-block w-100 pb-5" alt="...">';
    }
}
else {
    if(window.screen.width < 760){
        cover = '<img src="image/covers/dinner_snack_cover-small_phone.jpg" class="d-block w-100 pb-5" alt="...">';
    }
    else{
        cover = '<img src="image/covers/dinner_snack_cover-small.jpg" class="d-block w-100 pb-5" alt="...">';
    }
}


document.getElementById('cover').innerHTML = cover;
