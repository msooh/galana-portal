var currentTab = 0;
document.addEventListener("DOMContentLoaded", function(event) {
    showTab(currentTab);
});

function showTab(n) {
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }

    // If it's the anonymous select step and user selected "Remain Anonymous", show the submit button directly
    if (isAnonymous() && n == x.length - 2) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "inline";
    } else if (n == (x.length - 1)) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "inline";
    } else {
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("submitBtn").style.display = "none";
    }
    fixStepIndicator(n);
}

function nextPrev(n) {
    var x = document.getElementsByClassName("tab");
    if (n == 1 && !validateForm()) return false;

    x[currentTab].style.display = "none";
    currentTab = currentTab + n;

    // If moving forward and currentTab is the anonymous step and user selected "Remain Anonymous", skip the name and email step
    if (n == 1 && isAnonymous() && currentTab == 5) {
        currentTab++;
    }

    // If moving backward and currentTab is the anonymous step, revert to show the name and email step
    if (n == -1 && isAnonymous() && currentTab == 5) {
        currentTab--;
    }

    if (currentTab >= x.length) {
        document.getElementById("nextprevious").style.display = "none";
        document.getElementById("all-steps").style.display = "none";
        document.getElementById("register").style.display = "none";
    }
    showTab(currentTab);
}

function validateForm() {
    var x, y, valid = true;
    x = document.getElementsByClassName("tab");

    // Validate Suggestion Type (Step 1)
    if (currentTab == 0) {
        y = x[currentTab].getElementsByTagName("select")[0];
        if (y.value == "") {
            y.className += " invalid";
            valid = false;
        } else {
            y.classList.remove("invalid");
        }
    }

    // Validate Suggestion (Step 3)
    if (currentTab == 2) {
        y = x[currentTab].getElementsByTagName("textarea")[0];
        if (y.value.trim() == "") {
            y.className += " invalid";
            valid = false;
        } else {
            y.classList.remove("invalid");
        }
    }

    // Validate Name and Email (Step 5) if not anonymous
    if (currentTab == 5 && !isAnonymous()) {
        y = x[currentTab].getElementsByTagName("input");
        for (i = 0; i < y.length; i++) {
            if (y[i].value.trim() == "") {
                y[i].className += " invalid";
                valid = false;
            } else {
                y[i].classList.remove("invalid");
            }
        }
    }

    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid;
}

function fixStepIndicator(n) {
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    x[n].className += " active";
}

function isAnonymous() {
    var anonSelect = document.querySelector("select[name='anonymous']");
    return anonSelect && anonSelect.value === "Remain Anonymous";
}
