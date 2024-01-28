function copyShareLink(clipId) {
    navigator.clipboard.writeText(window.location.origin + "/src/view_clip/view_clip.php?clipId=" + clipId);
}