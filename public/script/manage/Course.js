//URL tới course-manager router
const path = "/manage/course";

//get các thành phần (form, modal) từ page
const addForm = document.getElementById("addCourseform");
const updateForm = document.getElementById("updateCourseForm");
const updateBtsModal = new bootstrap.Modal("#updateCourseModal");
const updateModal = document.getElementById("updateCourseModal");


// Thực hiện submit cho thêm lớp
addForm.addEventListener("submit", function (e) {
  e.preventDefault();
  let formData = new FormData(this);

  request().post(path + "/", formData)
    .then(response => {
      alert(response.data.message);
      location.reload();
    })
    .catch(error => {
      console.error("Đã xảy ra lỗi:", error);
    });
});

// Thực hiện submit cho sửa tt môn
updateForm.addEventListener("submit", function (e) {
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

      if (statusCode == 401) {
        alert(error.response.data.error);
        window.location.href = "/auth/login";
      }
      else if (statusCode == 400) {
        alert(error.response.data.message);
        location.reload();
      }
    });
});


async function getDataById(id) {

  request().get(path + "/" + id)
    .then(response => {
      fillDataToModal(response.data.data);
      updateModal.setAttribute("dataId", id)
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

//Hàm delete Lớp theo `maLop` truyền vào url
function deleteCourse(id) {

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


// util functions
function fillDataToModal(data) {
  const { maMon, tenMon, tinChi, hocKy } = data;

  const modalTitle = updateModal.querySelector('.modal-title');
  const maMonInput = updateModal.querySelector('.maMon-input');
  const tenMonInput = updateModal.querySelector('.tenMon-input');
  const tinChiInput = updateModal.querySelector('.tinChi-input');
  const hocKyInput = updateModal.querySelector('.hocKy-input');

  modalTitle.textContent = `SỬA THÔNG TIN MÔN ${tenMon}`;
  maMonInput.value = maMon;
  tenMonInput.value = tenMon;
  tinChiInput.value = tinChi;
  hocKyInput.value = hocKy;
}
