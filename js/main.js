// var title;
// var teachС = 0;
// var err = 0;
// var titles = ["Налаштування профіля", "Профіль", "Статті", "Регістрація", "Вхід", "Опишіть себе"];
// var pageNames = ["profileSettings", "profile", "articles", "reg", "login", "whoAreYou"];

// for (let i = 0; i < titles.length; i++) {
//     if(document.location.pathname == "/html/" + pageNames[i] + ".html") {
//         document.title = titles[i];
//         title = titles[i];
//         break;
//     }
// }

// if (title == "Профіль" || title == "Налаштування профіля") {
//     setValueSettings();
// }

// document.getElementById("user-name").textContent = localStorage.getItem("name") || localStorage.getItem("login") || "Noname";

// function getValueSettings() {
//     localStorage.setItem("name", document.getElementById("name").value);
//     localStorage.setItem("surname", document.getElementById("surname").value);
//     localStorage.setItem("country", document.getElementById("country").value);
//     localStorage.setItem("city", document.getElementById("city").value);
//     localStorage.setItem("email", document.getElementById("email").value);
//     localStorage.setItem("phone", document.getElementById("phone").value);    
// }

// function setValueSettings() {
//     document.getElementById("name").textContent = " " + localStorage.getItem("name");
//     document.getElementById("surname").textContent = " " + localStorage.getItem("surname");
//     document.getElementById("country").textContent = " " + localStorage.getItem("country");
//     document.getElementById("city").textContent = " " + localStorage.getItem("city");
//     document.getElementById("email").textContent = " " + localStorage.getItem("email");
//     document.getElementById("phone").textContent = " " + localStorage.getItem("phone");

//     document.getElementById("name").value = localStorage.getItem("name");
//     document.getElementById("surname").value = localStorage.getItem("surname");
//     document.getElementById("country").value = localStorage.getItem("country");
//     document.getElementById("city").value = localStorage.getItem("city");
//     document.getElementById("email").value = localStorage.getItem("email");
//     document.getElementById("phone").value = localStorage.getItem("phone");
// }

// function checkInputs() {
//     var inputs = document.getElementsByClassName("form-control");
//     err = 0;
//     document.getElementById("err").style.display = "none";

//     for (let i = 0; i < inputs.length; i++) {
//         inputs[i].style.border = "none";
//     }
    
//     for (let i = 0; i < inputs.length; i++) {
//         if(inputs[i].value == "") {
//             inputs[i].style.border = "solid red 2px";
//             err++;
//         }
//     }

//     if(err <= 12 && title == "Опишіть себе" || err <= 0) {
//         if (title == "Налаштування профіля" || title == "Опишіть себе") {
//             getValueSettings();
//             document.location = "/html/profile.html";
//         }
//         else if (title == "Регістрація") {
//             document.location = "/html/whoAreYou.html";
//         } else {
//             document.location = "/html/profile.html";
//         }
//     } else {
//         document.getElementById("err").style.display = "block";    
//     }
// }

// function clickPupil() {
//     document.getElementById('panel').style.display = "none";
//     document.getElementById('panel-pupil').style.display = "block";
// }

// function clickTeacher() {
//     if (teachС == 0) {
//         document.getElementById('panel').style.display = "none";
//         document.getElementById('panel-teacher').style.display = "block";
//         getValueSettings();
//         teachС++;
//     } else {
//         document.getElementById('panel-teacher').style.display = "none";
//         document.getElementById('panel-teacher-2').style.display = "block";
//     }
// }