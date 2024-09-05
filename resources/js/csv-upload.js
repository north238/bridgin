/**
 * CSVアップロードファイル名の制御
 */
function csvFileUploadName() {
  const uploadFile = document.getElementById("upload-file");
  const fileName = document.getElementById("file-name");

  uploadFile.addEventListener("change", () => {
    const uploadFileName = uploadFile.files[0].name;
    fileName.innerHTML = uploadFileName;
  });
}

document.addEventListener("DOMContentLoaded", function () {
    csvFileUploadName();
});