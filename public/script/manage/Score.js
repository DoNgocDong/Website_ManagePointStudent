const path = "/manage/score";

const addForm = document.getElementById("addScoreForm");
const updateForm = document.getElementById("updateScoreForm");
const updateBtsModal = new bootstrap.Modal("#updateScoreModal");
const updateModal = document.getElementById("updateScoreModal");
const addModal = document.getElementById("addScoreModal");

document.addEventListener('DOMContentLoaded', function() {
  // Lấy tham chiếu đến select và input
  const selectMsv_C = addModal.querySelector('#cmbMsv');
  const selectMsv_U = updateModal.querySelector('#cmbMsv');

  const inputName_C = addModal.querySelector('#validateName');
  const inputName_U = updateModal.querySelector('#validateName');

  const inputClass_C = addModal.querySelector('#validateClass');
  const inputClass_U = updateModal.querySelector('#validateClass');

  const selectCourse_C = addModal.querySelector('#cmbMaMon');
  const selectCourse_U = updateModal.querySelector('#cmbMaMon');

  const inputTenMon_C = addModal.querySelector('#validateTenMon');
  const inputTenMon_U = updateModal.querySelector('#validateTenMon');

  const inputHocKy_C = addModal.querySelector('#validateHocKy');
  const inputHocKy_U = updateModal.querySelector('#validateHocKy');


  // Gán sự kiện "change" cho select để lắng nghe khi giá trị của select thay đổi
  selectMsv_C.addEventListener('change', function() {
    let msv = selectMsv_C.value;

    if(msv === "") {
      inputName_C.value = "";
      return;
    }

    request().get("/manage/student/" + msv)
      .then(response => {
        const data = response.data.data;
        inputName_C.value = data.hoTen;
        inputClass_C.value = data.tenLop;
      })
      .catch(error => {
        console.log("ERROR: " + error);
      })
  });
  selectMsv_U.addEventListener('change', function() {
    let msv = selectMsv_U.value;

    if(msv === "") {
      inputName_U.value = "";
      return;
    }

    request().get("/manage/student/" + msv)
      .then(response => {
        const data = response.data.data;
        inputName_U.value = data.hoTen;
        inputClass_U.value = data.tenLop;
      })
      .catch(error => {
        console.log("ERROR: " + error);
      })
  });

  selectCourse_C.addEventListener('change', function() {
    let maMon = selectCourse_C.value;

    if(maMon === "") {
      inputTenMon_C.value = "";
      inputHocKy_C.value = "";
      return;
    }

    request().get("/manage/course/" + maMon)
      .then(response => {
        const data = response.data.data;
        inputTenMon_C.value = data.tenMon;
        inputHocKy_C.value = data.hocKy
      })
      .catch(error => {
        console.log("ERROR: " + error);
      })
  });
  selectCourse_U.addEventListener('change', function () {
    let maMon = selectCourse_U.value;

    if (maMon === "") {
      inputTenMon_U.value = "";
      inputHocKy_U.value = "";
      return;
    }

    request().get("/manage/course/" + maMon)
      .then(response => {
        const data = response.data.data;
        inputTenMon_U.value = data.tenMon;
        inputHocKy_U.value = data.hocKy
      })
      .catch(error => {
        console.log("ERROR: " + error);
      })
  });
});


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
function deleteScore(id) {

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
  const {maSinhVien, hoTen, maMon, tenMon, diemCC, diemTH, diemGK, diemCK, hocKy} = data;

    const modalTitle = updateModal.querySelector('.modal-title');
    const msvInput = updateModal.querySelector('#cmbMsv');
    const nameInput = updateModal.querySelector('#validateName');
    const classInput = updateModal.querySelector('#validateClass');
    const maMonInput = updateModal.querySelector('#cmbMaMon');
    const tenMonInput = updateModal.querySelector('#validateTenMon');
    const diemCCInput = updateModal.querySelector('#diemCC');
    const diemTHInput = updateModal.querySelector('#diemTH');
    const diemGKInput = updateModal.querySelector('#diemGK');
    const diemCKInput = updateModal.querySelector('#diemCK');
    const hocKyInput = updateModal.querySelector('#validateHocKy');

    modalTitle.textContent = `SỬA ĐIỂM MÔN ${tenMon} CỦA ${hoTen}`;
    msvInput.value = maSinhVien;
    nameInput.value = hoTen;
    maMonInput.value = maMon;
    tenMonInput.value = tenMon;
    diemCCInput.value = diemCC;
    diemTHInput.value = diemTH;
    diemGKInput.value = diemGK;
    diemCKInput.value = diemCK;
    hocKyInput.value = hocKy;
}

