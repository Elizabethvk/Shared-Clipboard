window.addEventListener('load', (event) => {
  event.preventDefault();

  // wherever it is TODO

  fetch('get-current-user.php', {
    method: "GET",
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.success && response.message === 'Current user info') {
        document.getElementById("first-name").innerHTML = "<b>Име: </b>" + response.value.firstName;
        document.getElementById("last-name").innerHTML = "<b>Фамилия: </b>" + response.value.lastName;
        document.getElementById("email").innerHTML = "<b>Имейл: </b>" + response.value.email;
        document.getElementById("specialty").innerHTML = "<b>Специалност: </b>" + response.value.specialty;
        document.getElementById("fn").innerHTML = "<b>Факултетен номер: </b>" + response.value.fn;
        document.getElementById("course").innerHTML = "<b>Курс: </b>" + response.value.course;
      }
      else if (response.message === "No current user") {
        redirect("../login/login.html");
      }
    });


  // we dun have this but yeah

  fetch('get-all-events-by-current-user.php', {
    method: "GET",
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.success && response.message === 'Events by current user') {
        response.value.forEach(event => {
          let sectionElement = document.createElement("a");
          sectionElement.setAttribute("id", "single-event");
          sectionElement.setAttribute("href", `../event/event.html?id=${event.id}`);
          sectionElement.setAttribute("target", "_blank");
          sectionElement.setAttribute("class", "single-event");
          let titleElement = document.createElement("p");
          titleElement.innerHTML = `<b>${event.name}</b>`;
          sectionElement.appendChild(titleElement);
          let dateElement = document.createElement("p");
          dateElement.innerText = event.startTime;
          sectionElement.appendChild(dateElement);
          document.getElementById("event-list").appendChild(sectionElement);
        });
      }
      else if (response.message === "No current user") {
        redirect("login.html");
      }
    });

  return false;

});

// we dun have it but shh
//adding events
const onFormSubmitted = (event) => {
  event.preventDefault();

  const formElement = event.target;

  const formData = {
    name: formElement.querySelector("input[name='name']").value,
    venue: formElement.querySelector("input[name='venue']").value,
    startTime: formElement.querySelector("input[name='startTime']").value,
    endTime: formElement.querySelector("input[name='endTime']").value,
    meetingLink: formElement.querySelector("input[name='meetingLink']").value,
    meetingPassword: formElement.querySelector("input[name='meetingPassword']").value
  };

  fetch("../../backend/endpoints/add-event.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json; charset=utf-8",
    },
    body: JSON.stringify(formData),
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.success) {
        document.getElementById("user-message").innerText = "Събитието е добавено успешно!";
        //location.replace("./welcome.php");
      } else {
        if (response.message === "No current user") {
          redirect("../login/login.html");
        }
        document.getElementById("user-message").innerText = response.message;
      }
    });

  return false;
};

document
  .getElementById("add-event-form")
  .addEventListener("submit", onFormSubmitted);

//working with the navigation
const profileBtn = document.getElementById('profile');

profileBtn.addEventListener('click', () => {
  redirect('../profile/profile.html');
});

const eventsBtn = document.getElementById('events');

eventsBtn.addEventListener('click', () => {
  redirect("../events/events.html");
});

const logoutBtn = document.getElementById('logout');

logoutBtn.addEventListener('click', () => {
  logout();
});

function logout() {
  fetch('../../backend/endpoints/logout.php', {
    method: 'GET'
  })
    .then(response => response.json())
    .then((response) => {
      if (!response.success) {
        throw new Error('Error logout user.');
      }
      redirect('../login/login.html');
    })
    .catch(error => {
      const message = 'Error logout user.';
      console.error(message);
    });
}

function redirect(path) {
  window.location = path;
}

