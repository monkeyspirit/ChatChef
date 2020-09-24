var today = new Date();
var hour = today.getHours();

var greetings;

if(hour<12){
    greetings = "Good Morning!";
}
else if(hour==12){
    greetings = "Time to eat!";
}
else{
    greetings = "Good Afternoon!";
}
document.write(greetings);