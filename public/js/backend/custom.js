// Initialize Dropzone
if (document.getElementById("my-dropzone")) {
    new Dropzone("#my-dropzone", {
        url: "/admin/upload",
        paramName: "file",
        maxFilesize: 10, // MB
        acceptedFiles: "image/*",
        parallelUploads: 1,
        addRemoveLinks: true,
        dictResponseError: "Server responded with error",
        dictFileTooBig: "File is too big (max 10MB)",
        dictInvalidFileType: "Invalid file type. Only images are allowed",
        dictRemoveFile: "Remove file",
        dictCancelUpload: "Cancel upload",
        autoProcessQueue: true,
    });
}
