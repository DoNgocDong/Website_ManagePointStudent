const path = "/manage/major";

const addForm = document.getElementById("addMajorForm");
const updateForm = document.getElementById("updateMajorForm");
const updateBtsModal = new bootstrap.Modal("#updateMajorModal");
const updateModal = document.getElementById("updateMajorModal");


// Thực hiện submit cho thêm lớp
addForm.addEventListener("submit", function(e) {
  e.preventDefault();
  let formData = new FormData(this);
  
  request().post(path + "/", formData)
    .then(response => {
      alert(response.data.message);
      location.reload();
    })
    .catch(error => {
      const statusCode = error.response.status;

      if(statusCode == 401) {
        alert(error.response.data.error);
        window.location.href = "/auth/login";
      }
      else if(statusCode == 400) {
        alert(error.response.data.message);
        location.reload();
      }
    });
});

// Thực hiện submit cho sửa tt 
updateForm.addEventListener("submit", function(e) {
  e.preventDefault();
  let formData = new FormData(this);
  const id = updateModal.getAttribute("dataId");

  request().post(path + "/update/" + id, formData)
    .then(response => {
      alert(response.data.message);
      location.reload();
    })
    .catch(error => {
      const statusCode = error.response.status;
      
      if(statusCode == 401) {
        alert(error.response.data.error);
        window.location.href = "/auth/login";
      }
      else if(statusCode == 400) {
        alert(error.response.data.message);
        location.reload();
      }
    });
});

//Hàm delete Lớp theo `maLop` truyền vào url
function deleteMajor(id) {

  request().delete(path + "/" + id)
    .then(response => {
      alert(response.data.message);
      location.reload();
    })
    .catch(error => {
      const statusCode = error.response.status;
      
      if(statusCode == 401) {
        alert(error.response.data.error);
        window.location.href = "/auth/login";
      }
      else if(statusCode == 400) {
        alert(error.response.data.message);
        location.reload();
      }
    });
  
}

function getDataById(id) {

  request().get(path + "/" + id)
    .then(response => {
      fillDataToModal(response.data.data[0]);
      updateModal.setAttribute("dataId", id);
      updateBtsModal.show(updateModal);
    })
    .catch(error => {
      const statusCode = error.response.status;
      
      if(statusCode == 401) {
        alert(error.response.data.error);
        window.location.href = "/auth/login";
      }
      else if(statusCode == 400) {
        alert(error.response.data.message);
        location.reload();
      }
    });
}


// util functions
function fillDataToModal(data) {
  const {maNganh, tenNganh} = data;

    const modalTitle = updateModal.querySelector('.modal-title');
    const maLopInput = updateModal.querySelector('.maNganh-input');
    const tenNganhInput = updateModal.querySelector('.tenNganh-input');

    modalTitle.textContent = `Sửa thông tin Ngành ${tenNganh}`;
    maLopInput.value = maNganh;
    tenNganhInput.value = tenNganh;
}

