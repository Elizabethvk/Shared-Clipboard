// function copyShareLink(clipId) {
//     navigator.clipboard.writeText(window.location.origin + "/src/view_clip/view_clip.php?clipId=" + clipId);
// }

function copyShareLink(clipId) {
    const shareLink = window.location.origin + "/src/view_clip/view_clip.php?clipId=" + clipId;
    navigator.clipboard.writeText(shareLink).then(function () {
        const userMessage = document.getElementById("user-message");
        userMessage.innerText = "Линкът за споделяне е копиран в клипборда!";
    }).catch(function (err) {
        console.error('Проблем с копирането на линка в клипборда!', err);
    });
}
