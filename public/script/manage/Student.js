const path = "/manage/student";

const addForm = document.getElementById("addStudentForm");
const updateForm = document.getElementById("updateStudentForm");
const updateBtsModal = new bootstrap.Modal("#updateStudentModal");
const updateModal = document.getElementById("updateStudentModal");


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
function deleteStudent(id) {

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
      fillDataToModal(response.data.data);
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
  const {maSinhVien, hoTen, tenLop, ngaySinh, gioiTinh, sdt, avatar} = data;

    const modalTitle = updateModal.querySelector('.modal-title');
    const msvInput = updateModal.querySelector('.msv-input');
    const nameInput = updateModal.querySelector('.name-input');
    const tenLopInput = updateModal.querySelector('.tenLop-select');
    const dateInput = updateModal.querySelector('.date-input');
    const gioiTinhSelect = updateModal.querySelector('.gender-select');
    const sdtInput = updateModal.querySelector('.sdt-input');

    modalTitle.textContent = `SỬA THÔNG TIN SINH VIÊN ${maSinhVien}`;
    msvInput.value = maSinhVien;
    nameInput.value = hoTen;
    tenLopInput.value = tenLop;
    dateInput.value = ngaySinh;
    gioiTinhSelect.value = gioiTinh;
    sdtInput.value = sdt;
}

