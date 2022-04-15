
const video = document.getElementById("video");
const canvas = document.getElementById("canvas");
const snap = document.getElementById("snap");
const upload = document.getElementById("upload");
const photo = document.getElementById("photo");

// Capture JAvascript Starts Window
(function($) {
const constraints = {
    video: {
        width: 1280,
        height: 720
    }
};
async function init() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        handleSuccess(stream);
    } catch (e) {
        errorMsgelement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
    }
}

function handleSuccess(stream) {
    window.stream = stream;
    video.srcObject = stream;
}
init();
var context = canvas.getContext('2d');
snap.addEventListener("click", function(e) {

    e.preventDefault();

    context.drawImage(video, 0, 0, 200, 200);
    var dataurl = canvas.toDataURL();
    $("#photo").val(dataurl);

    console.log(dataurl);
});   
    upload.addEventListener("click", function(e) {
    e.preventDefault();
        $.ajax({
            url: "/cap",
            type: 'POST',
            data: {
                'photo': $("#photo").val(),
            },
            success: function(res) {

                alert('form was submitted');

            }
        });

    });


    })(jQuery);

    upload.addEventListener('click', () => {
       upload.classList.add("green")
    })

 