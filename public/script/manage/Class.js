const path = "/manage/class";

const addForm = document.getElementById("addClassForm");
const updateForm = document.getElementById("updateClassForm");
const updateBtsModal = new bootstrap.Modal("#updateClassModal");
const updateModal = document.getElementById("updateClassModal");


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

// Thực hiện submit cho sửa tt lớp
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
function deleteClass(id) {

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
  const {maLop, tenLop, tenNganh, khoa} = data;

    const modalTitle = updateModal.querySelector('.modal-title');
    const maLopInput = updateModal.querySelector('.maLop-input');
    const tenLopInput = updateModal.querySelector('.tenLop-input');
    const tenNganhInput = updateModal.querySelector('.tenNganh-input');
    const khoaInput = updateModal.querySelector('.khoa-input');

    modalTitle.textContent = `SỬA THÔNG TIN LỚP ${tenLop}`;
    maLopInput.value = maLop;
    tenLopInput.value = tenLop;
    tenNganhInput.value = tenNganh;
    khoaInput.value = khoa;
}

