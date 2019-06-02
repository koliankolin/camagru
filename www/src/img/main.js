let canvas = document.getElementById("photo");

let pizza = document.getElementById("pizza");
let psyDuck = document.getElementById("psyDuck");
let kyle = document.getElementById("kyle");
// console.log(canvas.getContext("2d"));
let context = canvas.getContext("2d");

let container = document.getElementsByTagName("header")[0];

let initHeight = window.innerHeight * 0.55;
let initWidth = container.clientWidth;
context.canvas.height = initHeight;
context.canvas.width = initWidth;


let localstream;
let vid;



document.body.onload = drawCanvas;

function drawCanvas() {

//     //TODO: create feature: adding text to picture
    if (canvas.getContext) {

        let context = canvas.getContext("2d");
        // ctx = context;
        //
        pizza.addEventListener("dragstart", dragStart);
        pizza.addEventListener("dragend", dragEndPizza);
        psyDuck.addEventListener("dragstart", dragStart);
        psyDuck.addEventListener("dragend", dragEndPsyduck);
        kyle.addEventListener("dragstart", dragStart);
        kyle.addEventListener("dragend", dragEndKyle);
        //
        let pizzaImg = new Image();
        pizzaImg.src = "img/pizza.png";
        let psyDuckImg = new Image();
        psyDuckImg.src = "img/psyduck.png";
        let kyleImg = new Image();
        kyleImg.src = "img/kyle.png";
        //
        let coordsInitPizza = getCoordsPizza(pizza);
        let coordsInitPsyDuck = getCoordsPizza(psyDuck);
        let coordsInitKyle = getCoordsPizza(kyle);
        //
        // context.drawImage(pizzaImg, 300, 400, 150, 150);
        // console.log(context);

        pizza.addEventListener("click", function () {
            pizza.style.top = 50 + context.canvas.offsetTop + "px";
            pizza.style.left = 50 + context.canvas.offsetLeft + "px";
        });

        psyDuck.addEventListener("click", function () {
            psyDuck.style.top = 150 + context.canvas.offsetTop + "px";
            psyDuck.style.left = 150 + context.canvas.offsetLeft + "px";
        });

        kyle.addEventListener("click", function () {
            kyle.style.top = 250 + context.canvas.offsetTop + "px";
            kyle.style.left = 250 + context.canvas.offsetLeft + "px";
        });


        function checkButton() {
            let btnTakePhoto = document.getElementById("takePhoto");

            let coordsPizza = getCoordsPizza(pizza);
            let topPizza = coordsPizza.top - context.canvas.offsetTop;
            let leftPizza = coordsPizza.left - context.canvas.offsetLeft;

            let coordsPsyDuck = getCoordsPizza(psyDuck);
            let topPsyDuck = coordsPsyDuck.top - context.canvas.offsetTop;
            let leftPsyDuck = coordsPsyDuck.left - context.canvas.offsetLeft;

            let coordsKyle = getCoordsPizza(kyle);
            let topKyle = coordsKyle.top - context.canvas.offsetTop;
            let leftKyle = coordsKyle.left - context.canvas.offsetLeft;

            function backFigure() {
                if (topPizza < 0 || leftPizza < 0 || leftPizza > initWidth
                    || topPizza > initHeight) {
                    pizza.style.top = coordsInitPizza.top + "px";
                    pizza.style.left = coordsInitPizza.left + "px";
                }
                if (topPsyDuck < 0 || leftPsyDuck < 0 || leftPsyDuck > initWidth
                    || topPsyDuck > initHeight) {
                    psyDuck.style.top = coordsInitPsyDuck.top + "px";
                    psyDuck.style.left = coordsInitPsyDuck.left + "px";
                }
                if (topKyle < 0 || leftKyle < 0 || leftKyle > initWidth
                    || topKyle > initHeight) {
                    kyle.style.top = coordsInitKyle.top + "px";
                    kyle.style.left = coordsInitKyle.left + "px";
                }
            }


            if (topPizza > 0 && leftPizza > 0 && leftPizza <= initWidth
                && topPizza <= initHeight ||
                topPsyDuck > 0 && leftPsyDuck > 0 && leftPsyDuck <= initWidth
                && topPsyDuck <= initHeight ||
                topKyle > 0 && leftKyle > 0 && leftKyle <= initWidth
                && topKyle <= initHeight) {
                btnTakePhoto.disabled = false;
                backFigure();
            } else {
                backFigure();
                btnTakePhoto.disabled = true;
            }
        }

        function drawPizza() {
            let coordsPizza = getCoordsPizza(pizza);
            let top = coordsPizza.top - context.canvas.offsetTop;
            let left = coordsPizza.left - context.canvas.offsetLeft;
            let widthPizza = parseInt(window.getComputedStyle(pizza).width);
            let heightPizza = parseInt(window.getComputedStyle(pizza).height);
            context.drawImage(pizzaImg, left, top, widthPizza, heightPizza);




            // setTimeout(drawPizza, 10, image, context);
        }
        function drawPsyDuck() {
            let coordsPizza = getCoordsPizza(psyDuck);
            let top = coordsPizza.top - context.canvas.offsetTop;
            let left = coordsPizza.left - context.canvas.offsetLeft;
            let widthPizza = parseInt(window.getComputedStyle(psyDuck).width);
            let heightPizza = parseInt(window.getComputedStyle(psyDuck).height);
            context.drawImage(psyDuckImg, left, top, widthPizza, heightPizza);

        }

        function drawKyle() {
            let coordsPizza = getCoordsPizza(kyle);
            let top = coordsPizza.top - context.canvas.offsetTop + 10;
            let left = coordsPizza.left - context.canvas.offsetLeft - 2;
            let widthPizza = parseInt(window.getComputedStyle(kyle).width);
            let heightPizza = parseInt(window.getComputedStyle(kyle).height);
            context.drawImage(kyleImg, left, top, widthPizza, heightPizza);

        }


        function getCoordsPizza(elem) {
            // let stylesPizza = elem.getBoundingClientRect();
            let stylesPizza = window.getComputedStyle(elem);
            return {
                top: parseInt(stylesPizza.top),
                left: parseInt(stylesPizza.left)
            };
        }

        function dragStart() {
            setTimeout(() => (this.className = 'invisible'), 0);
        }

        function dragEndPizza(e) {
            this.className = "empty";
            pizza.className = "fill";

            pizza.style.zIndex = "1000";

            let stylesPizza = window.getComputedStyle(pizza);
            pizza.style.left = e.pageX - parseInt(stylesPizza.width) / 2 + "px";
            pizza.style.top = e.pageY - parseInt(stylesPizza.height) / 2 + "px";
            // context.putImageData(pizzaImg, )
            // drawPizza(pizzaImg, context);
        }

        function dragEndPsyduck(e) {
            this.className = "empty";
            psyDuck.className = "fill";

            psyDuck.style.zIndex = "1200";

            let stylesPizza = window.getComputedStyle(psyDuck);
            psyDuck.style.left = e.pageX - parseInt(stylesPizza.width) / 2 + "px";
            psyDuck.style.top = e.pageY - parseInt(stylesPizza.height) / 2 + "px";
            // context.putImageData(pizzaImg, )
            // drawPizza(pizzaImg, context);
        }

        function dragEndKyle(e) {
            this.className = "empty";
            kyle.className = "fill";

            kyle.style.zIndex = "1300";

            let stylesPizza = window.getComputedStyle(kyle);
            kyle.style.left = e.pageX - parseInt(stylesPizza.width) / 2 + "px";
            kyle.style.top = e.pageY - parseInt(stylesPizza.height) / 2 + "px";
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
        let video = document.createElement('video');
        vid = video;
        navigator.getMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia;

        navigator.getMedia({
            video: true,
            audio: false
        }, function (stream) {
            localstream = stream;
            video.srcObject = stream;
            video.play();
        }, function () {

            let imageLoader = document.getElementById('imageLoader');
            imageLoader.disabled = false;
            imageLoader.style.display = "block";

            function handleImage(e){
                let context = canvas.getContext("2d");
                let reader = new FileReader();
                reader.onload = function(event){
                    let img = new Image();
                    img.onload = function(){
                        context.drawImage(img,0,0, canvas.width, canvas.height);
                        document.body.addEventListener("mouseover", function () {
                            drawPizza();
                            drawPsyDuck();
                            drawKyle();
                            checkButton();
                        }, false);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);

            }
            imageLoader.addEventListener('change', handleImage, false);
        });

        video.addEventListener("play", function () {
            drawVideo(this, context, canvas.width, canvas.height);

        }, false);


        function drawVideo(video, context, width, height) {
            context.drawImage(video, 0, 0, width, height);


            drawPizza();
            drawPsyDuck();
            drawKyle();
            checkButton();
            setTimeout(drawVideo, 10, video, context, width, height);
        }

    // } else {
    //     console.log("Couldn't get context from canvas element");
    }
}



function drawOnHiddenCanvas() {
    let hiddenCanvas = document.getElementById("hidden");
    let contextHidden = hiddenCanvas.getContext("2d");
    hiddenCanvas.style.display = "block";

    contextHidden.canvas.width = initWidth;
    contextHidden.canvas.height = initHeight;

    let imgData = context.getImageData(0, 0,
        initWidth,
        initHeight);

    let gallery = document.getElementById("gallery");
    let divImg = document.createElement("div");
    divImg.className = "card";

    let btnDelete = document.createElement("button");
    btnDelete.className = "btn btn-danger btn-block";
    btnDelete.textContent = "Delete Image";

    btnDelete.addEventListener("click", function () {
       divImg.remove();
    });

    let imgTag = document.createElement("img");

    imgTag.src = canvas.toDataURL("image/png");
    imgTag.style.width = "8vw";
    imgTag.style.height = "7vw";


    divImg.appendChild(imgTag);
    divImg.appendChild(btnDelete);


    gallery.appendChild(divImg);

    contextHidden.putImageData(imgData, 0, 0);

    let btnSaveLocally = document.getElementById("saveImg");
    btnSaveLocally.style.display = "inline-block";
    btnSaveLocally.style.marginTop = "1vw";
    btnSaveLocally.style.marginBottom = "1vw";

    let btnSaveToProfile = document.getElementById("btnSaveToBase");
    btnSaveToProfile.style.display = "block";
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

//ajax gallery

$(document).ready(function () {
    let gallery = document.getElementById("gallery");


});
