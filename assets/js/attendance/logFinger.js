$(function() {
  if (Dropzone !== undefined) {
    Dropzone.autoDiscover = false;

    var fileUpload = new Dropzone(".dropzone", {
      url: "attendance/importAttendance_logfingers/uploadFile",
      maxFilesize: 2,
      createImageThumbnails: false,
      method: "post",
      acceptedFiles: ".xls,.xlsx",
      paramName: "userfile",
      dictInvalidFileType: "Type file ini tidak dizinkan",
      addRemoveLinks: true,
      maxFiles: 1,
      init: function() {
        this.on("sending", function(file, xhr, data) {
          App.alertDialog(
            "Notifikasi",
            "Harap tunggu sedang proses data di server"
          );
          /*if (file.fullPath) {
            data.append("fullPath", file.fullPath);
          }*/
        });
        this.on("error", function(file, message, xhr) {
          if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
          App.alertDialog("Notifikasi", message);
        });
      },
      success: function(file, response) {
        if (response.status) {
          /*$("input[name=file_name]").val(file.name);
          $("input[name=attachment]").val(response.attachment);
          $("#divTableJadwal")
            .html(response.content)
            .promise()
            .done(function() {
              $(document).trigger("stickyTable");
            });
           */
        } else {
          App.alertDialog("Notifikasi", response.message.join("<br />"));
          this.removeFile(file);
        }
      }
    });
  }

  //Event ketika Memulai mengupload
  /*fileUpload.on("sending", function(a, b, c) {
        a.token = Math.random();
        c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    });*/
});
