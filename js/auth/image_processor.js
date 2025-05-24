// imageProcessor.js

document.addEventListener("DOMContentLoaded", () => {
  const photoInput = document.getElementById("photo");
  const photoPreview = document.getElementById("photoPreview");

  photoInput.addEventListener("change", async () => {
    const file = photoInput.files[0];
    if (!file) return;

    const img = new Image();
    const reader = new FileReader();

    reader.onload = async function (e) {
      img.src = e.target.result;
    };

    img.onload = function () {
      const { width, height } = img;

      // Minimum resolution check
      if (width < 100 || height < 100) {
        alert("Image too small. Minimum size is 100x100 pixels.");
        photoInput.value = ""; // reset input
        photoPreview.style.display = "none";
        return;
      }

      // Compress and resize image
      const canvas = document.createElement("canvas");
      const maxSize = 500;
      let scale = Math.min(maxSize / width, maxSize / height, 1); // Don't upscale
      canvas.width = width * scale;
      canvas.height = height * scale;

      const ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

      canvas.toBlob(blob => {
        if (blob) {
          // Replace original file in FormData (requires handling on submit)
          const compressedFile = new File([blob], file.name, { type: "image/jpeg", lastModified: Date.now() });

          // Store in a global variable or attach to form for later
          photoInput.dataset.compressed = URL.createObjectURL(compressedFile);
          photoInput.compressedFile = compressedFile;

          // Preview the compressed image
          photoPreview.src = photoInput.dataset.compressed;
          photoPreview.style.display = "block";
        }
      }, "image/jpeg", 0.8); // 80% quality
    };

    reader.readAsDataURL(file);
  });
});
