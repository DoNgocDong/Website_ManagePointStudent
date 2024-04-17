const path = "/auth";

const loginForm = document.getElementById("loginForm");

loginForm.addEventListener("submit", function(e) {
  e.preventDefault();
  let formData = new FormData(this);
  
  request().post(path + "/login", formData)
    .then(response => {
      alert(response.data.message);
      setSession(response.data.token);
      location.href = "/";
    })
    .catch(error => {
      alert(error.response.data.message);
      location.reload();
    });
});