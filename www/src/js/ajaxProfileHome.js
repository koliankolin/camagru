let start = 0;
let offset = 5;
let reachedEnd = false;

// function checkAjax() {
//     loadAjaxComments();
//     loadAjaxLikes();
//     setTimeout(checkAjax, 1000);
// }

$(document).ready(function () {
    getData();
    // loadAjaxComments();
    // loadAjaxLikes();
    // checkAjax();
});

window.addEventListener("scroll", function () {
    if ($(window).scrollTop() === $(document).height() - $(window).height()) {
        getData();
        // loadAjaxComments();
        // loadAjaxLikes();
    }
});

function getData() {
    if (reachedEnd) {
        return;
    }

    $.ajax({
        type: "POST",
        url: "src/get-data-home.php",
        data: {
            getData: 1,
            start: start,
            offset: offset
        },
        dataType: "text",
        success: function (response) {
            console.log(response);
            if (response === "reachedEnd") {
                reachedEnd = true;
            } else {
                start += offset;
                // let images = document.getElementById("images");
                // images.innerHTML = response;

                $("#images").append(response);
            }
        },
        // done: function () {
        //     loadAjaxComments();
        //     loadAjaxLikes();
        // }
    })
}

// function addListenerComments (e) {
//     e.preventDefault();
//     $.ajax({
//         type: elem.getAttribute("method"),
//         url: elem.getAttribute("action"),
//         data: new URLSearchParams(Array.from(new FormData(elem))).toString(),
//         dataType: "json",
//         success: function (commentJson) {
//             let comments = document.getElementById("comments_" + commentJson.idBlock);
//             let commentElem = document.createElement("p");
//             let userLink = document.createElement("a");
//             userLink.href = "../index.php?" + commentJson.loginSentComment;
//             userLink.textContent = commentJson.loginSentComment;
//
//             commentElem.appendChild(userLink);
//
//             let textNode = document.createTextNode(", " + commentJson.commentText);
//
//             commentElem.appendChild(textNode);
//             comments.insertBefore(commentElem, comments.lastElementChild);
//
//             let commentInput = document.getElementById("comment_" + commentJson.idBlock);
//             commentInput.value = "";
//         }
//     });
// }


// ajax comments

// function loadAjaxComments() {
//     $(document).ajaxStop(function () {
//         let forms = document.getElementsByClassName("addComment");
//         for (let elem of forms) {
//             elem.removeEventListener("submit", function () { addListenerComments(elem) });
//             elem.addEventListener("submit", function () { addListenerComments(elem) });
//         }
//     });
// }
//
// // ajax likes
//
// function loadAjaxLikes() {
//     // $(document).ajaxComplete(function () {
//         let formsLike = document.getElementsByClassName("formLike");
//
//         for (let form of formsLike) {
//             form.addEventListener("submit", function (e) {
//                 e.preventDefault();
//                 $.ajax({
//                     type: form.getAttribute("method"),
//                     url: form.getAttribute("action"),
//                     dataType: "json",
//                     success: function (likeJson) {
//                         let divLikes = document.getElementById("likes_" + likeJson.blockId);
//                         let countLikesElem = document.getElementById("countLikes_" + likeJson.blockId);
//                         let countLikes = 0;
//                         if (!countLikesElem) {
//                             countLikesElem = document.createElement("p");
//                             countLikesElem.id = "countLikes_" + likeJson.blockId;
//                             divLikes.appendChild(countLikesElem);
//                         } else {
//                             countLikes = parseInt(countLikesElem.textContent);
//                         }
//                         let btnLike = document.getElementById("btnLike_" + likeJson.blockId);
//                         let newCountLikes = 0;
//
//                         if (countLikes === 0 || likeJson.action !== "delete") {
//                             newCountLikes = countLikes + 1;
//                             btnLike.className = "btn btn-primary";
//                         } else {
//                             newCountLikes = countLikes - 1;
//                             if (!newCountLikes) {
//                                 divLikes.removeChild(countLikesElem);
//                             }
//                             btnLike.className = "btn btn-outline-primary";
//                         }
//
//                         countLikesElem.innerText = newCountLikes.toString();
//                     }
//                 });
//             });
//         }
//     // });
// }


// delete photo

// let btnsDelete = document.getElementsByClassName("btnDelete");
// let frmsDelete = document.getElementsByClassName("frmDelete");
//
// for (let i = 0; i < frmsDelete.length; i++) {
//     let form = frmsDelete[i];
//     form.addEventListener("submit", function (e) {
//         e.preventDefault();
//         let response = confirm("Are you sure to delete this image?");
//         if (response) {
//             $.ajax({
//                 type: form.getAttribute("method"),
//                 url: form.getAttribute("action"),
//                 data: new URLSearchParams(Array.from(new FormData(form))).toString(),
//                 dataType: "text",
//                 success: function (blockId) {
//                     let divImage = document.getElementById("image_" + blockId);
//                     divImage.remove();
//                 }
//             });
//         }
//     });
// }