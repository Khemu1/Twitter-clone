let restButton = document.querySelector(".delete-button");

restButton.addEventListener("click", () => {
  let value = restButton.value;
  restButton.value = value === "true" ? "false" : "true";
  if (restButton.value === "true") {
    restButton.textContent = "Reset";
  }
});

restButton.addEventListener("click", () => {
  if (restButton.textContent === "Reset") {
    toggleImg();
  }
});

document.querySelector(".writer-post").addEventListener("click", (event) => {
  if (event.target.classList.contains("delete-img")) {
    let img = document.querySelector(".post-img");
    let parent = document.querySelector(".writer-post");
    parent.removeChild(img);
    parent.removeChild(event.target);
  }
});

document.querySelector(".upload-img").addEventListener("change", function () {
  var file = this.files[0];
  console.log(file);
  if (file) {
    var reader = new FileReader();
    reader.onload = function (event) {
      let parent = document.querySelector(".writer-post");
      let imgElement = document.createElement("img");
      imgElement.classList.add("post-img");
      imgElement.src = event.target.result;
      imgElement.alt = "";
      imgElement.name = "post-img";
      parent.removeChild(document.querySelector(".post-img"));
      parent.appendChild(imgElement);
    };
    reader.readAsDataURL(file);
  }
});

function toggleImg() {
  let img = document.querySelector(".post-img");
  let textArea = document.querySelector(".text");
  let defaultImgPath = postImg;
  let defaultText = postText;
  if (img) {
    img.src = `http://localhost/twitter/assets/images/${defaultImgPath}`;
  } else {
    let parent = document.querySelector(".writer-post");
    let childImg = `<img class="post-img" src="../assets/images/${defaultImgPath}" alt="" name="post-img">`;
    let childButton = `<button class="delete-img">X</button>`;
    parent.innerHTML += childImg;
    parent.innerHTML += childButton;
  }
  textArea.value = defaultText;
}
