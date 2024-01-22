(() => {
    const form = document.getElementById("register-form");
    const inputs = document.querySelectorAll("input");
    const responseDiv = document.getElementById("response-message");

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        responseDiv.classList.remove("error");

        responseDiv.innerHTML = null;

        let data = {};
        inputs.forEach(input => {
            data[input.name] = input.value;
        });

        saveUser(data)
            .then((responseMessage) => {
                if (responseMessage["success"] === false) {
                    throw new Error(responseMessage["error"]);
                }
                else {
                    window.location.replace("../login/login.html");
                }
            })
            .catch((errorMsg) => {
                showError(responseDiv, errorMsg);
            });
    });
})();

// wherever it is TODO
const saveUser = async (data) => {
    const response = await fetch("'register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data)
    });
    const result = await response.json();
    return result;
};

const showError = (div, message) => {
    div.classList.add("error");
    div.classList.remove("hide");

    let messageContainer = document.createElement("span");
    let responseMessage = document.createElement("p");
    responseMessage.textContent = message;
    messageContainer.appendChild(responseMessage);

    div.appendChild(messageContainer);
};