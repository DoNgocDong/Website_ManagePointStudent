const path = "/auth";

const changePassForm = document.getElementById("changePassForm");

changePassForm.addEventListener("submit", function(e) {
  // e.preventDefault();
  let formData = new FormData(this);
  
  request().post(path + `/${username}/change-password`, formData)
    .then(response => {
      alert(response.data.message);
      location.href = "/";
    })
    .catch(error => {
      alert(error.response.data.message);
      location.reload();
    });
});