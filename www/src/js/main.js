let canvas = document.getElementById("photo");

let pizza = document.getElementById("pizza");
// console.log(canvas.getContext("2d"));
let context = canvas.getContext("2d");


document.body.onload = drawCanvas;

function drawCanvas() {

//     //TODO: create feature: adding text to picture
    if (canvas.getContext) {

        let context = canvas.getContext("2d");
        //
        pizza.addEventListener("dragstart", dragStart);
        pizza.addEventListener("dragend", dragEnd);
        //
        let pizzaImg = new Image();
        pizzaImg.src = "img/pizza.png";
        //
        let coordsInitPizza = getCoordsPizza(pizza);
        let coordsCanvas = getCoordsCanvas(canvas);
        //
        // context.drawImage(pizzaImg, 300, 400, 150, 150);
        // console.log(context);

        pizza.addEventListener("click", function () {
            pizza.style.top = coordsCanvas.top * 2.5 + "px";
            pizza.style.left = coordsCanvas.left * 1.8 + "px";

        });

        function drawPizza(image, context) {
            let coordsPizza = getCoordsPizza(pizza);
            let top = coordsPizza.top - coordsCanvas.top + 2;
            let left = coordsPizza.left - coordsCanvas.left + 2;
            context.drawImage(image, left, top, 147, 147);

            let btnTakePhoto = document.getElementById("takePhoto");

            if (top > 0 && left > 0 && left < 700 && top < 600) {
                btnTakePhoto.disabled = false;
            } else {
                pizza.style.top = coordsInitPizza.top + "px";
                pizza.style.left = coordsInitPizza.left + "px";
                btnTakePhoto.disabled = true;
            }

            // setTimeout(drawPizza, 10, image, context);
        }

        function getCoordsPizza(elem) {
            let stylesPizza = window.getComputedStyle(elem);
            return {
                top: parseInt(stylesPizza.top),
                left: parseInt(stylesPizza.left)
            };
        }

        function getCoordsCanvas(elem) {
            let coords = elem.getBoundingClientRect();
            return {
                top: coords.top,
                left: coords.left
            }
        }

        function dragStart() {
            setTimeout(() => (this.className = 'invisible'), 0);
        }

        function dragEnd(e) {
            this.className = "empty";
            pizza.className = "fill";

            pizza.style.zIndex = "1000";

            let stylesPizza = window.getComputedStyle(pizza);
            pizza.style.left = e.pageX - parseInt(stylesPizza.width) / 2 + "px";
            pizza.style.top = e.pageY - parseInt(stylesPizza.height) / 2 + "px";
            // context.putImageData(pizzaImg, )
            // drawPizza(pizzaImg, context);
        }


        canvas.addEventListener("dragover", dragOver);
        canvas.addEventListener("dragenter", dragEnter);
        canvas.addEventListener("dragleave", dragLeave);
        canvas.addEventListener("drop", dragDrop);

        function dragOver(e) {
            e.preventDefault();
        }

        function dragEnter(e) {
            e.preventDefault();
            this.className = "hover";
        }

        function dragLeave() {
            this.className = "empty";
        }

        function dragDrop() {
            this.className = "empty";
        }

        //stream video
        const video = document.createElement('video');

        navigator.getMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia;

        navigator.getMedia({
            video: true,
            audio: false
        }, function (stream) {
            video.srcObject = stream;
            video.play();
        }, function (error) {
            //
        });

        video.addEventListener("play", function () {
            drawVideo(this, context, 800, 600);

        }, false);


        function drawVideo(video, context, width, height) {
            context.drawImage(video, 0, 0, width, height);


            drawPizza(pizzaImg, context);

            // drawPsyDuck(psyDuck, context);
            setTimeout(drawVideo, 10, video, context, width, height);
        }

    } else {
        console.log("Couldn't get context from canvas element");
    }
}

function drawOnHiddenCanvas() {
    let hiddenCanvas = document.getElementById("hidden");

    hiddenCanvas.style.display = "block";

    let contextHidden = hiddenCanvas.getContext("2d");
    let imgData = context.getImageData(0, 0, 800, 600);

    let gallery = document.getElementById("gallery");
    let imgTag = document.createElement("img");

    imgTag.src = canvas.toDataURL("image/png");
    imgTag.width = 300;
    imgTag.height = 300;

    gallery.appendChild(imgTag);

    contextHidden.putImageData(imgData, 0, 0);

    let btnSaveLocally = document.getElementById("saveImg");
    btnSaveLocally.style.display = "inline";

    let btnSaveToProfile = document.getElementById("btnSaveToBase");
    btnSaveToProfile.style.display = "inline";
}

function saveImageToBase() {
    let hiddenCanvas = document.getElementById("hidden");
    document.getElementById("image").value = hiddenCanvas.toDataURL("image/png");
    document.forms["saveToBase"].submit();
}

function saveLocally() {
    let hiddenCanvas = document.getElementById("hidden");

    let buttonSave = document.getElementById("saveImg");
    buttonSave.addEventListener("click", function (e) {
        let img = hiddenCanvas.toDataURL("image/png");
        buttonSave.href = img;
    });
}
