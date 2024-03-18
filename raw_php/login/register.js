 document.addEventListener("DOMContentLoaded", function() {
    let input = document.getElementById("password");
    let letter = document.getElementById("letter");
    let capital = document.getElementById("capital");
    let number = document.getElementById("number");
    let length = document.getElementById("length");

    input.onfocus = function () {
        document.getElementById("message").style.display = "block";
    }
    input.onblur = function () {
        document.getElementById("message").style.display = "none";
    }


    input.onkeyup = function () {
        let lowerCaseLetters = /[a-z]/g;
        if (input.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        let upperCaseLetters = /[A-Z]/g;
        if (input.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        let numbers = /[0-9]/g;
        if (input.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        if (input.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
});





